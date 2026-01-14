<?php
session_start();
header('Content-Type: application/json');

require_once 'oracledb.php'; // contains getOracleConnection()

// ——— READ & VALIDATE JSON (but tolerate empty body) ———
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) $data = [];

// determine user id: prefer session (server-side) -> GET param -> JSON body
$user_id = null;
if (!empty($_SESSION['user_id'])) {
  $user_id = preg_replace('/\D/', '', (string)$_SESSION['user_id']);
} elseif (!empty($_GET['user_id'])) {
  $user_id = preg_replace('/\D/', '', (string)$_GET['user_id']);
} elseif (!empty($data['user_id'])) {
  // last-resort: JSON body (kept for backward compatibility)
  $user_id = preg_replace('/\D/', '', (string)$data['user_id']);
}
// normalize empty -> null
if ($user_id === '') $user_id = null;

// --- Read optional filter parameters (from JSON body or GET)
$title = null;
$location = null;
$work_env = null;
$job_type = null;
if (!empty($data) && is_array($data)) {
  if (!empty($data['title'])) $title = trim($data['title']);
  if (!empty($data['location'])) $location = trim($data['location']);
  if (!empty($data['work_environment'])) $work_env = trim($data['work_environment']);
  if (!empty($data['job_type'])) $job_type = trim($data['job_type']);
}
// Also accept GET params and alternate names used in client code
if ($title === null && !empty($_GET['title'])) $title = trim($_GET['title']);
if ($location === null && !empty($_GET['location'])) $location = trim($_GET['location']);
if ($work_env === null && !empty($_GET['work_environment'])) $work_env = trim($_GET['work_environment']);
if ($job_type === null) {
  if (!empty($_GET['job_type'])) $job_type = trim($_GET['job_type']);
  // client sometimes sends select named 'growth_potential'
  if ($job_type === null && !empty($data['growth_potential'])) $job_type = trim($data['growth_potential']);
  if ($job_type === null && !empty($_GET['growth_potential'])) $job_type = trim($_GET['growth_potential']);
}

$conn = getOracleConnection();
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

