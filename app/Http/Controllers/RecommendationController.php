<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecommendationController extends Controller
{
    /**
     * Lightweight per-user recommendation entrypoint (legacy hybrid API).
     */
    public function userRecommendations(Request $request)
    {
        $payload = $request->json()->all() ?: [];
        $uid = null;
        try {
            if (auth()->check()) {
                $u = auth()->user();
                if (!empty($u->firebase_uid)) $uid = (string) $u->firebase_uid;
            }
        } catch (\Throwable $__e) {}

        if (!$uid) $uid = $request->input('uid') ?? ($payload['uid'] ?? null);
        if (!$uid && app()->environment('local')) {
            $uid = $request->input('uid') ?? ($payload['uid'] ?? null);
        }

        if (!$uid) {
            try { Log::info('userRecommendations: no uid provided, scheduling generation'); } catch (\Throwable $__l) {}
            if (class_exists('\App\Jobs\GenerateRecommendations')) {
                try { \App\Jobs\GenerateRecommendations::dispatch('anonymous', []); } catch (\Throwable $_e) {}
            }
            return response()->json(['status' => 'scheduled', 'message' => 'No uid resolved; generation scheduled.'], 202);
        }

        $force = $request->input('force') ? true : false;
        if ($force && class_exists('\App\Jobs\GenerateRecommendations')) {
            try {
                $job = new \App\Jobs\GenerateRecommendations($uid, $payload);
                $out = $job->runAndReturn();
                if ($out !== null) {
                    if (is_array($out) && array_key_exists($uid, $out)) return response()->json($out[$uid]);
                    if (is_array($out) && array_values($out) === $out) return response()->json($out);
                }
                return response()->json(['status' => 'scheduled', 'message' => 'Generation scheduled.'], 202);
            } catch (\Throwable $e) {
                Log::error('userRecommendations force run failed: ' . $e->getMessage());
                return response()->json(['error' => 'generation_failed', 'message' => $e->getMessage()], 500);
            }
        }

        if (class_exists('\App\Jobs\GenerateRecommendations')) {
            try { \App\Jobs\GenerateRecommendations::dispatch($uid, $payload); } catch (\Throwable $_e) {}
        }
        return response()->json(['status' => 'scheduled', 'message' => 'Recommendation generation scheduled for uid ' . $uid], 202);
    }

    /**
     * Bulk generation endpoint.
     */
    public function generateAll(Request $request)
    {
        try {
            $allowed = app()->environment('local') || in_array($request->ip(), ['127.0.0.1', '::1']);
            if (!$allowed) return response()->json(['error' => 'forbidden'], 403);
            if (!class_exists('\App\Jobs\GenerateRecommendations')) return response()->json(['error' => 'no_generator'], 500);
            $result = \App\Jobs\GenerateRecommendations::runForAllUsers();
            if ($result === null) return response()->json(['status' => 'failed'], 500);
            return response()->json(['status' => 'ok', 'users' => array_keys($result)]);
        } catch (\Throwable $e) {
            Log::error('generateAll failed: ' . $e->getMessage());
            return response()->json(['error' => 'exception', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Compact, bounded Oracle-backed hybrid recommendations endpoint.
     * - Uses public/db/oracledb.php (must not be edited)
     * - Returns JSON with 'mode' => 'hybrid' and 'hybrid' => [ ... ]
     */
    public function oracleRecommendations(Request $request)
    {
        try {
            $uid = intval($request->input('uid', 0));
            $topN = max(1, intval($request->input('top_n', 10)));
            $contentWeight = floatval($request->input('content_weight', 0.7));

            // require oracle helper
            require_once public_path('db/oracledb.php');
            $conn = null;
            try { $conn = getOracleConnection(); } catch (\Throwable $__e) { }

            $useMock = ($request->input('mock') == '1') || !function_exists('oci_parse') || !$conn;

            // if uid missing try a cheap pick
            if (!$useMock && empty($uid)) {
                $pickSql = "SELECT ID FROM MVSG.USER_GUARDIAN WHERE ROWNUM = 1";
                $stid = @oci_parse($conn, $pickSql);
                if ($stid) { @oci_execute($stid); $prow = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS); @oci_free_statement($stid); if (!empty($prow['ID'])) $uid = intval($prow['ID']); }
            }

            if ($useMock) {
                $mock = [];
                for ($i = 1; $i <= min(5, $topN); $i++) $mock[] = ['id' => 100 + $i, 'title' => "Mock Job #".$i, 'company' => null, 'industry' => null, 'content_score' => 0.0, 'collab_score' => 0.0, 'hybrid_score' => 0.0];
                return response()->json(['uid' => $uid ?: null, 'mode' => 'hybrid', 'collab' => [], 'content' => [], 'hybrid' => $mock]);
            }

            // 1) bounded read: get precomputed recommendations for this user
            $recSql = "SELECT JOB_ID, FIT_SCORE FROM RECOMMENDATION WHERE EXPERTS_ID = :uid AND ROWNUM <= 200";
            $stid = @oci_parse($conn, $recSql);
            $recs = [];
            if ($stid) { oci_bind_by_name($stid, ':uid', $uid); @oci_execute($stid); while ($r = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) { $recs[] = $r; if (count($recs) >= 200) break; } @oci_free_statement($stid); }

            // 2) if none: use top popular job ids (bounded)
            if (empty($recs)) {
                $popSql = "SELECT JOB_ID FROM (SELECT JOB_ID, COUNT(*) CNT FROM RECOMMENDATION GROUP BY JOB_ID ORDER BY COUNT(*) DESC) WHERE ROWNUM <= :n";
                $pSt = @oci_parse($conn, $popSql);
                if ($pSt) { oci_bind_by_name($pSt, ':n', $topN); @oci_execute($pSt); $popIds = []; while ($r = @oci_fetch_array($pSt, OCI_ASSOC+OCI_RETURN_NULLS)) { if (!empty($r['JOB_ID'])) $popIds[] = $r['JOB_ID']; } @oci_free_statement($pSt); foreach ($popIds as $pid) $recs[] = ['JOB_ID' => $pid, 'FIT_SCORE' => 0.0]; }
            }

            // 3) fetch job metadata for those ids only (small IN() query)
            $jobIds = [];
            foreach ($recs as $r) { if (!empty($r['JOB_ID'])) $jobIds[] = intval($r['JOB_ID']); }
            $jobIds = array_values(array_unique($jobIds));
            $jobs = [];
            if (!empty($jobIds)) {
                $in = implode(',', array_map('intval', $jobIds));
                $jq = "SELECT ID, TITLE, REQUIRED_SKILLS, COMPANY_ID FROM MVSG.JOB_POSTINGS WHERE ID IN (".$in.")";
                $js = @oci_parse($conn, $jq);
                if ($js) { @oci_execute($js); while ($j = @oci_fetch_array($js, OCI_ASSOC+OCI_RETURN_NULLS)) { $jobs[$j['ID']] = $j; } @oci_free_statement($js); }
            }

            // 4) lightweight user profile fetch for skills
            $userSkills = '';
            $uSql = "SELECT SKILLS FROM USER_GUARDIAN WHERE ID = :id";
            $us = @oci_parse($conn, $uSql);
            if ($us) { oci_bind_by_name($us, ':id', $uid); @oci_execute($us); $ur = @oci_fetch_array($us, OCI_ASSOC+OCI_RETURN_NULLS); @oci_free_statement($us); if (!empty($ur['SKILLS'])) $userSkills = (string)$ur['SKILLS']; }

            // tokenizer
            $tokenize = function($s) { $s = mb_strtolower((string)$s); $parts = preg_split('/[^a-z0-9]+/i', $s); $out = []; foreach ($parts as $p) { $p = trim($p); if ($p === '' || strlen($p) < 2) continue; $out[$p] = true; } return array_keys($out); };
            $userTokens = $tokenize($userSkills); $userCount = max(1, count($userTokens));

            $candidates = [];
            foreach ($recs as $r) {
                $jid = isset($r['JOB_ID']) ? intval($r['JOB_ID']) : null; if ($jid === null) continue;
                $job = isset($jobs[$jid]) ? $jobs[$jid] : ['ID' => $jid, 'TITLE' => null, 'REQUIRED_SKILLS' => null, 'COMPANY_ID' => null];
                $text = ($job['TITLE'] ?? '') . ' ' . ($job['REQUIRED_SKILLS'] ?? '');
                $toks = $tokenize($text); $common = count(array_intersect($userTokens, $toks)); $contentScore = $common / $userCount;
                $collabRaw = isset($r['FIT_SCORE']) ? floatval($r['FIT_SCORE']) : 0.0; $collabScore = max(0.0, min(1.0, $collabRaw));
                $hy = $contentWeight * $contentScore + (1.0 - $contentWeight) * $collabScore;
                $candidates[] = ['id' => $jid, 'title' => $job['TITLE'] ?? null, 'company' => $job['COMPANY_ID'] ?? null, 'content_score' => round($contentScore,4), 'collab_score' => round($collabScore,4), 'hybrid_score' => round($hy,4)];
            }

            if (empty($candidates)) {
                $sampleSql = "SELECT ID, TITLE, COMPANY_ID FROM MVSG.JOB_POSTINGS WHERE ROWNUM <= :n";
                $sSt = @oci_parse($conn, $sampleSql);
                if ($sSt) { oci_bind_by_name($sSt, ':n', $topN); @oci_execute($sSt); while ($jr = @oci_fetch_array($sSt, OCI_ASSOC+OCI_RETURN_NULLS)) { $candidates[] = ['id' => $jr['ID'], 'title' => $jr['TITLE'], 'company' => $jr['COMPANY_ID'], 'content_score' => 0.0, 'collab_score' => 0.0, 'hybrid_score' => 0.0]; } @oci_free_statement($sSt); }
            }

            usort($candidates, function($a,$b){ return $b['hybrid_score'] <=> $a['hybrid_score']; });
            $candidates = array_slice($candidates, 0, $topN);

            return response()->json(['uid' => $uid ?: null, 'mode' => 'hybrid', 'collab' => [], 'content' => [], 'hybrid' => $candidates]);
        } catch (\Throwable $e) {
            Log::error('oracleRecommendations error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $msg = app()->environment('local') ? $e->getMessage() : 'internal_server_error';
            return response()->json(['error' => 'exception', 'message' => $msg], 500);
        }
    }
}