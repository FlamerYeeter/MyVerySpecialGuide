<?php
header('Content-Type: application/json; charset=utf-8');
// lightweight "why this job" matcher
//ini_set('display_errors', '0');
//error_reporting(0);
// enable errors temporarily for debugging (remove in production)
ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once 'oracledb.php';

// allow session fallback similar to get_profile.php
if (session_status() === PHP_SESSION_NONE) session_start();

// Read input (JSON body or GET)
$raw = file_get_contents('php://input');
$body = json_decode($raw, true);

// accept ids by string (they can be very large). prefer TO_CHAR comparison always.
$job_id = $body['job_id'] ?? $_GET['job_id'] ?? $_GET['id'] ?? null;
$user_id = $body['user_id'] ?? $_GET['user_id'] ?? null;

// allow session fallback if available
// allow session fallback if available
if (empty($user_id)) {
    // 1) native PHP session (public scripts like get_profile.php use $_SESSION['user_id'])
    $user_id = $_SESSION['user_id'] ?? $_SESSION['uid'] ?? null;

    // 2) direct cookie fallbacks (if any scripts set these)
    if (empty($user_id)) {
        $user_id = $_COOKIE['user_id'] ?? $_COOKIE['guardian_id'] ?? null;
    }

    // 3) Laravel file session fallback (storage/framework/sessions). tries to extract numeric id candidates.
    if (empty($user_id)) {
        $laravelSessionName = ini_get('session.name') ?: 'laravel_session';
        $laravelCookie = $_COOKIE[$laravelSessionName] ?? $_COOKIE['laravel_session'] ?? null;
        if ($laravelCookie) {
            $projectRoot = dirname(__DIR__, 2); // public/db -> project root
            $sessFile = $projectRoot . '/storage/framework/sessions/' . $laravelCookie;
            if (file_exists($sessFile) && is_readable($sessFile)) {
                $content = file_get_contents($sessFile);
                if ($content !== false) {
                    $patterns = [
                        '/"user_id";i:(\d+);/i',
                        '/user_id\\|i:(\d+);/i',
                        '/guardian_id";i:(\d+);/i',
                        '/guardian_id\\|i:(\d+);/i',
                        '/login_web[^;]*;i:(\d+);/i',
                        '/i:(\d{1,12});/'
                    ];
                    foreach ($patterns as $pat) {
                        if (preg_match($pat, $content, $m)) {
                            $user_id = $m[1];
                            break;
                        }
                    }
                }
            }
        }
    }
}

if (!$job_id) {
    echo json_encode(['success'=>false,'error'=>'missing job_id']); exit;
}
if (!$user_id) {
    // continue but still attempt matching without user (optional)
    // echo json_encode(['success'=>false,'error'=>'missing user_id']); exit;
}

// Guard lengths
if (strlen((string)$job_id) > 512 || strlen((string)$user_id) > 512) {
    echo json_encode(['success'=>false,'error'=>'id too long']); exit;
}

// always use TO_CHAR match to avoid numeric precision issues with very large ids
$use_to_char_job = true;

function id_condition_sql($col, $use_to_char_match) {
    if ($use_to_char_match) return "TO_CHAR($col) = :id_str";
    return "$col = TO_NUMBER(:id_str)";
}

$conn = getOracleConnection();
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

// fetch job profile entries
$profiles = [];
$job_cond = id_condition_sql('JOB_PROFILE.JOB_POSTING_ID', $use_to_char_job);
$sql = "SELECT VALUE, TYPE FROM MVSG.JOB_PROFILE WHERE $job_cond ORDER BY ID";
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':id_str', $job_id, -1);
if (@oci_execute($stid)) {
    while ($r = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS+OCI_RETURN_NULLS)) {
        $val = trim((string)($r['VALUE'] ?? ''));
        $type = strtolower(trim((string)($r['TYPE'] ?? '')));
        if ($val === '') continue;
        if (!isset($profiles[$type])) $profiles[$type] = [];
        $profiles[$type][] = $val;
    }
}
@oci_free_statement($stid);