// SQL: content matches for the provided guardian (if any) + global collab counts (all saved/applications)
$sql = "
WITH
  co_counts AS (
    -- count distinct guardians who either saved or applied to a job
    SELECT job_id, COUNT(DISTINCT guardian_id) AS CO_COUNT
    FROM (
      SELECT JOB_ID   AS job_id, GUARDIAN_ID FROM MVSG.SAVED_JOBS WHERE JOB_ID IS NOT NULL AND GUARDIAN_ID IS NOT NULL
      UNION ALL
      SELECT JOB_POSTING_ID AS job_id, GUARDIAN_ID FROM MVSG.APPLICATIONS WHERE JOB_POSTING_ID IS NOT NULL AND GUARDIAN_ID IS NOT NULL
    ) t
    GROUP BY job_id
  ),
  max_co AS (
    SELECT NVL(MAX(CO_COUNT),0) AS MAX_CO FROM co_counts
  ),

  -- per-job application counts (used by frontend and evaluation)
  app_counts AS (
    SELECT JOB_POSTING_ID AS JOB_ID, COUNT(DISTINCT GUARDIAN_ID) AS APPLIED_COUNT
    FROM MVSG.APPLICATIONS
    WHERE JOB_POSTING_ID IS NOT NULL
    GROUP BY JOB_POSTING_ID
  ),

  -- separate content sources (like JOB_PROFILE does) and then sum them
  content_profile AS (
    SELECT jp.JOB_POSTING_ID AS job_id, COUNT(*) AS MATCH_COUNT
    FROM MVSG.JOB_PROFILE jp
    JOIN MVSG.USER_PROFILE up
      ON LOWER(up.VALUE) = LOWER(jp.VALUE)
    WHERE (:user_id IS NOT NULL AND up.GUARDIAN_ID = :user_id)
    GROUP BY jp.JOB_POSTING_ID
  ),

  content_cert AS (
    SELECT jp.JOB_POSTING_ID AS job_id, COUNT(*) AS MATCH_COUNT
    FROM MVSG.JOB_PROFILE jp
    JOIN (
      SELECT GUARDIAN_ID, NAME AS VALUE FROM MVSG.GUARDIAN_CERTIFICATES WHERE NAME IS NOT NULL
      UNION ALL
      SELECT GUARDIAN_ID, WHAT_LEARNED FROM MVSG.GUARDIAN_CERTIFICATES WHERE WHAT_LEARNED IS NOT NULL
      UNION ALL
      SELECT GUARDIAN_ID, ISSUED_BY FROM MVSG.GUARDIAN_CERTIFICATES WHERE ISSUED_BY IS NOT NULL
    ) gc ON LOWER(gc.VALUE) = LOWER(jp.VALUE)
    WHERE (:user_id IS NOT NULL AND gc.GUARDIAN_ID = :user_id)
    GROUP BY jp.JOB_POSTING_ID
  ),

  content_exp AS (
    SELECT jp.JOB_POSTING_ID AS job_id, COUNT(*) AS MATCH_COUNT
    FROM MVSG.JOB_PROFILE jp
    JOIN (
      SELECT GUARDIAN_ID, JOB_TITLE      AS VALUE FROM MVSG.JOB_EXPERIENCE WHERE JOB_TITLE IS NOT NULL
      UNION ALL
      SELECT GUARDIAN_ID, COMPANY_NAME   AS VALUE FROM MVSG.JOB_EXPERIENCE WHERE COMPANY_NAME IS NOT NULL
      UNION ALL
      SELECT GUARDIAN_ID, YEARS_EXPERIENCE AS VALUE FROM MVSG.JOB_EXPERIENCE WHERE YEARS_EXPERIENCE IS NOT NULL
    ) je ON LOWER(je.VALUE) = LOWER(jp.VALUE)
    WHERE (:user_id IS NOT NULL AND je.GUARDIAN_ID = :user_id)
    GROUP BY jp.JOB_POSTING_ID
  ),

  content_match AS (
    SELECT job_id, SUM(MATCH_COUNT) AS MATCH_COUNT
    FROM (
      SELECT * FROM content_profile
      UNION ALL
      SELECT * FROM content_cert
      UNION ALL
      SELECT * FROM content_exp
    )
    GROUP BY job_id
  ),

  base_jobs AS (
    SELECT *
    FROM (
      SELECT 
        jp.ID,
        jp.COMPANY_NAME,
        jp.JOB_ROLE,
        jp.JOB_DESCRIPTION,
          jp.ADDRESS,
          jp.JOB_TYPE,
          jp.WORKING_ENVIRONMENT,
          (SELECT LISTAGG(LOWER(VALUE),' ') WITHIN GROUP (ORDER BY ID) FROM MVSG.JOB_PROFILE jp2 WHERE jp2.JOB_POSTING_ID = jp.ID AND LOWER(jp2.TYPE) IN ('workplace','workplace_preference','work_environment','job_preference','job_positions') AND jp2.VALUE IS NOT NULL) AS JOB_PROFILE_WORKPLACE,
        jp.EMPLOYEE_CAPACITY,
          jp.APPLY_BEFORE,
        1 AS PRIORITY,
        jp.JOB_POST_DATE
      FROM MVSG.JOB_POSTINGS jp
      INNER JOIN MVSG.JOB_PROFILE JPR ON JPR.JOB_POSTING_ID = jp.ID
      INNER JOIN MVSG.USER_PROFILE UP ON UP.VALUE = JPR.VALUE
      INNER JOIN MVSG.USER_GUARDIAN UG ON UG.ID = UP.GUARDIAN_ID
      WHERE (:user_id IS NOT NULL AND UG.ID = :user_id)

      UNION ALL

      SELECT 
        jp.ID,
        jp.COMPANY_NAME,
        jp.JOB_ROLE,
        jp.JOB_DESCRIPTION,
          jp.ADDRESS,
          jp.JOB_TYPE,
          jp.WORKING_ENVIRONMENT,
          (SELECT LISTAGG(LOWER(VALUE),' ') WITHIN GROUP (ORDER BY ID) FROM MVSG.JOB_PROFILE jp2 WHERE jp2.JOB_POSTING_ID = jp.ID AND LOWER(jp2.TYPE) IN ('workplace','workplace_preference','work_environment','job_preference','job_positions') AND jp2.VALUE IS NOT NULL) AS JOB_PROFILE_WORKPLACE,
        jp.EMPLOYEE_CAPACITY,
          jp.APPLY_BEFORE,
        2 AS PRIORITY,
        jp.JOB_POST_DATE
      FROM MVSG.JOB_POSTINGS jp
      INNER JOIN MVSG.USER_GUARDIAN UG ON UG.ADDRESS = jp.ADDRESS
      WHERE (:user_id IS NOT NULL AND UG.ID = :user_id)
      
      UNION ALL

      -- fallback: include all job postings with lowest priority so page shows all jobs
      SELECT
        jp.ID,
        jp.COMPANY_NAME,
        jp.JOB_ROLE,
        jp.JOB_DESCRIPTION,
        jp.ADDRESS,
        jp.JOB_TYPE,
        jp.WORKING_ENVIRONMENT,
        (SELECT LISTAGG(LOWER(VALUE),' ') WITHIN GROUP (ORDER BY ID) FROM MVSG.JOB_PROFILE jp2 WHERE jp2.JOB_POSTING_ID = jp.ID AND LOWER(jp2.TYPE) IN ('workplace','workplace_preference','work_environment','job_preference','job_positions') AND jp2.VALUE IS NOT NULL) AS JOB_PROFILE_WORKPLACE,
        jp.EMPLOYEE_CAPACITY,
        jp.APPLY_BEFORE,
        3 AS PRIORITY,
        jp.JOB_POST_DATE
      FROM MVSG.JOB_POSTINGS jp
      -- no joins: include everything as lowest-priority fallback
    ) t
  )
