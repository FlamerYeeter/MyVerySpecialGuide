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
            // allow local testing via payload even without auth
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
     * Weighted Hybrid recommender (compact, safe Oracle usage).
     * Method follows the user's METHOD 1 specification:
     *  - Compute content_score from user vs job attributes
     *  *  - Compute collab_score from precomputed recommendations or popularity
     *  *  - Combine with default weights content:0.6 collab:0.4 (adjustable via content_weight param)
     *
     * Notes:
     *  - Uses public/db/oracledb.php (DO NOT EDIT that file)
     *  - Limits Oracle reads (ROWNUM caps, small IN() queries)
     *  - Provides a deterministic mock fallback when OCI8/connection missing
     */
    public function oracleRecommendations(Request $request)
    {
        try {
            $uid = intval($request->input('uid', 0));
            $topN = max(1, intval($request->input('top_n', 10)));
            // default content weight 0.6 => collab 0.4
            $contentWeight = floatval($request->input('content_weight', 0.6));
            $contentWeight = max(0.0, min(1.0, $contentWeight));
            $collabWeight = 1.0 - $contentWeight;

            // allow a local SQLite fallback when explicitly requested: ?local=1
            $useLocal = ($request->input('local') == '1');

            // require oracle helper (user insisted this file must not be edited)
            require_once public_path('db/oracledb.php');
            $conn = null;
            try { $conn = getOracleConnection(); } catch (\Throwable $__e) { }

            // decide mode: local fallback if requested, otherwise use Oracle. If neither available, fail.
            $ociAvailable = function_exists('oci_parse') && $conn;
            if ($useLocal) {
                try { Log::info('oracleRecommendations:mode', ['mode' => 'local_sqlite']); } catch (\Throwable $__l) {}
            } else {
                try { Log::info('oracleRecommendations:mode', ['mode' => ($ociAvailable ? 'oracle' : 'oracle_unavailable')]); } catch (\Throwable $__l) {}
            }

            if (!$useLocal && !$ociAvailable) {
                try { Log::error('oracleRecommendations:oracle_unavailable', ['useMock' => true]); } catch (\Throwable $__l) {}
                return response()->json(['error' => 'oracle_unavailable', 'message' => 'OCI8 or Oracle connection not available — cannot produce live recommendations. Use ?local=1 to run against a local SQLite DB if available.'], 503);
            }

            // If uid missing try a cheap pick (single-row)
            if (empty($uid)) {
                $pickSql = "SELECT ID FROM MVSG_USER_GUARDIAN WHERE ROWNUM = 1";
                $stid = @oci_parse($conn, $pickSql);
                if ($stid) { @oci_execute($stid); $prow = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS); @oci_free_statement($stid); if (!empty($prow['ID'])) $uid = intval($prow['ID']); }
            }

            // Diagnostic: initial state
            try { Log::info('oracleRecommendations:start', ['uid' => $uid, 'top_n' => $topN, 'contentWeight' => $contentWeight, 'useLocal' => $useLocal, 'ociAvailable' => $ociAvailable]); } catch (\Throwable $__l) {}

            // (no mock fallback) — we require real Oracle data per user instruction

            // --- 1) Collaborative signal: fetch precomputed RECOMMENDATION rows for user (bounded) ---
            $recs = [];
            try {
                if ($useLocal) {
                    // SQLite path
                    $sqlite = database_path('database.sqlite');
                    if (!file_exists($sqlite)) throw new \Exception('local sqlite not found: ' . $sqlite);
                    $pdo = new \PDO('sqlite:' . $sqlite);
                    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    $recSql = "SELECT JOB_ID, COMMENT_SCORE FROM MVSG_RECOMMENDATION WHERE EXPERT_ID = :uid LIMIT 500";
                    $stmt = $pdo->prepare($recSql);
                    $stmt->bindValue(':uid', $uid, \PDO::PARAM_INT);
                    $stmt->execute();
                    while ($r = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                        if (!empty($r['JOB_ID'])) $recs[] = ['job_id' => intval($r['JOB_ID']), 'fit_score' => isset($r['COMMENT_SCORE']) ? floatval($r['COMMENT_SCORE']) : 0.0];
                        if (count($recs) >= 500) break;
                    }
                } else {
                    $recSql = "SELECT JOB_ID, COMMENT_SCORE FROM MVSG_RECOMMENDATION WHERE EXPERT_ID = :uid AND ROWNUM <= 500";
                    $stid = @oci_parse($conn, $recSql);
                    if ($stid) {
                        oci_bind_by_name($stid, ':uid', $uid);
                        @oci_execute($stid);
                        while ($r = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                            if (!empty($r['JOB_ID'])) $recs[] = ['job_id' => intval($r['JOB_ID']), 'fit_score' => isset($r['COMMENT_SCORE']) ? floatval($r['COMMENT_SCORE']) : 0.0];
                            if (count($recs) >= 500) break;
                        }
                        @oci_free_statement($stid);
                    }
                }
            } catch (\Throwable $_e) { /* ignore and fallback to popularity below */ }

            try { Log::info('oracleRecommendations:recs_fetched', ['recs_count' => count($recs)]); } catch (\Throwable $__l) {}

            // Popularity fallback map (counts) for jobs (bounded query)
            $popMap = [];
            $maxPop = 1.0;
            try {
                if ($useLocal) {
                    $popSql = "SELECT JOB_ID, COUNT(*) as CNT FROM MVSG_RECOMMENDATION GROUP BY JOB_ID ORDER BY CNT DESC";
                    $stmt = $pdo->query($popSql);
                    while ($rp = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                        if (!empty($rp['JOB_ID'])) { $jid = intval($rp['JOB_ID']); $popMap[$jid] = intval($rp['CNT'] ?? 0); }
                    }
                    if (!empty($popMap)) $maxPop = max($popMap) > 0 ? max($popMap) : 1.0;
                } else {
                    $popSql = "SELECT JOB_ID, COUNT(*) CNT FROM MVSG_RECOMMENDATION GROUP BY JOB_ID ORDER BY COUNT(*) DESC";
                    $pSt = @oci_parse($conn, $popSql);
                    if ($pSt) {
                        @oci_execute($pSt);
                        while ($rp = @oci_fetch_array($pSt, OCI_ASSOC+OCI_RETURN_NULLS)) {
                            if (!empty($rp['JOB_ID'])) { $jid = intval($rp['JOB_ID']); $popMap[$jid] = intval($rp['CNT'] ?? 0); }
                        }
                        @oci_free_statement($pSt);
                        if (!empty($popMap)) $maxPop = max($popMap) > 0 ? max($popMap) : 1.0;
                    }
                }
            } catch (\Throwable $_e) { /* ignore popularity if fails */ }

            try { Log::info('oracleRecommendations:popularity', ['pop_count' => count($popMap), 'maxPop' => $maxPop]); } catch (\Throwable $__l) {}

            // If no per-user recs, seed some job ids from popularity (top N*2)
            $candidateJobIds = [];
            if (!empty($recs)) {
                foreach ($recs as $r) $candidateJobIds[] = intval($r['job_id']);
            } else {
                $i = 0;
                foreach ($popMap as $jid => $cnt) {
                    $candidateJobIds[] = $jid;
                    $i++; if ($i >= $topN * 2) break;
                }
            }

            // If still empty, seed from recent/top job_postings as a cheap fallback
            if (empty($candidateJobIds)) {
                try {
                    $m = max(1, min(500, $topN * 3));
                    if ($useLocal) {
                        $sampleSql = "SELECT ID FROM MVSG_JOB_POSTINGS LIMIT :m";
                        $stmt = $pdo->prepare($sampleSql);
                        $stmt->bindValue(':m', $m, \PDO::PARAM_INT);
                        $stmt->execute();
                        while ($jr2 = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                            if (!empty($jr2['ID'])) { $candidateJobIds[] = intval($jr2['ID']); }
                            if (count($candidateJobIds) >= $m) break;
                        }
                    } else {
                        $sampleSql = "SELECT ID FROM MVSG_JOB_POSTINGS WHERE ROWNUM <= :m";
                        $sSt2 = @oci_parse($conn, $sampleSql);
                        if ($sSt2) {
                            oci_bind_by_name($sSt2, ':m', $m);
                            @oci_execute($sSt2);
                            while ($jr2 = @oci_fetch_array($sSt2, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                if (!empty($jr2['ID'])) { $candidateJobIds[] = intval($jr2['ID']); }
                                if (count($candidateJobIds) >= $m) break;
                            }
                            @oci_free_statement($sSt2);
                        }
                    }
                } catch (\Throwable $__e) { /* ignore */ }
            }

            try { Log::info('oracleRecommendations:candidate_ids', ['count' => count($candidateJobIds), 'sample' => array_slice($candidateJobIds,0,10)]); } catch (\Throwable $__l) {}

            // --- 2) fetch job metadata for candidate ids only (bounded IN query) ---
            $jobs = [];
            $candidateJobIds = array_values(array_unique($candidateJobIds));
            if (!empty($candidateJobIds)) {
                $in = implode(',', array_map('intval', $candidateJobIds));
                // select a small set of columns to avoid LOB reads
                if ($useLocal) {
                    $jq = "SELECT ID, TITLE, REQUIRED_SKILLS, LOCATION, EXPERIENCE_LEVEL, EMPLOYMENT_TYPE, COMPANY_ID FROM MVSG_JOB_POSTINGS WHERE ID IN (" . $in . ")";
                    try {
                        $stmt = $pdo->query($jq);
                        while ($j = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                            if (!empty($j['ID'])) $jobs[intval($j['ID'])] = $j;
                        }
                    } catch (\Throwable $_e) { /* ignore metadata fetch errors */ }
                } else {
                    $jq = "SELECT ID, TITLE, REQUIRED_SKILLS, LOCATION, EXPERIENCE_LEVEL, EMPLOYMENT_TYPE, COMPANY_ID FROM MVSG_JOB_POSTINGS WHERE ID IN (" . $in . ")";
                    try {
                        $js = @oci_parse($conn, $jq);
                        if ($js) {
                            @oci_execute($js);
                            while ($j = @oci_fetch_array($js, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                if (!empty($j['ID'])) $jobs[intval($j['ID'])] = $j;
                            }
                            @oci_free_statement($js);
                        }
                    } catch (\Throwable $_e) { /* ignore metadata fetch errors */ }
                }
            }

            try { Log::info('oracleRecommendations:jobs_fetched', ['jobs_count' => count($jobs)]); } catch (\Throwable $__l) {}

            // If still no candidate job ids, fetch a small sample of jobs
            if (empty($candidateJobIds)) {
                try {
                    $sampleSql = "SELECT ID, TITLE, REQUIRED_SKILLS, LOCATION, EXPERIENCE_LEVEL, EMPLOYMENT_TYPE, COMPANY_ID FROM MVSG_JOB_POSTINGS WHERE ROWNUM <= :n";
                    $sSt = @oci_parse($conn, $sampleSql);
                    if ($sSt) {
                        oci_bind_by_name($sSt, ':n', $topN);
                        @oci_execute($sSt);
                        while ($jr = @oci_fetch_array($sSt, OCI_ASSOC+OCI_RETURN_NULLS)) {
                            if (!empty($jr['ID'])) { $jobs[intval($jr['ID'])] = $jr; $candidateJobIds[] = intval($jr['ID']); }
                            if (count($candidateJobIds) >= $topN) break;
                        }
                        @oci_free_statement($sSt);
                    }
                } catch (\Throwable $_e) { /* ignore */ }
            }

            // --- 3) fetch user profile from MVSG_USER_PROFILE (key/value pairs)
            // and basic guardian fields from MVSG_USER_GUARDIAN ---
            $profileRows = [];
            $guardianRow = [];
            try {
                if ($useLocal) {
                    $uSql = "SELECT KEY, VALUE FROM MVSG_USER_PROFILE WHERE GUARDIAN_ID = :id LIMIT 200";
                    $stmt = $pdo->prepare($uSql);
                    $stmt->bindValue(':id', $uid, \PDO::PARAM_INT);
                    $stmt->execute();
                    while ($r = $stmt->fetch(\PDO::FETCH_ASSOC)) { $profileRows[] = $r; }
                    // fetch guardian basic fields
                    $gSql = "SELECT FIRST_NAME, LAST_NAME, ADDRESS, SECTION, CERTIFICATES, ROLE FROM MVSG_USER_GUARDIAN WHERE ID = :id LIMIT 1";
                    $gstmt = $pdo->prepare($gSql);
                    $gstmt->bindValue(':id', $uid, \PDO::PARAM_INT);
                    $gstmt->execute();
                    $guardianRow = $gstmt->fetch(\PDO::FETCH_ASSOC) ?: [];
                } else {
                    $uSql = "SELECT KEY, VALUE FROM MVSG_USER_PROFILE WHERE GUARDIAN_ID = :id";
                    $us = @oci_parse($conn, $uSql);
                    if ($us) {
                        oci_bind_by_name($us, ':id', $uid);
                        @oci_execute($us);
                        while ($r = @oci_fetch_array($us, OCI_ASSOC+OCI_RETURN_NULLS)) { $profileRows[] = $r; }
                        @oci_free_statement($us);
                    }
                    // fetch guardian basic fields from MVSG_USER_GUARDIAN
                    $gSql = "SELECT FIRST_NAME, LAST_NAME, ADDRESS, SECTION, CERTIFICATES, ROLE FROM MVSG_USER_GUARDIAN WHERE ID = :id";
                    $gs = @oci_parse($conn, $gSql);
                    if ($gs) {
                        oci_bind_by_name($gs, ':id', $uid);
                        @oci_execute($gs);
                        $gRow = @oci_fetch_array($gs, OCI_ASSOC+OCI_RETURN_NULLS);
                        @oci_free_statement($gs);
                        if ($gRow) $guardianRow = $gRow;
                    }
                }
            } catch (\Throwable $_e) { /* ignore */ }

            try { Log::info('oracleRecommendations:user_profile', ['rows' => count($profileRows)]); } catch (\Throwable $__l) {}

            // tokenizer / normalizer
            $tokenize = function($s) {
                $s = mb_strtolower((string)$s);
                // split by non-alphanum characters
                $parts = preg_split('/[^\p{L}\p{N}]+/u', $s);
                $out = [];
                foreach ($parts as $p) {
                    $p = trim($p);
                    if ($p === '' || mb_strlen($p) < 2) continue;
                    $out[$p] = true;
                }
                return array_keys($out);
            };

            $userTextParts = [];
            foreach ($profileRows as $pr) {
                $k = isset($pr['KEY']) ? $pr['KEY'] : (isset($pr['key']) ? $pr['key'] : '');
                $v = isset($pr['VALUE']) ? $pr['VALUE'] : (isset($pr['value']) ? $pr['value'] : '');
                if ($k !== '') $userTextParts[] = $k;
                if ($v !== '') $userTextParts[] = $v;
            }
            // include guardian basic fields
            if (!empty($guardianRow)) {
                if (!empty($guardianRow['FIRST_NAME'])) $userTextParts[] = $guardianRow['FIRST_NAME'];
                if (!empty($guardianRow['LAST_NAME'])) $userTextParts[] = $guardianRow['LAST_NAME'];
                if (!empty($guardianRow['ADDRESS'])) $userTextParts[] = $guardianRow['ADDRESS'];
                if (!empty($guardianRow['SECTION'])) $userTextParts[] = $guardianRow['SECTION'];
                if (!empty($guardianRow['CERTIFICATES'])) $userTextParts[] = $guardianRow['CERTIFICATES'];
                if (!empty($guardianRow['ROLE'])) $userTextParts[] = $guardianRow['ROLE'];
            }
            $userText = implode(' ', $userTextParts);
            $userTokens = $tokenize($userText);
            $userTokenCount = max(1, count($userTokens));
            try { Log::info('oracleRecommendations:user_tokens', ['count' => $userTokenCount, 'sample' => array_slice($userTokens,0,10)]); } catch (\Throwable $__l) {}

            // Precompute job token counts so we can produce a sensible content score even when user has no tokens
            $jobTokensMap = [];
            $maxJobTokens = 0;
            foreach ($candidateJobIds as $cj) {
                $jrow = isset($jobs[$cj]) ? $jobs[$cj] : null;
                $textParts = [];
                if ($jrow) {
                    if (!empty($jrow['TITLE'])) $textParts[] = $jrow['TITLE'];
                    if (!empty($jrow['REQUIRED_SKILLS'])) $textParts[] = $jrow['REQUIRED_SKILLS'];
                    if (!empty($jrow['LOCATION'])) $textParts[] = $jrow['LOCATION'];
                    if (!empty($jrow['EXPERIENCE_LEVEL'])) $textParts[] = $jrow['EXPERIENCE_LEVEL'];
                }
                $jt = implode(' ', $textParts);
                $jtokens = $tokenize($jt);
                $count = max(0, count($jtokens));
                $jobTokensMap[$cj] = $jtokens;
                if ($count > $maxJobTokens) $maxJobTokens = $count;
            }


            // Build per-job scores
            $candidates = [];
            // Build quick lookup for user's recs by job id
            $recsByJob = [];
            foreach ($recs as $r) { if (!empty($r['job_id'])) $recsByJob[intval($r['job_id'])] = floatval($r['fit_score']); }
            $maxFit = 0.0; foreach ($recsByJob as $v) if ($v > $maxFit) $maxFit = $v; $maxFit = $maxFit > 0 ? $maxFit : 1.0;

            // ensure we have a superset of job IDs to score
            $allJobIds = array_values(array_unique(array_merge($candidateJobIds, array_keys($jobs))));
            foreach ($allJobIds as $jid) {
                $jrow = isset($jobs[$jid]) ? $jobs[$jid] : ['ID' => $jid];
                // content score: prefer token overlap when user tokens exist, otherwise
                // fall back to job token richness normalized by max tokens so cold-start users
                // still get a sensible ordering (favor jobs with richer metadata).
                $jtokens = isset($jobTokensMap[$jid]) ? $jobTokensMap[$jid] : [];
                if (count($userTokens) > 0) {
                    $common = count(array_intersect($userTokens, $jtokens));
                    $contentScore = $userTokenCount > 0 ? ($common / $userTokenCount) : 0.0;
                } else {
                    $contentScore = $maxJobTokens > 0 ? (count($jtokens) / $maxJobTokens) : 0.0;
                }

                // collab score: prefer per-user fit_score normalized, otherwise popularity
                $collabRaw = 0.0;
                if (isset($recsByJob[$jid])) {
                    $collabRaw = $recsByJob[$jid] / $maxFit; // normalize
                } elseif (isset($popMap[$jid])) {
                    $collabRaw = $maxPop > 0 ? ($popMap[$jid] / $maxPop) : 0.0;
                }
                $collabScore = max(0.0, min(1.0, floatval($collabRaw)));

                $hybridScore = $contentWeight * $contentScore + $collabWeight * $collabScore;

                $candidates[] = [
                    'id' => $jid,
                    'title' => $jrow['TITLE'] ?? null,
                    'company' => $jrow['COMPANY_ID'] ?? null,
                    'content_score' => round($contentScore, 4),
                    'collab_score' => round($collabScore, 4),
                    'hybrid_score' => round($hybridScore, 4),
                ];
            }

            try { Log::info('oracleRecommendations:built_candidates', ['count' => count($candidates)]); } catch (\Throwable $__l) {}

            // sort and slice
            usort($candidates, function($a, $b) { return ($b['hybrid_score'] <=> $a['hybrid_score']); });
            $candidates = array_slice($candidates, 0, $topN);

            // Respond with hybrid-only primary output (frontend expects 'mode' => 'hybrid')
            return response()->json(['uid' => $uid ?: null, 'mode' => 'hybrid', 'collab' => [], 'content' => [], 'hybrid' => $candidates]);

        } catch (\Throwable $e) {
            try { Log::error('oracleRecommendations error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]); } catch (\Throwable $__l) {}
            $msg = app()->environment('local') ? $e->getMessage() : 'internal_server_error';
            return response()->json(['error' => 'exception', 'message' => $msg], 500);
        }
    }

    /**
     * Debug helper: return a small, bounded set of rows from MVSG.JOB_POSTINGS.
     * Purpose: allow quick inspection of job postings directly from Oracle when
     * the recommender returns empty candidates. Returns a compact JSON array.
     */
    public function oracleJobPostings(Request $request)
    {
        try {
            require_once public_path('db/oracledb.php');
            $conn = null;
            try { $conn = getOracleConnection(); } catch (\Throwable $__e) { }

            if (!$conn || !function_exists('oci_parse')) {
                return response()->json(['ok' => false, 'error' => 'oracle_unavailable'], 500);
            }

            $n = max(1, min(200, intval($request->input('n', 50))));
            $sql = "SELECT ID, TITLE, REQUIRED_SKILLS, LOCATION, EXPERIENCE_LEVEL, EMPLOYMENT_TYPE, COMPANY_ID FROM MVSG_JOB_POSTINGS WHERE ROWNUM <= :n";
            $stid = @oci_parse($conn, $sql);
            if ($stid) {
                oci_bind_by_name($stid, ':n', $n);
                @oci_execute($stid);
                $rows = [];
                while ($r = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    $rows[] = $r;
                    if (count($rows) >= $n) break;
                }
                @oci_free_statement($stid);
                return response()->json(['ok' => true, 'count' => count($rows), 'rows' => $rows]);
            }

            return response()->json(['ok' => false, 'error' => 'parse_failed'], 500);
        } catch (\Throwable $e) {
            try { Log::error('oracleJobPostings error: ' . $e->getMessage()); } catch (\Throwable $__l) {}
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }
}