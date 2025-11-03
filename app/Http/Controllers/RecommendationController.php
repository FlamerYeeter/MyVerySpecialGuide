<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecommendationController extends Controller
{
    /**
     * Lightweight per-user recommendation entrypoint (legacy hybrid API).
     * This method is intentionally small: it accepts a uid (from session/auth or payload)
     * and returns either a scheduled status or attempts a synchronous generation when forced.
     * For complex generation we dispatch the existing job pipeline.
     */
    public function userRecommendations(Request $request)
    {
        $payload = $request->json()->all() ?: [];

        // Resolve uid: prefer Laravel session -> payload uid -> anonymous
        $uid = null;
        try {
            if (auth()->check()) {
                $u = auth()->user();
                if (!empty($u->firebase_uid)) $uid = (string) $u->firebase_uid;
            }
        } catch (\Throwable $__e) {}

        if (!$uid) $uid = $request->input('uid') ?? ($payload['uid'] ?? null);
        if (!$uid && app()->environment('local')) {
            // allow local testing via payload even without auth
            $uid = $request->input('uid') ?? ($payload['uid'] ?? null);
        }

        if (!$uid) {
            // no identity available: schedule a background generation and return 202
            try { Log::info('userRecommendations: no uid provided, scheduling generation'); } catch (\Throwable $__l) {}
            // Keep behavior simple: schedule a job if available, otherwise return scheduled
            if (class_exists('\App\Jobs\GenerateRecommendations')) {
                try { \App\Jobs\GenerateRecommendations::dispatch('anonymous', []); } catch (\Throwable $_e) {}
            }
            return response()->json(['status' => 'scheduled', 'message' => 'No uid resolved; generation scheduled.'], 202);
        }

        // honor force flag for synchronous dev runs
        $force = $request->input('force') ? true : false;
        if ($force && class_exists('\App\Jobs\GenerateRecommendations')) {
            try {
                $job = new \App\Jobs\GenerateRecommendations($uid, $payload);
                $out = $job->runAndReturn();
                if ($out !== null) {
                    // normalize to array of recs for this uid
                    if (is_array($out) && array_key_exists($uid, $out)) return response()->json($out[$uid]);
                    if (is_array($out) && array_values($out) === $out) return response()->json($out);
                }
                return response()->json(['status' => 'scheduled', 'message' => 'Generation scheduled.'], 202);
            } catch (\Throwable $e) {
                Log::error('userRecommendations force run failed: ' . $e->getMessage());
                return response()->json(['error' => 'generation_failed', 'message' => $e->getMessage()], 500);
            }
        }

        // Default: schedule and return 202
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
     * Lightweight Oracle-backed recommendation endpoint for quick testing.
     * GET /debug/oracle-recs?uid=7
     * This function MUST use public/db/oracledb.php (per your instruction).
     */
    public function oracleRecommendations(Request $request)
    {
        $uid = $request->input('uid', 7);

        // require the oracle helper (do not edit public/db/oracledb.php)
        try {
            require_once public_path('db/oracledb.php');
        } catch (\Throwable $e) {
            return response()->json(['error' => 'oracledb_require_failed', 'message' => $e->getMessage()], 500);
        }

        // create connection
        try {
            $conn = getOracleConnection();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'oracle_connection_failed', 'message' => $e->getMessage()], 500);
        }

        // Query the USER_GUARDIAN table for the profile
        $userSql = "SELECT ID, SKILLS, WORK_EXPERIENCE, WORKING_ENVIRONMENT, JOB_PREFERENCE, CERTIFICATE, FIRST_NAME, LAST_NAME, EMAIL FROM USER_GUARDIAN WHERE ID = :id";
        $userRow = null;
        try {
            $stid = @oci_parse($conn, $userSql);
            if ($stid) {
                oci_bind_by_name($stid, ':id', $uid);
                @oci_execute($stid);
                $userRow = oci_fetch_assoc($stid) ?: null;
                @oci_free_statement($stid);
            }
        } catch (\Throwable $e) {
            // continue to error below
        }

        if (!$userRow) {
            return response()->json(['error' => 'user_not_found', 'uid' => $uid], 404);
        }

        // Build user text blob
        $parts = [];
        foreach (['SKILLS','WORK_EXPERIENCE','WORKING_ENVIRONMENT','JOB_PREFERENCE','CERTIFICATE'] as $c) {
            if (!empty($userRow[$c])) $parts[] = (string)$userRow[$c];
        }
        $userText = implode(' ', $parts);

        // Job table tries
        $jobQueries = [
            "SELECT ID, TITLE, DESCRIPTION, REQUIRED_SKILLS, COMPANY_NAME, INDUSTRY FROM JOB_POSTINGS",
            "SELECT ID, TITLE, DESCRIPTION, REQUIRED_SKILLS, COMPANY_NAME, INDUSTRY FROM POSTINGS",
            "SELECT ID, TITLE, DESCRIPTION, REQUIRED_SKILLS, COMPANY_NAME, INDUSTRY FROM JOBS",
            // fallback
            "SELECT ID, TITLE, DESCRIPTION, null AS REQUIRED_SKILLS, null AS COMPANY_NAME, null AS INDUSTRY FROM JOBS"
        ];

        $jobs = [];
        foreach ($jobQueries as $jq) {
            try {
                $js = @oci_parse($conn, $jq);
                if (!$js) continue;
                @oci_execute($js);
                while ($r = oci_fetch_assoc($js)) {
                    $jobs[] = $r;
                }
                @oci_free_statement($js);
                if (count($jobs) > 0) break;
            } catch (\Throwable $_e) { continue; }
        }

        if (empty($jobs)) {
            return response()->json(['error' => 'no_jobs_found', 'message' => 'No job postings found in Oracle.'], 404);
        }

        // tokenizer
        $tokenize = function($s) {
            $s = mb_strtolower(strip_tags((string)$s));
            $parts = preg_split('/[^\p{L}\p{N}_]+/u', $s);
            $tokens = [];
            foreach ($parts as $p) {
                $p = trim($p);
                if ($p === '' || mb_strlen($p) < 2) continue;
                $tokens[$p] = true;
            }
            return array_keys($tokens);
        };

        $userTokens = $tokenize($userText);
        $userCount = max(1, count($userTokens));

        $scored = [];
        foreach ($jobs as $j) {
            $textParts = [];
            foreach (['TITLE','DESCRIPTION','REQUIRED_SKILLS','COMPANY_NAME','INDUSTRY'] as $c) {
                if (!empty($j[$c])) $textParts[] = (string)$j[$c];
            }
            $jobText = implode(' ', $textParts);
            $jobTokens = $tokenize($jobText);
            $common = array_intersect($userTokens, $jobTokens);
            $score = count($common) / $userCount;
            if (!empty($j['REQUIRED_SKILLS'])) {
                $req = $tokenize($j['REQUIRED_SKILLS']);
                $score += 0.2 * (count(array_intersect($userTokens, $req)) / max(1, count($req)));
            }
            $scored[] = ['job' => $j, 'score' => $score];
        }

        usort($scored, function($a, $b) { return $b['score'] <=> $a['score']; });

        $topN = intval($request->input('top_n', 10));
        $out = array_slice($scored, 0, $topN);
        $results = array_map(function($s) {
            $j = $s['job'];
            return [
                'id' => $j['ID'] ?? null,
                'title' => $j['TITLE'] ?? null,
                'company' => $j['COMPANY_NAME'] ?? null,
                'industry' => $j['INDUSTRY'] ?? null,
                'score' => round($s['score'], 4),
            ];
        }, $out);

        return response()->json(['uid' => $uid, 'count' => count($results), 'results' => $results]);
    }
}