SELECT bj.*,
       NVL(cm.MATCH_COUNT,0) AS CONTENT_MATCHES,
  NVL(cc.CO_COUNT,0)   AS COLLAB_COUNT,
       CASE WHEN mc.MAX_CO > 0 THEN NVL(cc.CO_COUNT,0) / mc.MAX_CO ELSE 0 END AS COLLAB_SCORE_RAW,
       LEAST(1, NVL(cm.MATCH_COUNT,0) / 5) AS CONTENT_SCORE_RAW,
  mc.MAX_CO AS DEBUG_MAX_CO,
  NVL(ac.APPLIED_COUNT,0) AS APPLIED_COUNT
FROM (
  SELECT bj2.*, ROW_NUMBER() OVER (PARTITION BY bj2.ID ORDER BY PRIORITY) AS rn
  FROM base_jobs bj2
) bj
LEFT JOIN content_match cm ON cm.job_id = bj.ID
LEFT JOIN co_counts cc ON cc.job_id = bj.ID
LEFT JOIN app_counts ac ON ac.JOB_ID = bj.ID
LEFT JOIN max_co mc ON 1=1
WHERE bj.rn = 1
AND (:title IS NULL OR (LOWER(bj.JOB_ROLE) LIKE :title_like OR LOWER(bj.JOB_DESCRIPTION) LIKE :title_like))
AND (:location IS NULL OR LOWER(bj.ADDRESS) LIKE :location_like)
AND (:work_env IS NULL OR LOWER(NVL(bj.WORKING_ENVIRONMENT,'')) LIKE :work_env_like OR LOWER(bj.JOB_ROLE) LIKE :work_env_like)
AND (:job_type IS NULL OR LOWER(bj.JOB_TYPE) LIKE :job_type_like)
-- Order by blended hybrid score (70% content, 30% collaborative), then newest first
ORDER BY (
  (0.7 * LEAST(1, NVL(cm.MATCH_COUNT,0) / 5))
  + (0.3 * CASE WHEN mc.MAX_CO > 0 THEN NVL(cc.CO_COUNT,0) / mc.MAX_CO ELSE 0 END)
) DESC, bj.JOB_POST_DATE DESC
";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':user_id', $user_id, -1);
// Prepare and bind filter values (use lowercase LIKE patterns)
$title_like = $title !== null && $title !== '' ? '%' . strtolower($title) . '%' : null;
$location_like = $location !== null && $location !== '' ? '%' . strtolower($location) . '%' : null;
$work_env_like = $work_env !== null && $work_env !== '' ? '%' . strtolower($work_env) . '%' : null;
$job_type_like = $job_type !== null && $job_type !== '' ? '%' . strtolower($job_type) . '%' : null;