// fetch basic job info (title/role, description) for display
$job_title = null;
$job_description = null;
$job_cond2 = id_condition_sql('ID', $use_to_char_job);
$sql = "SELECT JOB_ROLE, JOB_DESCRIPTION FROM MVSG.JOB_POSTINGS WHERE $job_cond2";
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':id_str', $job_id, -1);
if (@oci_execute($stid)) {
    if ($r = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS+OCI_RETURN_NULLS)) {
        $job_title = trim((string)($r['JOB_ROLE'] ?? '')) ?: null;
        $job_description = trim((string)($r['JOB_DESCRIPTION'] ?? '')) ?: null;
    }
}
@oci_free_statement($stid);

// fetch guardian user_profile values (MVSG.USER_PROFILE)
// collect user profile rows/values and track resolution info for debugging
$user_profile_vals = [];
$resolved_guardian_id = null;
$resolved_gids = [];
if (!empty($user_id)) {
    $id_str = (string)$user_id;

    // 1) try treating provided id as GUARDIAN.ID (string compare)
    $sql = "SELECT GUARDIAN_ID, TYPE, VALUE FROM MVSG.USER_PROFILE WHERE TO_CHAR(GUARDIAN_ID)=:id_str ORDER BY ID";
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':id_str', $id_str, -1);
    if (@oci_execute($stid)) {
        while ($row = oci_fetch_assoc($stid)) {
            $user_profile_vals[] = $row; // keep full row for richer matching
            $resolved_guardian_id = $row['GUARDIAN_ID'] ?? $resolved_guardian_id;
        }
    }
    @oci_free_statement($stid);

    // 2) if none found, try to resolve provided id as USER_ID (in USER_GUARDIAN) or as GUARDIAN.ID
    if (empty($user_profile_vals)) {
        $gids = [];
        $sql = "SELECT ID FROM MVSG.USER_GUARDIAN WHERE TO_CHAR(USER_ID)=:id_str OR TO_CHAR(ID)=:id_str";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':id_str', $id_str, -1);
        if (@oci_execute($stid)) {
            while ($r = oci_fetch_assoc($stid)) {
                if (!empty($r['ID'])) $gids[] = $r['ID'];
            }
        }
        @oci_free_statement($stid);
        // remember resolved gids for diagnostics
        $resolved_gids = $gids;

        // fetch user_profile entries for found guardian ids
        foreach ($gids as $gid) {
            $sql = "SELECT GUARDIAN_ID, TYPE, VALUE FROM MVSG.USER_PROFILE WHERE GUARDIAN_ID = :gid ORDER BY ID";
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ':gid', $gid, -1);
            if (@oci_execute($stid)) {
                while ($row = oci_fetch_assoc($stid)) {
                        $user_profile_vals[] = $row;
                        $resolved_guardian_id = $resolved_guardian_id ?? $row['GUARDIAN_ID'];
                }
            }
            @oci_free_statement($stid);
        }
    }

    // If we still have no user profile values, try session-based lookup similar to get_profile.php
    if (empty($user_profile_vals)) {
        $sess_uid = $_SESSION['user_id'] ?? $_SESSION['uid'] ?? null;
        if ($sess_uid) {
            // try MVSG.USER_GUARDIAN first, then fallback to user_guardian
            $foundRows = [];
            $tryTables = ['MVSG.USER_GUARDIAN', 'USER_GUARDIAN'];
            foreach ($tryTables as $tbl) {
                $sql = "SELECT * FROM $tbl WHERE ID = :id";
                $stid = @oci_parse($conn, $sql);
                if ($stid) {
                    oci_bind_by_name($stid, ':id', $sess_uid, -1);
                    if (@oci_execute($stid)) {
                        if ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS+OCI_RETURN_NULLS)) {
                            $foundRows[] = $row;
                            // if table contained GUARDIAN_ID or ID
                            if (!empty($row['ID'])) $resolved_gids[] = $row['ID'];
                            if (!empty($row['GUARDIAN_ID'])) $resolved_guardian_id = $row['GUARDIAN_ID'];
                        }
                    }
                    @oci_free_statement($stid);
                }
                if (!empty($foundRows)) break;
            }

            // convert useful columns from user_guardian into profile-like values
            foreach ($foundRows as $r) {
                $fields = ['FIRST_NAME','LAST_NAME','EMAIL','CONTACT_NUMBER','TYPES_OF_DS','GUARDIAN_FIRST_NAME','GUARDIAN_LAST_NAME','GUARDIAN_EMAIL','GUARDIAN_CONTACT_NUMBER','USERNAME','RELATIONSHIP_TO_USER','SCHOOL','EDUCATION','CERTIFICATES','MED_CERTIFICATES'];
                foreach ($fields as $f) {
                    if (!empty($r[$f])) {
                        $val = is_string($r[$f]) ? trim($r[$f]) : (string)$r[$f];
                        if ($val !== '') $user_profile_vals[] = $val;
                    }
                }
            }
        }
    }

    // Additional fallback: try to read Laravel file session (storage/framework/sessions) when present
    if (empty($user_profile_vals)) {
        $laravelCookie = $_COOKIE[ini_get('session.name')] ?? ($_COOKIE['laravel_session'] ?? null);
        if (!$laravelCookie && isset($_COOKIE['laravel_session'])) $laravelCookie = $_COOKIE['laravel_session'];
        if ($laravelCookie) {
            // attempt to read session file from storage/framework/sessions
            // derive project root: public/db -> go up two levels to project root
            $projectRoot = dirname(__DIR__, 2);
            $sessFile = $projectRoot . '/storage/framework/sessions/' . $laravelCookie;
            if (file_exists($sessFile) && is_readable($sessFile)) {
                $content = file_get_contents($sessFile);
                if ($content !== false) {
                    // try to find numeric ids stored in session payload
                    $found = [];
                    // look for typical keys that may contain user id
                    $patterns = [
                        '/login_web[^;]*;i:(\d+);/i',
                        '/"user_id";i:(\d+);/i',
                        '/user_id\|i:(\d+);/i',
                        '/guardian_id";i:(\d+);/i',
                        '/guardian_id\|i:(\d+);/i',
                        '/s:\d+:"auth_user_id";i:(\d+);/i'
                    ];
                    foreach ($patterns as $pat) {
                        if (preg_match($pat, $content, $m)) {
                            $found[] = $m[1];
                        }
                    }
                    if (empty($found)) {
                        // as last resort, try to find any small integer that looks like an id
                        if (preg_match_all('/i:(\d{1,12});/', $content, $m2)) {
                            foreach ($m2[1] as $num) $found[] = $num;
                        }
                    }
                    if (!empty($found)) {
                        // pick first candidate and try to resolve as user guardian id
                        $candidate = $found[0];
                        $resolved_gids[] = $candidate;
                        $resolved_guardian_id = $resolved_guardian_id ?? $candidate;
                        // fetch user_guardian rows and convert to profile-like values
                        $sql = "SELECT * FROM MVSG.USER_GUARDIAN WHERE ID = :id";
                        $stid = @oci_parse($conn, $sql);
                        if ($stid) {
                            oci_bind_by_name($stid, ':id', $candidate, -1);
                            if (@oci_execute($stid)) {
                                if ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS+OCI_RETURN_NULLS)) {
                                    $fields = ['FIRST_NAME','LAST_NAME','EMAIL','CONTACT_NUMBER','TYPES_OF_DS','GUARDIAN_FIRST_NAME','GUARDIAN_LAST_NAME','GUARDIAN_EMAIL','GUARDIAN_CONTACT_NUMBER','USERNAME','RELATIONSHIP_TO_USER','SCHOOL','EDUCATION','CERTIFICATES','MED_CERTIFICATES'];
                                    foreach ($fields as $f) {
                                        if (!empty($row[$f])) {
                                            $val = is_string($row[$f]) ? trim($row[$f]) : (string)$row[$f];
                                            if ($val !== '') $user_profile_vals[] = $val;
                                        }
                                    }
                                }
                            }
                            @oci_free_statement($stid);
                        }
                    }
                }
            }
        }
    }
}

