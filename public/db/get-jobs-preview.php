<?php
session_start();
header('Content-Type: application/json');

require_once 'oracledb.php'; // contains getOracleConnection()

// Read JSON body (tolerate empty)
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) $data = [];

// Accept job_prefs as JSON array or GET param (comma-separated)
$job_prefs = [];
if (!empty($data['job_prefs']) && is_array($data['job_prefs'])) {
    $job_prefs = $data['job_prefs'];
} elseif (!empty($_GET['job_prefs'])) {
    $job_prefs = array_map('trim', explode(',', $_GET['job_prefs']));
}

// Accept optional profile payload (array) from client to enrich matching
$profile = [];
if (!empty($data['profile']) && is_array($data['profile'])) {
    $profile = $data['profile'];
}

// helper: flatten profile into simple tokens
function extract_profile_tokens($prof) {
  $tokens = [];
  if (!is_array($prof)) return $tokens;
  foreach ($prof as $k => $v) {
    if (is_array($v)) {
      foreach ($v as $vv) {
        if ($vv === null) continue;
        $s = trim((string)$vv);
        if ($s !== '') $tokens[] = $s;
      }
    } else {
      if ($v === null) continue;
      $s = trim((string)$v);
      if ($s !== '') $tokens[] = $s;
    }
  }
  return $tokens;
}

// merge job_prefs and profile-derived tokens into a single input list
$all_inputs = array_values(array_filter(array_map('trim', array_merge($job_prefs, extract_profile_tokens($profile)))));

// helpers
function normalize_token($s) {
  if ($s === null) return '';
  $s = mb_strtolower(trim((string)$s));
  $s = preg_replace('/[\p{P}&&[^\/\&]]+/u', ' ', $s);
  $s = preg_replace('/\s+/u', ' ', $s);
  return trim($s);
}

function map_synonym($val, $synonyms) {
  if ($val === null) return null;
  foreach ($synonyms as $canon => $variants) {
    foreach ($variants as $v) {
      if ($v === '') continue;
      if (mb_strpos($val, $v) !== false) return $canon;
    }
  }
  return $val;
}

// small synonyms map (copied + simplified from get-jobs.php)
$SYNONYMS = [
  'communication requirements' => ['communication requirements','communication required','communication skills','verbal communication','greet','greeting','customer assistant','concierge'],
  'cognitive level requirements' => ['cognitive level requirements','simple instructions','follow instructions','pack','packaging','prepare','organize'],
  'sensory requirements' => ['sensory requirements','safe and light work','light tasks','no heavy lifting','stockroom','basket','cart','table setter','server assistant','food runner','clean'],
  'accommodation availability' => ['accommodation available','friendly team','buddy helper','buddy','supportive team']
];

// Disability -> incompatible job phrases map (case-insensitive substrings)
$DISABILITY_INCOMPAT = [
  'deaf' => ['communication requirements','communication required','communication skills','verbal communication','greet','greeting','present menu','speak','phone','telephone'],
  'hearing_impairment' => ['communication requirements','verbal communication','phone','telephone','listen','hearing'],
  'blind' => ['visual','see','read','sight','vision','display','inspect','observe'],
  'vision_impairment' => ['visual','see','read','sight','vision','display','inspect','observe'],
  'limited_mobility' => ['heavy lifting','lift','carry','drive','deliver','move stock','manual handling'],
  'wheelchair' => ['stairs','step','climb','heavy lifting','lift','carry']
];

// derive user conditions from provided profile tokens (preview accepts `profile`)
$user_conditions = [];
if (!empty($profile) && is_array($profile)) {
  foreach (extract_profile_tokens($profile) as $t) {
    $lt = mb_strtolower(trim((string)$t));
    if ($lt === '') continue;
    // match common condition keywords
    if (mb_stripos($lt, 'deaf') !== false || mb_stripos($lt, 'hearing') !== false) $user_conditions[] = 'deaf';
    if (mb_stripos($lt, 'blind') !== false || mb_stripos($lt, 'vision') !== false) $user_conditions[] = 'blind';
    if (mb_stripos($lt, 'mobility') !== false || mb_stripos($lt, 'wheelchair') !== false || mb_stripos($lt, 'limited mobility') !== false) $user_conditions[] = 'limited_mobility';
  }
}
$user_conditions = array_values(array_unique($user_conditions));