oci_bind_by_name($stid, ':title', $title, -1);
oci_bind_by_name($stid, ':title_like', $title_like, -1);
oci_bind_by_name($stid, ':location', $location, -1);
oci_bind_by_name($stid, ':location_like', $location_like, -1);
oci_bind_by_name($stid, ':work_env', $work_env, -1);
oci_bind_by_name($stid, ':work_env_like', $work_env_like, -1);
oci_bind_by_name($stid, ':job_type', $job_type, -1);
oci_bind_by_name($stid, ':job_type_like', $job_type_like, -1);
if (!@oci_execute($stid)) {
    $e = oci_error($stid) ?: oci_error($conn);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Query failed', 'oci' => $e]);
    exit;
}

$jobs = [];

while ($row = oci_fetch_assoc($stid)) {
    $jobId = $row['ID'];

    // Fetch skills from JOB_PROFILE
    $profileSql = "
      SELECT VALUE, TYPE
      FROM MVSG.JOB_PROFILE
      WHERE JOB_POSTING_ID = :job_id
        AND VALUE IS NOT NULL
        AND LOWER(TYPE) IN ('skills','job-position','role','workplace','workplace_preference','work_environment','job_positions','job_preference')
    ";
    $pstid = oci_parse($conn, $profileSql);
    oci_bind_by_name($pstid, ':job_id', $jobId, -1);
    oci_execute($pstid);

    $skills = []; $jobTypes = [];
    $workplaces = [];
    while ($p = oci_fetch_assoc($pstid)) {
        $type = strtolower($p['TYPE'] ?? '');
        if (strpos($type, 'role') !== false || $type === 'job-position') $jobTypes[] = $p['VALUE'];
        elseif ($type === 'skills') $skills[] = $p['VALUE'];
      elseif (strpos($type, 'work') !== false || strpos($type, 'workplace') !== false || strpos($type, 'job_preference') !== false || strpos($type,'job_positions') !== false) {
        $workplaces[] = $p['VALUE'];
      }
    }
    oci_free_statement($pstid);

    // Fetch COMPANY_IMAGE as before
    $imgSql = "SELECT COMPANY_IMAGE FROM MVSG.JOB_POSTINGS WHERE ID = :job_id";
    $imgStid = oci_parse($conn, $imgSql);
    oci_bind_by_name($imgStid, ':job_id', $jobId, -1);
    oci_execute($imgStid);
    $imgRow = oci_fetch_assoc($imgStid);
    if ($imgRow && $imgRow['COMPANY_IMAGE'] !== null) {
        $blob = $imgRow['COMPANY_IMAGE'];
        $imageContent = $blob->load();
        $logoSrc = "data:image/png;base64," . base64_encode($imageContent);
    } else {
        $logoSrc = "https://via.placeholder.com/150?text=Logo";
    }
    oci_free_statement($imgStid);

    // ensure numeric non-null values by explicit casts/fallbacks
    $contentScoreRaw = isset($row['CONTENT_SCORE_RAW']) ? floatval($row['CONTENT_SCORE_RAW']) : 0.0;
    $collabScoreRaw  = isset($row['COLLAB_SCORE_RAW'])  ? floatval($row['COLLAB_SCORE_RAW'])  : 0.0;
    $contentMatches  = isset($row['CONTENT_MATCHES'])  ? intval($row['CONTENT_MATCHES']) : 0;
    $collabCount     = isset($row['COLLAB_COUNT'])     ? intval($row['COLLAB_COUNT']) : 0;
    $debugMaxCo      = isset($row['DEBUG_MAX_CO'])     ? intval($row['DEBUG_MAX_CO']) : 0;

    // use APPLIED_COUNT returned by the main query (from app_counts CTE)
    $appliedCount = isset($row['APPLIED_COUNT']) ? intval($row['APPLIED_COUNT']) : 0;

    // Blend: 70% content, 30% collaborative
    $computedScore = round((0.7 * $contentScoreRaw + 0.3 * $collabScoreRaw) * 100, 2);
    // ensure numeric non-null values by explicit casts/fallbacks
    $contentScoreRaw = isset($row['CONTENT_SCORE_RAW']) ? floatval($row['CONTENT_SCORE_RAW']) : 0.0;
    $collabScoreRaw  = isset($row['COLLAB_SCORE_RAW'])  ? floatval($row['COLLAB_SCORE_RAW'])  : 0.0;
    $contentMatches  = isset($row['CONTENT_MATCHES'])  ? intval($row['CONTENT_MATCHES']) : 0;
    $collabCount     = isset($row['COLLAB_COUNT'])     ? intval($row['COLLAB_COUNT']) : 0;
    $debugMaxCo      = isset($row['DEBUG_MAX_CO'])     ? intval($row['DEBUG_MAX_CO']) : 0;

    $jobs[] = [
        'id'                    => $jobId,
        'company_name'          => $row['COMPANY_NAME'] ?? null,
        'job_role'              => $row['JOB_ROLE'] ?? null,
        'description'           => $row['JOB_DESCRIPTION'] ?? '',
        'address'               => $row['ADDRESS'] ?? null,
        'job_type'              => !empty($jobTypes) ? $jobTypes[0] : ($row['JOB_TYPE'] ?? null),
        // prefer JOB_PROFILE aggregated values, else use JOB table WORKING_ENVIRONMENT
        'job_profile_workplace' => $row['JOB_PROFILE_WORKPLACE'] ?? null,
        'work_environment'      => !empty($workplaces) ? implode(', ', $workplaces) : ($row['JOB_PROFILE_WORKPLACE'] ?? ($row['WORKING_ENVIRONMENT'] ?? null)),
        'skills'                => $skills,
      'openings'              => $row['EMPLOYEE_CAPACITY'] ?? null,
      'apply_before'          => isset($row['APPLY_BEFORE']) ? $row['APPLY_BEFORE'] : null,
        'logo'                  => $logoSrc,
        // hybrid signals (guaranteed numeric)
        'content_score'         => round($contentScoreRaw * 100, 2),
        'collab_score'          => round(min(1.0, $collabScoreRaw) * 100, 2),
        'computed_score'        => $computedScore,
        // debug fields (guaranteed numeric)
        'debug_content_matches' => $contentMatches,
        'debug_collab_count'    => $collabCount,
        'debug_max_co'          => $debugMaxCo
        ,
        // explicit application counts for frontend
        'applied'               => $appliedCount,
        'applied_count'         => $appliedCount
    ];
}