// compare as string to avoid TO_NUMBER precision/format issues on large ids
$sql = "SELECT VALUE FROM MVSG.USER_PROFILE WHERE TO_CHAR(GUARDIAN_ID) = :uid_str";
$stid = oci_parse($conn, $sql);
$uid_str = (string)$user_id;
oci_bind_by_name($stid, ':uid_str', $uid_str, -1);
if (@oci_execute($stid)) {
    while ($r = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS+OCI_RETURN_NULLS)) {
        $v = trim((string)($r['VALUE'] ?? ''));
        if ($v !== '') $user_profile_vals[] = $v;
    }
}
@oci_free_statement($stid);

// fetch guardian certificates
$certs = [];
$sql = "SELECT ID, NAME, ISSUED_BY, WHAT_LEARNED, TO_CHAR(DATE_COMPLETED,'YYYY-MM-DD') AS DATE_COMPLETED FROM MVSG.GUARDIAN_CERTIFICATES WHERE TO_CHAR(GUARDIAN_ID) = :uid_str ORDER BY DATE_COMPLETED DESC NULLS LAST, ID DESC";
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':uid_str', $uid_str, -1);
if (@oci_execute($stid)) {
    while ($r = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS+OCI_RETURN_NULLS)) {
        $certs[] = $r;
    }
}
@oci_free_statement($stid);