$JOB_ROLE_REQUIREMENTS = [
  'greeter' => ['communication requirements'],
  'customer assistant' => ['communication requirements'],
  'merchandis' => ['cognitive level requirements'],
  'stock' => ['sensory requirements'],
  'basket' => ['sensory requirements'],
  'cart' => ['sensory requirements'],
  'clean' => ['sensory requirements'],
  'pack' => ['cognitive level requirements'],
  'bag' => ['cognitive level requirements'],
  'alteration' => ['cognitive level requirements'],
  'menu' => ['communication requirements'],
  'server' => ['sensory requirements'],
  'table' => ['sensory requirements'],
  'kitchen' => ['cognitive level requirements'],
  'housekeeping' => ['sensory requirements'],
  'concierge' => ['communication requirements'],
  'sales' => ['communication requirements'],
  'promotion' => ['communication requirements']
];

$WORK_ENV_REQUIREMENTS = [
  'friendly team' => ['accommodation availability'],
  'buddy' => ['accommodation availability'],
  'simple instructions' => ['communication requirements','cognitive level requirements'],
  'safe and light work' => ['sensory requirements']
];

$preview_based_on = array_values($job_prefs);

// normalize input tokens (use merged inputs if provided)
$input_tokens = [];
$source_for_tokens = (count($all_inputs) > 0) ? $all_inputs : $job_prefs;
foreach ($source_for_tokens as $p) {
  $t = trim((string)$p);
  if ($t === '') continue;
  $n = mb_strtolower($t);
  $n = preg_replace('/\s+/u',' ',$n);
  $n = trim($n);
  $mapped = map_synonym($n, $SYNONYMS);
  $input_tokens[] = $mapped;
  $input_tokens[] = $n;
}
$input_tokens = array_values(array_unique(array_filter($input_tokens)));

$conn = getOracleConnection();
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

// fetch collaborative counts (saved + applications)
$co_counts = [];
$max_co = 0;
$coSql = "SELECT job_id, CO_COUNT FROM (SELECT job_id, COUNT(DISTINCT guardian_id) AS CO_COUNT FROM (SELECT JOB_ID AS job_id, GUARDIAN_ID FROM MVSG.SAVED_JOBS UNION ALL SELECT JOB_POSTING_ID AS job_id, GUARDIAN_ID FROM MVSG.APPLICATIONS) GROUP BY job_id)";
$stid = oci_parse($conn, $coSql);
if (@oci_execute($stid)) {
  while ($r = oci_fetch_assoc($stid)) {
    $id = isset($r['JOB_ID']) ? $r['JOB_ID'] : null;
    $cnt = isset($r['CO_COUNT']) ? intval($r['CO_COUNT']) : 0;
    if ($id !== null) { $co_counts[(string)$id] = $cnt; if ($cnt > $max_co) $max_co = $cnt; }
  }
}
oci_free_statement($stid);

// fetch applied counts (global)
$appliedCounts = [];
$appSql = "SELECT JOB_POSTING_ID AS JOB_ID, COUNT(DISTINCT GUARDIAN_ID) AS APPLIED_COUNT FROM MVSG.APPLICATIONS WHERE JOB_POSTING_ID IS NOT NULL GROUP BY JOB_POSTING_ID";
$stid = oci_parse($conn, $appSql);
if (@oci_execute($stid)) {
  while ($r = oci_fetch_assoc($stid)) {
    if (isset($r['JOB_ID'])) $appliedCounts[(string)$r['JOB_ID']] = intval($r['APPLIED_COUNT']);
  }
}
oci_free_statement($stid);