oci_free_statement($stid);
oci_close($conn);

// --- NEW: compute simple evaluation metrics for the requesting guardian
$predictedIds = array_values(array_unique(array_map(function($j){ return $j['id']; }, $jobs)));

$appliedIds = [];
if (!empty($user_id)) {
    $conn2 = getOracleConnection();
    if ($conn2) {
        $sqlA = "SELECT DISTINCT JOB_POSTING_ID AS JOB_ID FROM MVSG.APPLICATIONS WHERE GUARDIAN_ID = :gid";
        $stidA = oci_parse($conn2, $sqlA);
        oci_bind_by_name($stidA, ':gid', $user_id, -1);
        @oci_execute($stidA);
        while ($ar = oci_fetch_assoc($stidA)) {
            if (isset($ar['JOB_ID'])) $appliedIds[] = $ar['JOB_ID'];
        }
        @oci_free_statement($stidA);
        @oci_close($conn2);
    }
}
$predSet = array_map('strval', $predictedIds);
$appSet  = array_map('strval', array_values(array_unique($appliedIds)));

    // Mark per-job whether the requesting guardian already applied (for frontend)
    if (!empty($appSet) && count($jobs) > 0) {
      $appSetLookup = array_flip($appSet);
      foreach ($jobs as $k => $jj) {
        $jid = isset($jj['id']) ? (string)$jj['id'] : null;
        $jobs[$k]['user_applied'] = ($jid !== null && isset($appSetLookup[$jid]));
      }
    } else {
      // default false for each job
      foreach ($jobs as $k => $jj) {
        $jobs[$k]['user_applied'] = false;
      }
    }