// Normalization helpers
function normalize_text($s) {
    if ($s === null) return '';
    $s = mb_strtolower((string)$s, 'UTF-8');
    // remove punctuation except +,# and keep spaces
    $s = preg_replace('/[^\p{L}\p{N}\s\+#-]/u', '', $s);
    $s = preg_replace('/\s+/', ' ', $s);
    return trim($s);
}

function utf8ize($mixed) {
    if (is_array($mixed)) {
        $res = [];
        foreach ($mixed as $k => $v) $res[$k] = utf8ize($v);
        return $res;
    } elseif (is_string($mixed)) {
        return mb_convert_encoding($mixed, 'UTF-8', 'UTF-8');
    } else {
        return $mixed;
    }
}

// prepare normalized sets for matching
$norm_job = [];
foreach ($profiles as $type => $vals) {
    foreach ($vals as $v) {
        $nv = normalize_text($v);
        if ($nv === '') continue;
        $norm_job[$type][$nv] = $v; // map norm->orig
    }
}

$norm_user = [];
foreach ($user_profile_vals as $v) {
    // user_profile_vals may be strings or associative rows from DB.
    if (is_array($v)) {
        $str = '';
        if (!empty($v['VALUE'])) $str = (string)$v['VALUE'];
        elseif (!empty($v['value'])) $str = (string)$v['value'];
        elseif (!empty($v['NAME'])) $str = (string)$v['NAME'];
        else {
            // fallback: concatenate stringy parts
            $parts = [];
            foreach ($v as $part) {
                if (is_scalar($part) && trim((string)$part) !== '') $parts[] = (string)$part;
            }
            $str = implode(' ', $parts);
        }
        $nv = normalize_text($str);
        if ($nv === '') continue;
        $norm_user[$nv] = $str;
    } else {
        $nv = normalize_text((string)$v);
        if ($nv === '') continue;
        $norm_user[$nv] = (string)$v;
    }
}

// build certificate search set (normalized strings pointing to cert ids)
$cert_index = [];
foreach ($certs as $c) {
    $cid = $c['ID'] ?? null;
    $candidates = [];
    foreach (['NAME','ISSUED_BY','WHAT_LEARNED'] as $k) {
        if (!empty($c[$k])) $candidates[] = (string)$c[$k];
    }
    foreach ($candidates as $cand) {
        $nc = normalize_text($cand);
        if ($nc === '') continue;
        if (!isset($cert_index[$nc])) $cert_index[$nc] = [];
        $cert_index[$nc][] = $c;
    }
}

// compute matches
$matches = [
    'skills' => [],
    'job_preference' => [],
    'workplace' => [],
    'key_responsibilities' => [],
    'qualifications' => [],
    'why_join_us' => [],
    'certificates' => [],
    'user_profile_matches' => []
];