// Fetch job postings (aggregate job_profile text for basic matching)
$sql = "SELECT jp.ID, jp.COMPANY_NAME, jp.JOB_ROLE, jp.JOB_DESCRIPTION, jp.ADDRESS, jp.JOB_TYPE, jp.WORKING_ENVIRONMENT, jp.COMPANY_IMAGE, jp.EMPLOYEE_CAPACITY, jp.APPLY_BEFORE, jp.JOB_POST_DATE, jp.COMP_REQ, jp.SENSOR_REQ, jp.COG_LVL_REQ, jp.ACCOM_AVAIL, (SELECT LISTAGG(LOWER(VALUE),' ') WITHIN GROUP (ORDER BY ID) FROM MVSG.JOB_PROFILE jp2 WHERE jp2.JOB_POSTING_ID = jp.ID AND jp2.VALUE IS NOT NULL) AS JOB_PROFILE_TEXT FROM MVSG.JOB_POSTINGS jp";
$stid = oci_parse($conn, $sql);
if (!@oci_execute($stid)) {
    $e = oci_error($stid) ?: oci_error($conn);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Query failed', 'oci' => $e]);
    exit;
}

$jobs = [];
while ($row = oci_fetch_assoc($stid)) {
    $jobId = $row['ID'];
    $job_profile_text = mb_strtolower((string)($row['JOB_PROFILE_TEXT'] ?? ''));
    $role = mb_strtolower((string)($row['JOB_ROLE'] ?? ''));
    $desc = mb_strtolower((string)($row['JOB_DESCRIPTION'] ?? ''));
    $fields_text = $job_profile_text . ' ' . $role . ' ' . $desc . ' ' . mb_strtolower((string)($row['WORKING_ENVIRONMENT'] ?? ''));

    // content matches: count how many input tokens appear in fields
    $content_matches = 0;
    if (!empty($input_tokens)) {
      foreach ($input_tokens as $t) {
        if ($t === '') continue;
        if (mb_stripos($fields_text, $t) !== false) $content_matches += 1;
      }
    }
    $contentScoreRaw = min(1.0, $content_matches / 5.0);

    // If user has disabilities, exclude jobs that appear incompatible
    if (!empty($user_conditions)) {
      $hay = mb_strtolower($fields_text . ' ' . ($row['COMP_REQ'] ?? '') . ' ' . ($row['SENSOR_REQ'] ?? '') . ' ' . ($row['COG_LVL_REQ'] ?? '') . ' ' . ($row['ACCOM_AVAIL'] ?? ''));
      $exclude = false;
      foreach ($user_conditions as $cond) {
        if (!isset($DISABILITY_INCOMPAT[$cond])) continue;
        foreach ($DISABILITY_INCOMPAT[$cond] as $phrase) {
          if ($phrase === '') continue;
          if (mb_stripos($hay, $phrase) !== false) { $exclude = true; break 2; }
        }
      }
      if ($exclude) continue; // skip this job entirely
    }

    // access matches (PHP-side): build job access fields
    $job_access_fields = [];
    if (!empty($row['COMP_REQ'])) $job_access_fields[] = $row['COMP_REQ'];
    if (!empty($row['SENSOR_REQ'])) $job_access_fields[] = $row['SENSOR_REQ'];
    if (!empty($row['COG_LVL_REQ'])) $job_access_fields[] = $row['COG_LVL_REQ'];
    if (!empty($row['ACCOM_AVAIL'])) $job_access_fields[] = $row['ACCOM_AVAIL'];

    // augment by role keywords
    $roleText = $role;
    if ($roleText !== '') {
      foreach ($JOB_ROLE_REQUIREMENTS as $kw => $reqs) {
        if (mb_stripos($roleText, $kw) !== false) {
          foreach ($reqs as $r) $job_access_fields[] = $r;
        }
      }
    }

    // augment from job_profile_text and working environment using WORK_ENV_REQUIREMENTS
    $envCandidates = [];
    if (!empty($job_profile_text)) $envCandidates[] = $job_profile_text;
    if (!empty($row['WORKING_ENVIRONMENT'])) $envCandidates[] = $row['WORKING_ENVIRONMENT'];
    foreach ($envCandidates as $ec) {
      $ecn = mb_strtolower((string)$ec);
      foreach ($WORK_ENV_REQUIREMENTS as $kw => $reqs) {
        if (mb_stripos($ecn, $kw) !== false) {
          foreach ($reqs as $r) $job_access_fields[] = $r;
        }
      }
    }

    $job_access_fields = array_values(array_unique(array_filter($job_access_fields)));
    $job_tokens = [];
    foreach ($job_access_fields as $jf) {
      $t = mb_strtolower(trim((string)$jf));
      if ($t === '') continue;
      $job_tokens[] = map_synonym($t, $SYNONYMS);
      $job_tokens[] = $t;
    }
    $job_tokens = array_values(array_unique($job_tokens));

    $access_matches_php = 0;
    if (!empty($input_tokens) && !empty($job_tokens)) {
      foreach ($input_tokens as $ut) {
        if ($ut === '') continue;
        foreach ($job_tokens as $jt) {
          if ($jt === '') continue;
          if (mb_stripos($ut, $jt) !== false || mb_stripos($jt, $ut) !== false) {
            $access_matches_php += 2; // weighted like server design
          }
        }
      }
    }
    $accessScoreRaw = min(1.0, $access_matches_php / 4.0);

    $collabCount = isset($co_counts[(string)$jobId]) ? intval($co_counts[(string)$jobId]) : 0;
    $collabScoreRaw = ($max_co > 0) ? ($collabCount / $max_co) : 0.0;

    $computedScore = round((0.65 * $contentScoreRaw + 0.25 * $accessScoreRaw + 0.1 * $collabScoreRaw) * 100, 2);

    // logo handling: if COMPANY_IMAGE is a BLOB, attempt to load; otherwise fallback
    $logoSrc = "https://via.placeholder.com/150?text=Logo";
    if (!empty($row['COMPANY_IMAGE']) && is_object($row['COMPANY_IMAGE'])) {
      try { $blob = $row['COMPANY_IMAGE']; $imageContent = $blob->load(); if ($imageContent !== false) $logoSrc = "data:image/png;base64," . base64_encode($imageContent); } catch (Exception $e) {}
    }

    $jobs[] = [
      'id' => $jobId,
      'company_name' => $row['COMPANY_NAME'] ?? null,
      'job_role' => $row['JOB_ROLE'] ?? null,
      'description' => $row['JOB_DESCRIPTION'] ?? '',
      'address' => $row['ADDRESS'] ?? null,
      'job_type' => $row['JOB_TYPE'] ?? null,
      'job_profile_text' => $row['JOB_PROFILE_TEXT'] ?? null,
      'work_environment' => $row['WORKING_ENVIRONMENT'] ?? null,
      'comp_req' => $row['COMP_REQ'] ?? null,
      'sensor_req' => $row['SENSOR_REQ'] ?? null,
      'cog_lvl_req' => $row['COG_LVL_REQ'] ?? null,
      'accom_avail' => $row['ACCOM_AVAIL'] ?? null,
      'openings' => $row['EMPLOYEE_CAPACITY'] ?? null,
      'apply_before' => $row['APPLY_BEFORE'] ?? null,
      'logo' => $logoSrc,
      'content_score' => round($contentScoreRaw * 100, 2),
      'collab_score' => round(min(1.0, $collabScoreRaw) * 100, 2),
      'computed_score' => $computedScore,
      'access_matches' => $access_matches_php,
      'access_score_raw' => round($accessScoreRaw, 3),
      'debug_content_matches' => $content_matches,
      'debug_collab_count' => $collabCount,
      'applied_count' => isset($appliedCounts[(string)$jobId]) ? $appliedCounts[(string)$jobId] : 0
    ];
}

oci_free_statement($stid);
oci_close($conn);

// sort by computed_score desc then collab
usort($jobs, function($a,$b){ if ($a['computed_score']==$b['computed_score']) return $b['debug_collab_count'] <=> $a['debug_collab_count']; return $b['computed_score'] <=> $a['computed_score']; });

// return top 6 recommendations for preview
$top = array_slice($jobs, 0, 6);

// if profile was provided, set preview_based_on to a condensed profile token list
if (!empty($profile)) {
  $preview_based_on = array_values(array_unique(array_slice(extract_profile_tokens($profile), 0, 8)));
}

echo json_encode(['success' => true, 'preview_based_on' => $preview_based_on, 'recommendations' => $top]);

?>