$tp = count(array_intersect($predSet, $appSet));
$fp = max(0, count($predSet) - $tp);
$fn = max(0, count($appSet) - $tp);

// total universe = total job postings (fallback to preds+apps if query fails)
$totalJobs = null;
$conn3 = getOracleConnection();
if ($conn3) {
    $cntSql = "SELECT COUNT(*) AS CNT FROM MVSG.JOB_POSTINGS";
    $cntSt = oci_parse($conn3, $cntSql);
    if (@oci_execute($cntSt)) {
        $r = oci_fetch_assoc($cntSt);
        $totalJobs = $r && isset($r['CNT']) ? intval($r['CNT']) : null;
    }
    @oci_free_statement($cntSt);
    @oci_close($conn3);
}
if ($totalJobs === null) $totalJobs = max(1, $tp + $fp + $fn);
$tn = max(0, $totalJobs - ($tp + $fp + $fn));

// compute metrics (null when undefined)
$precision = ($tp + $fp) > 0 ? ($tp / ($tp + $fp)) : null;
$recall    = ($tp + $fn) > 0 ? ($tp / ($tp + $fn)) : null;
$f1        = ($precision !== null && $recall !== null && ($precision + $recall) > 0) ? (2 * $precision * $recall) / ($precision + $recall) : null;
$accuracy  = ($tp + $tn + 0) / max(1, $tp + $tn + $fp + $fn);

// prepare eval object (include counts + fractional metrics)
$eval_metrics = [
    'counts' => ['tp' => $tp, 'tn' => $tn, 'fp' => $fp, 'fn' => $fn],
    'accuracy'  => $accuracy === null ? null : round($accuracy, 6),
    'precision' => $precision === null ? null : round($precision, 6),
    'recall'    => $recall === null ? null : round($recall, 6),
    'f1'        => $f1 === null ? null : round($f1, 6),
];

// OPTIONAL: write public/eval_metrics.json so server-side blade can pick it up when available
try {
    $path = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . 'eval_metrics.json'; // public/eval_metrics.json
    if ($path) {
        @file_put_contents($path, json_encode(array_merge(['generated_by' => 'get-jobs.php', 'user_id' => $user_id], $eval_metrics), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
} catch (\Throwable $e) {
    // ignore write errors
}

// echo response including eval metrics
echo json_encode([
    'success' => true,
    'user_id' => $user_id,
    'jobs' => $jobs,
    'eval_metrics' => $eval_metrics
]);

?>