// categories mapping: job_profile TYPE values may vary
$category_keys = [
    'skills' => ['skills'],
    'job_preference' => ['job_preference','job_positions','job_preference_positions','job_preferences'],
    'workplace' => ['workplace','working_environment'],
    'key_responsibilities' => ['key_responsibilities','responsibilities'],
    'qualifications' => ['qualifications','what_we_are_looking_for'],
    'why_join_us' => ['why_join_us','why_join']
];

foreach ($category_keys as $outKey => $aliases) {
    foreach ($aliases as $alias) {
        if (!isset($norm_job[$alias])) continue;
        foreach ($norm_job[$alias] as $norm => $orig) {
            // match against user profile exact normalized values
            if (isset($norm_user[$norm])) {
                $matches[$outKey][] = ['value' => $orig, 'matched_from' => 'user_profile', 'user_value' => $norm_user[$norm]];
            }
            // match against certificates
            if (isset($cert_index[$norm])) {
                foreach ($cert_index[$norm] as $certRow) {
                    $matches['certificates'][] = ['value' => $orig, 'matched_cert' => $certRow];
                }
            }
        }
    }
}

// also find any user_profile values that directly match any job profile (reverse)
foreach ($norm_user as $norm => $origUserVal) {
    foreach ($norm_job as $type => $map) {
        if (isset($map[$norm])) {
            $matches['user_profile_matches'][] = ['value' => $map[$norm], 'profile_value' => $origUserVal, 'type' => $type];
        }
    }
}

// deduplicate each match list by normalized value
foreach ($matches as $k => $list) {
    $seen = [];
    $uniq = [];
    foreach ($list as $item) {
        $key = normalize_text(is_array($item) && isset($item['value']) ? $item['value'] : (is_string($item)?$item:''));
        if ($key === '') continue;
        if (isset($seen[$key])) continue;
        $seen[$key] = true;
        $uniq[] = $item;
    }
    $matches[$k] = array_values($uniq);
}

// build ordered job profile items (keep job description first), annotate with matches
$job_profile_items = [];
foreach ($profiles as $type => $vals) {
    foreach ($vals as $v) {
        $nv = normalize_text($v);
        $item = [
            'type' => $type,
            'value' => $v,
            'normalized' => $nv,
            'matched_user_value' => null,
            'matched_certificates' => []
        ];
        if ($nv !== '') {
            if (isset($norm_user[$nv])) {
                $item['matched_user_value'] = $norm_user[$nv];
            }
            if (isset($cert_index[$nv])) {
                $item['matched_certificates'] = $cert_index[$nv];
            }
        }
        $job_profile_items[] = $item;
    }
}

// compute perfect matches (normalized) between job profile entries and user profile values
$perfect_matches = [];
foreach ($norm_job as $type => $map) {
    foreach ($map as $norm => $orig) {
        if (isset($norm_user[$norm])) {
            if (!isset($perfect_matches[$type])) $perfect_matches[$type] = [];
            $perfect_matches[$type][] = ['value' => $orig, 'user_value' => $norm_user[$norm]];
        }
    }
}

// final response
$resp = [
    'success' => true,
    'job_id' => (string)$job_id,
    'user_id' => (string)$user_id,
    'matches' => $matches,
    'perfect_matches' => $perfect_matches,
    'job_profile_items' => $job_profile_items,
    'stats' => [
        'job_profile_count' => array_sum(array_map('count', $profiles)),
        'user_profile_count' => count($user_profile_vals),
        'cert_count' => count($certs),
    ],
    'raw' => [ 'job_profiles' => $profiles, 'user_profile_values' => $user_profile_vals ]
];

// include resolution diagnostics for debugging user profile lookup
$resp['diagnostics'] = [
    'requested_user_id' => (string)$user_id,
    'resolved_guardian_id' => $resolved_guardian_id,
    'resolved_gids' => $resolved_gids,
    'user_profile_rows' => count($user_profile_vals)
];

    // include fetched job title/description for client display
    if (!empty($job_title)) $resp['job_title'] = $job_title;
    if (!empty($job_description)) $resp['job_description'] = $job_description;

$resp = utf8ize($resp);
$out = json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if ($out === false) {
    echo json_encode(['success' => false, 'error' => 'json_encode failed']);
} else {
    echo $out;
}

@oci_close($conn);

?>
