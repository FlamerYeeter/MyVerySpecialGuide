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
        $uid = intval($request->input('uid', 7));
        $topN = intval($request->input('top_n', 10));

        // Temporary per-process TNS_ADMIN override (quick test only). Remove this when you set system TNS_ADMIN.
        @putenv('TNS_ADMIN=C:\\oracle\\network\\admin');

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

        // First: fetch precomputed recommendations from RECOMMENDATION table joined to JOB_LISTINGS
    // note: schema uses EXPERTS_ID as the FK to the experts table
    // embed uid as an integer literal to avoid bind-name parsing issues in this environment
    // JOB_LISTINGS in this schema exposes TITLE, DESCRIPTION, REQUIRED_SKILLS, COMPANY_ID, STATUS
    $recSql = "SELECT R.ID REC_ID, R.JOB_ID, R.FIT_SCORE, R.GROWTH_SCORE, R.EXPLANATION, R.STATUS, J.TITLE, J.DESCRIPTION, J.REQUIRED_SKILLS, J.COMPANY_ID, J.STATUS AS JOB_STATUS FROM RECOMMENDATION R JOIN JOB_LISTINGS J ON R.JOB_ID = J.ID WHERE R.EXPERTS_ID = " . intval($uid);
        $recs = [];
        try {
            try { Log::debug('oracleRecommendations recSql: ' . $recSql); } catch (\Throwable $_) {}
            $stid = @oci_parse($conn, $recSql);
            if ($stid) {
                $ok = @oci_execute($stid);
                if (!$ok) {
                    $err = oci_error($stid) ?: oci_error($conn);
                    try { Log::warning('oracleRecommendations recSql execute failed: ' . json_encode($err)); } catch (\Throwable $_) {}
                } else {
                    while ($r = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS)) {
                        $recs[] = $r;
                    }
                    try { Log::info('oracleRecommendations fetched precomputed recs count=' . count($recs)); } catch (\Throwable $_) {}
                }
                @oci_free_statement($stid);
            }
        } catch (\Throwable $_e) {
            // ignore and fallback
            try { Log::warning('oracleRecommendations recSql exception: ' . $_e->getMessage()); } catch (\Throwable $_) {}
        }

        // helper: ensure returned strings are valid UTF-8 (strip/ignore invalid bytes)
        $safeUtf8 = function($v) {
            if ($v === null) return null;
            $s = (string)$v;
            $out = @iconv('UTF-8', 'UTF-8//IGNORE', $s);
            if ($out === false) {
                // last resort
                $out = utf8_encode($s);
            }
            return $out;
        };

        // If the uid corresponds to an EXPERTS record, we should present content-based
        // recommendations (the expert chooses content-based). This simulates that flow:
        $isExpert = false;
        try {
            $expSql = "SELECT ID FROM EXPERTS WHERE ID = " . intval($uid);
            $est = @oci_parse($conn, $expSql);
            if ($est) {
                @oci_execute($est);
                $er = @oci_fetch_array($est, OCI_ASSOC+OCI_RETURN_LOBS);
                if ($er) $isExpert = true;
                @oci_free_statement($est);
            }
        } catch (\Throwable $_e) {
            // ignore — treat as non-expert on failure
            $isExpert = false;
        }

    if ($isExpert) {
            try { Log::info('oracleRecommendations: uid=' . $uid . ' detected as EXPERT — using content-based simulation'); } catch (\Throwable $_) {}
            // Simulate content-based profile for the expert by aggregating any available precomputed rec texts
            $parts = [];
            if (!empty($recs)) {
                foreach ($recs as $r) {
                    if (!empty($r['TITLE'])) $parts[] = (string)$r['TITLE'];
                    if (!empty($r['DESCRIPTION'])) $parts[] = (string)$r['DESCRIPTION'];
                }
            }
            $userText = implode(' ', $parts);

            // tokenizer (reuse same logic as the fallback)
            $tokenize = function($s) {
                $s = mb_strtolower(strip_tags((string)$s));
                $parts = preg_split('/[^\\p{L}\\p{N}_]+/u', $s);
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

            // Job queries (same as fallback)
            $jobQueries = [
                "SELECT ID, TITLE, DESCRIPTION, REQUIRED_SKILLS, COMPANY_ID, STATUS FROM JOB_LISTINGS",
                "SELECT ID, TITLE, DESCRIPTION, null AS REQUIRED_SKILLS, null AS COMPANY_NAME, null AS INDUSTRY FROM JOB_POSTINGS",
                "SELECT ID, TITLE, DESCRIPTION, null AS REQUIRED_SKILLS, null AS COMPANY_NAME, null AS INDUSTRY FROM POSTINGS",
                "SELECT ID, TITLE, DESCRIPTION, null AS REQUIRED_SKILLS, null AS COMPANY_NAME, null AS INDUSTRY FROM JOBS",
                "SELECT ID, TITLE, DESCRIPTION, null AS REQUIRED_SKILLS, null AS COMPANY_NAME, null AS INDUSTRY FROM JOBS"
            ];

            $jobs = [];
            foreach ($jobQueries as $jq) {
                try {
                    $js = @oci_parse($conn, $jq);
                    if (!$js) continue;
                    @oci_execute($js);
                    while ($r = @oci_fetch_array($js, OCI_ASSOC+OCI_RETURN_LOBS)) {
                        $jobs[] = $r;
                    }
                    @oci_free_statement($js);
                    if (count($jobs) > 0) break;
                } catch (\Throwable $_e) { continue; }
            }

            if (empty($jobs)) {
                return response()->json(['error' => 'no_jobs_found', 'message' => 'No job postings found in Oracle.'], 404);
            }

            $scored = [];
            foreach ($jobs as $j) {
                $textParts = [];
                foreach (['TITLE','DESCRIPTION','REQUIRED_SKILLS','COMPANY_ID'] as $c) {
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

            $topN = max(1, intval($topN));
            $outSlice = array_slice($scored, 0, $topN);
            $results = [];
            foreach ($outSlice as $s) {
                $j = $s['job'];
                $results[] = [
                    'id' => $j['ID'] ?? null,
                    'title' => $safeUtf8($j['TITLE'] ?? null),
                    'company' => $j['COMPANY_ID'] ?? null,
                    'industry' => null,
                    'content_score' => round(max(0.0, floatval($s['score'])), 4),
                    'collab_score' => 0.0,
                    'hybrid_score' => round(max(0.0, floatval($s['score'])), 4),
                ];
            }
            // Use as content-based results for experts; keep collab results available below
            $contentOut = $results;
        }

        // Prepare collaborative (precomputed) output if present
        $collabOut = [];
        if (!empty($recs)) {
            // sort by FIT_SCORE desc
            usort($recs, function($a, $b) {
                $av = isset($a['FIT_SCORE']) ? floatval($a['FIT_SCORE']) : 0.0;
                $bv = isset($b['FIT_SCORE']) ? floatval($b['FIT_SCORE']) : 0.0;
                return $bv <=> $av;
            });
            $slice = array_slice($recs, 0, $topN);
            $out = [];
            foreach ($slice as $r) {
                $out[] = [
                    'recommendation_id' => $r['REC_ID'] ?? null,
                    'job_id' => $r['JOB_ID'] ?? null,
                    'title' => $safeUtf8($r['TITLE'] ?? null),
                    'company_id' => $r['COMPANY_ID'] ?? null,
                    'required_skills' => $safeUtf8($r['REQUIRED_SKILLS'] ?? null),
                    'description' => $safeUtf8($r['DESCRIPTION'] ?? null),
                    'fit_score' => is_numeric($r['FIT_SCORE']) ? floatval($r['FIT_SCORE']) : null,
                    'growth_score' => is_numeric($r['GROWTH_SCORE']) ? floatval($r['GROWTH_SCORE']) : null,
                    'explanation' => $safeUtf8($r['EXPLANATION'] ?? null),
                    'status' => $r['STATUS'] ?? null,
                ];
            }
            $collabOut = $out;
        }

        // If no precomputed recommendations exist, fall back to content-based ranking (original algorithm)
        // Query the USER_GUARDIAN table for the profile
        $userSql = "SELECT ID, SKILLS, WORK_EXPERIENCE, WORKING_ENVIRONMENT, JOB_PREFERENCE, CERTIFICATE, FIRST_NAME, LAST_NAME, EMAIL FROM USER_GUARDIAN WHERE ID = :id";
        $userRow = null;
        try {
            $stid = @oci_parse($conn, $userSql);
            if ($stid) {
                oci_bind_by_name($stid, ':id', $uid);
                @oci_execute($stid);
                $userRow = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS) ?: null;
                @oci_free_statement($stid);
            }
        } catch (\Throwable $e) {
            // continue to error below
        }

        // If no user profile found, continue with empty profile (we'll still return collab results if present)
        if (!$userRow) {
            try { Log::info('oracleRecommendations: no USER_GUARDIAN profile for uid=' . $uid . ', continuing with empty profile for content scoring'); } catch (\Throwable $_) {}
            $userRow = null;
        }

        // Build user text blob
        $parts = [];
        foreach (['SKILLS','WORK_EXPERIENCE','WORKING_ENVIRONMENT','JOB_PREFERENCE','CERTIFICATE'] as $c) {
            if (!empty($userRow[$c])) $parts[] = (string)$userRow[$c];
        }
        $userText = implode(' ', $parts);

        // Job table tries
        // prefer the actual JOB_LISTINGS table if present, then other common job tables
        $jobQueries = [
            // conservative projection: include core columns and provide NULLs for optional fields
            "SELECT ID, TITLE, DESCRIPTION, REQUIRED_SKILLS, COMPANY_ID, STATUS FROM JOB_LISTINGS",
            "SELECT ID, TITLE, DESCRIPTION, null AS REQUIRED_SKILLS, null AS COMPANY_NAME, null AS INDUSTRY FROM JOB_POSTINGS",
            "SELECT ID, TITLE, DESCRIPTION, null AS REQUIRED_SKILLS, null AS COMPANY_NAME, null AS INDUSTRY FROM POSTINGS",
            "SELECT ID, TITLE, DESCRIPTION, null AS REQUIRED_SKILLS, null AS COMPANY_NAME, null AS INDUSTRY FROM JOBS",
            // fallback minimal projection
            "SELECT ID, TITLE, DESCRIPTION, null AS REQUIRED_SKILLS, null AS COMPANY_NAME, null AS INDUSTRY FROM JOBS"
        ];

        $jobs = [];
        foreach ($jobQueries as $jq) {
            try {
                $js = @oci_parse($conn, $jq);
                if (!$js) continue;
                @oci_execute($js);
                while ($r = oci_fetch_array($js, OCI_ASSOC+OCI_RETURN_LOBS)) {
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
            $parts = preg_split('/[^\\p{L}\\p{N}_]+/u', $s);
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
            foreach (['TITLE','DESCRIPTION','REQUIRED_SKILLS','COMPANY_ID'] as $c) {
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

        // Compute a simple collaborative/popularity signal from common numeric columns (if present)
        $collabRaw = [];
        foreach ($scored as $i => $s) {
            $j = $s['job'];
            $v = 0.0;
            foreach (['APPLICATION_COUNT', 'APPLICATIONS', 'APPLY_COUNT', 'VIEWS', 'POPULARITY'] as $col) {
                if (isset($j[$col]) && is_numeric($j[$col])) {
                    $v = max($v, floatval($j[$col]));
                }
            }
            $collabRaw[$i] = $v;
        }
        $maxCollab = max($collabRaw) ?: 1.0;

        // Normalize collab score and compute hybrid (weighted blend)
        $out = array_slice($scored, 0, $topN);
        $results = [];
        $contentWeight = floatval($request->input('content_weight', 0.7));
        $collabWeight = 1.0 - $contentWeight;
        foreach ($out as $idx => $s) {
            $j = $s['job'];
            $contentScore = max(0.0, floatval($s['score']));
            $rawCollab = isset($collabRaw[$idx]) ? floatval($collabRaw[$idx]) : 0.0;
            $collabScore = $maxCollab > 0 ? ($rawCollab / $maxCollab) : 0.0;
            $hybrid = $contentWeight * $contentScore + $collabWeight * $collabScore;
            $results[] = [
                'id' => $j['ID'] ?? null,
                'title' => $j['TITLE'] ?? null,
                'company' => $j['COMPANY_ID'] ?? null,
                'industry' => null,
                'content_score' => round($contentScore, 4),
                'collab_score' => round($collabScore, 4),
                'hybrid_score' => round($hybrid, 4),
            ];
        }

        // Ensure contentOut is set (experts path may have set it earlier)
        if (!isset($contentOut)) {
            $contentOut = $results;
        }
        if (!isset($collabOut)) {
            $collabOut = [];
        }

        return response()->json(['uid' => $uid, 'collab' => $collabOut, 'content' => $contentOut]);
    }
}
