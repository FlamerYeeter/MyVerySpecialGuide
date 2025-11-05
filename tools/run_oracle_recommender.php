<?php
// Standalone recommender runner for quick testing.
// Usage: php tools/run_oracle_recommender.php [uid=123] [top_n=10] [content_weight=0.6] [local=0]

require_once __DIR__ . '/../public/db/oracledb.php';

$options = [];
foreach (array_slice($argv,1) as $a) {
    if (strpos($a,'=')!==false) { list($k,$v)=explode('=', $a, 2); $options[$k]=$v; }
}

$uid = isset($options['uid']) ? intval($options['uid']) : 0;
$topN = isset($options['top_n']) ? max(1,intval($options['top_n'])) : 10;
$contentWeight = isset($options['content_weight']) ? floatval($options['content_weight']) : 0.6;
$contentWeight = max(0.0, min(1.0, $contentWeight));
$collabWeight = 1.0 - $contentWeight;
$useLocal = (isset($options['local']) && $options['local'] == '1');

// Connect (Oracle only)
$conn = null;
$ociAvailable = function_exists('oci_connect');
if ($ociAvailable) {
    try { $conn = getOracleConnection(); } catch (\Throwable $e) { $conn = null; }
}

if (!$conn) {
    echo json_encode(['ok'=>false,'error'=>'oracle_unavailable','message'=>'OCI8 not available or connection failed']);
    exit(1);
}

// helper: pick the first working table name variant
function chooseTable($conn, $variants) {
    foreach ($variants as $t) {
        $sql = "SELECT COUNT(*) CNT FROM " . $t;
        $stid = @oci_parse($conn, $sql);
        if ($stid) {
            if (@oci_execute($stid)) {
                $r = @oci_fetch_array($stid, OCI_NUM+OCI_RETURN_NULLS);
                @oci_free_statement($stid);
                if ($r !== false) return $t;
            } else {
                @oci_free_statement($stid);
            }
        }
    }
    return null;
}

// detect correct table names (prefer MVSG_ prefix then MVSG.schema then bare)
$recTable = chooseTable($conn, ['MVSG_RECOMMENDATION','MVSG.RECOMMENDATION','RECOMMENDATION']);
$jobTable = chooseTable($conn, ['MVSG_JOB_POSTINGS','MVSG.JOB_POSTINGS','JOB_POSTINGS']);
$guardianTable = chooseTable($conn, ['MVSG_USER_GUARDIAN','MVSG.USER_GUARDIAN','USER_GUARDIAN']);
$profileTable = chooseTable($conn, ['MVSG_USER_PROFILE','MVSG.USER_PROFILE','USER_PROFILE']);

if (!$recTable || !$jobTable || !$guardianTable) {
    echo json_encode(['ok'=>false,'error'=>'tables_not_found','recTable'=>$recTable,'jobTable'=>$jobTable,'guardianTable'=>$guardianTable,'profileTable'=>$profileTable], JSON_PRETTY_PRINT);
    exit(1);
}

// use detected names in subsequent SQL


try {
    // If uid missing, pick one
    if (empty($uid)) {
        if ($useLocal) {
            $sqlite = __DIR__ . '/../database/database.sqlite';
            if (!file_exists($sqlite)) throw new Exception('local sqlite not found: ' . $sqlite);
            $pdo = new PDO('sqlite:' . $sqlite);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $row = $pdo->query('SELECT ID FROM MVSG_USER_GUARDIAN LIMIT 1')->fetch(PDO::FETCH_ASSOC);
            if ($row) $uid = intval($row['ID']);
        } else {
            $sql = "SELECT ID FROM MVSG_USER_GUARDIAN WHERE ROWNUM = 1";
            $stid = @oci_parse($conn, $sql);
            if ($stid) { @oci_execute($stid); $prow = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS); @oci_free_statement($stid); if (!empty($prow['ID'])) $uid = intval($prow['ID']); }
        }
    }

    // 1) Fetch recommendations for user
    $recs = [];
    if ($useLocal) {
        $recSql = "SELECT JOB_ID, COMMENT_SCORE FROM MVSG_RECOMMENDATION WHERE EXPERT_ID = :uid LIMIT 500";
        $stmt = $pdo->prepare($recSql);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($r['JOB_ID'])) $recs[] = ['job_id'=>intval($r['JOB_ID']),'fit_score'=>isset($r['COMMENT_SCORE'])?floatval($r['COMMENT_SCORE']):0.0];
        }
    } else {
        $recSql = "SELECT JOB_ID, COMMENT_SCORE FROM MVSG_RECOMMENDATION WHERE EXPERT_ID = :uid AND ROWNUM <= 500";
        $stid = @oci_parse($conn, $recSql);
        if ($stid) {
            oci_bind_by_name($stid, ':uid', $uid);
            @oci_execute($stid);
            while ($r = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                if (!empty($r['JOB_ID'])) $recs[] = ['job_id'=>intval($r['JOB_ID']),'fit_score'=>isset($r['COMMENT_SCORE'])?floatval($r['COMMENT_SCORE']):0.0];
            }
            @oci_free_statement($stid);
        }
    }

    // 1b) popularity map
    $popMap = [];
    $maxPop = 1.0;
    if ($useLocal) {
        $popSql = "SELECT JOB_ID, COUNT(*) as CNT FROM MVSG_RECOMMENDATION GROUP BY JOB_ID ORDER BY CNT DESC";
        $stmt = $pdo->query($popSql);
        while ($rp = $stmt->fetch(PDO::FETCH_ASSOC)) { if (!empty($rp['JOB_ID'])) { $jid=intval($rp['JOB_ID']); $popMap[$jid]=intval($rp['CNT']??0); }}
        if (!empty($popMap)) $maxPop = max($popMap)>0?max($popMap):1.0;
    } else {
        $popSql = "SELECT JOB_ID, COUNT(*) CNT FROM MVSG_RECOMMENDATION GROUP BY JOB_ID ORDER BY COUNT(*) DESC";
        $pSt = @oci_parse($conn, $popSql);
        if ($pSt) {
            @oci_execute($pSt);
            while ($rp = @oci_fetch_array($pSt, OCI_ASSOC+OCI_RETURN_NULLS)) { if (!empty($rp['JOB_ID'])) { $jid=intval($rp['JOB_ID']); $popMap[$jid]=intval($rp['CNT']??0); }}
            @oci_free_statement($pSt);
            if (!empty($popMap)) $maxPop = max($popMap)>0?max($popMap):1.0;
        }
    }

    // Build candidate job ids
    $candidateJobIds = [];
    if (!empty($recs)) { foreach ($recs as $r) $candidateJobIds[] = intval($r['job_id']); }
    else {
        $i=0; foreach ($popMap as $jid=>$cnt) { $candidateJobIds[]=$jid; $i++; if ($i>= $topN*2) break; }
    }

    // Still empty -> sample jobs
    if (empty($candidateJobIds)) {
        $m = max(1, min(500, $topN*3));
        if ($useLocal) {
            $sampleSql = "SELECT ID FROM MVSG_JOB_POSTINGS LIMIT :m";
            $stmt = $pdo->prepare($sampleSql);
            $stmt->bindValue(':m', $m, PDO::PARAM_INT);
            $stmt->execute();
            while ($jr2 = $stmt->fetch(PDO::FETCH_ASSOC)) { if (!empty($jr2['ID'])) $candidateJobIds[] = intval($jr2['ID']); }
        } else {
            $sampleSql = "SELECT ID FROM MVSG_JOB_POSTINGS WHERE ROWNUM <= :m";
            $sSt2 = @oci_parse($conn, $sampleSql);
            if ($sSt2) {
                oci_bind_by_name($sSt2, ':m', $m);
                @oci_execute($sSt2);
                while ($jr2 = @oci_fetch_array($sSt2, OCI_ASSOC+OCI_RETURN_NULLS)) { if (!empty($jr2['ID'])) $candidateJobIds[] = intval($jr2['ID']); }
                @oci_free_statement($sSt2);
            }
        }
    }

    // Fetch job metadata for candidate ids
    $jobs = [];
    $candidateJobIds = array_values(array_unique($candidateJobIds));
    if (!empty($candidateJobIds)) {
        $in = implode(',', array_map('intval', $candidateJobIds));
        // Use actual column names present in MVSG_JOB_POSTINGS (ADDRESS and JOB_TYPE are used
        // in this schema instead of LOCATION and EMPLOYMENT_TYPE).
        if ($useLocal) {
            $jq = "SELECT ID, TITLE, REQUIRED_SKILLS, ADDRESS, EXPERIENCE_LEVEL, JOB_TYPE, COMPANY_ID FROM MVSG_JOB_POSTINGS WHERE ID IN (" . $in . ")";
            $stmt = $pdo->query($jq);
            while ($j = $stmt->fetch(PDO::FETCH_ASSOC)) { if (!empty($j['ID'])) $jobs[intval($j['ID'])] = $j; }
        } else {
            $jq = "SELECT ID, TITLE, REQUIRED_SKILLS, ADDRESS, EXPERIENCE_LEVEL, JOB_TYPE, COMPANY_ID FROM MVSG_JOB_POSTINGS WHERE ID IN (" . $in . ")";
            $js = @oci_parse($conn, $jq);
            if ($js) { @oci_execute($js); while ($j = @oci_fetch_array($js, OCI_ASSOC+OCI_RETURN_NULLS)) { if (!empty($j['ID'])) $jobs[intval($j['ID'])] = $j; } @oci_free_statement($js); }
        }
    }

    // If some candidate IDs did not return metadata, fetch them individually (robust fallback)
    $missing = array_values(array_diff($candidateJobIds, array_map('intval', array_keys($jobs))));
    if (!empty($missing) && !$useLocal) {
        foreach ($missing as $mid) {
            try {
                // individual fetch uses same, corrected column names
                $jq2 = "SELECT ID, TITLE, REQUIRED_SKILLS, ADDRESS, EXPERIENCE_LEVEL, JOB_TYPE, COMPANY_ID FROM MVSG_JOB_POSTINGS WHERE ID = :id";
                $js2 = @oci_parse($conn, $jq2);
                if ($js2) {
                    oci_bind_by_name($js2, ':id', $mid);
                    @oci_execute($js2);
                    $j = @oci_fetch_array($js2, OCI_ASSOC+OCI_RETURN_NULLS);
                    @oci_free_statement($js2);
                    if ($j && !empty($j['ID'])) $jobs[intval($j['ID'])] = $j;
                }
            } catch (Exception $e) { /* ignore individual failures */ }
        }
    }

    // Fetch user profile: key/value and guardian fields
    $profileRows = [];
    $guardianRow = [];
    if ($useLocal) {
        $uSql = "SELECT KEY, VALUE FROM MVSG_USER_PROFILE WHERE GUARDIAN_ID = :id LIMIT 200";
        $stmt = $pdo->prepare($uSql);
        $stmt->bindValue(':id', $uid, PDO::PARAM_INT);
        $stmt->execute();
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) $profileRows[] = $r;
        $gSql = "SELECT FIRST_NAME, LAST_NAME, ADDRESS, SECTION, CERTIFICATES, ROLE FROM MVSG_USER_GUARDIAN WHERE ID = :id LIMIT 1";
        $gstmt = $pdo->prepare($gSql);
        $gstmt->bindValue(':id', $uid, PDO::PARAM_INT);
        $gstmt->execute();
        $guardianRow = $gstmt->fetch(PDO::FETCH_ASSOC) ?: [];
    } else {
        $uSql = "SELECT KEY, VALUE FROM MVSG_USER_PROFILE WHERE GUARDIAN_ID = :id";
        $us = @oci_parse($conn, $uSql);
        if ($us) { oci_bind_by_name($us, ':id', $uid); @oci_execute($us); while ($r = @oci_fetch_array($us, OCI_ASSOC+OCI_RETURN_NULLS)) $profileRows[] = $r; @oci_free_statement($us); }
        $gSql = "SELECT FIRST_NAME, LAST_NAME, ADDRESS, SECTION, CERTIFICATES, ROLE FROM MVSG_USER_GUARDIAN WHERE ID = :id";
        $gs = @oci_parse($conn, $gSql);
        if ($gs) { oci_bind_by_name($gs, ':id', $uid); @oci_execute($gs); $gRow = @oci_fetch_array($gs, OCI_ASSOC+OCI_RETURN_NULLS); @oci_free_statement($gs); if ($gRow) $guardianRow = $gRow; }
    }

    // Tokenize user text
    $tokenize = function($s) {
        $s = mb_strtolower((string)$s);
        $parts = preg_split('/[^\p{L}\p{N}]+/u', $s);
        $out = [];
        foreach ($parts as $p) { $p = trim($p); if ($p === '' || mb_strlen($p) < 2) continue; $out[$p]=true; }
        return array_keys($out);
    };

    $userTextParts = [];
    foreach ($profileRows as $pr) {
        $k = isset($pr['KEY']) ? $pr['KEY'] : (isset($pr['key']) ? $pr['key'] : '');
        $v = isset($pr['VALUE']) ? $pr['VALUE'] : (isset($pr['value']) ? $pr['value'] : '');
        if ($k!=='') $userTextParts[] = $k;
        if ($v!=='') $userTextParts[] = $v;
    }
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

    // Precompute job tokens
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

    // Build scores
    $candidates = [];
    $recsByJob = [];
    foreach ($recs as $r) { if (!empty($r['job_id'])) $recsByJob[intval($r['job_id'])] = floatval($r['fit_score']); }
    $maxFit = 0.0; foreach ($recsByJob as $v) if ($v > $maxFit) $maxFit = $v; $maxFit = $maxFit>0?$maxFit:1.0;

    $allJobIds = array_values(array_unique(array_merge($candidateJobIds, array_keys($jobs))));
    foreach ($allJobIds as $jid) {
        $jrow = isset($jobs[$jid]) ? $jobs[$jid] : ['ID'=>$jid];
        $jtokens = isset($jobTokensMap[$jid]) ? $jobTokensMap[$jid] : [];
        if (count($userTokens) > 0) {
            $common = count(array_intersect($userTokens, $jtokens));
            $contentScore = $userTokenCount > 0 ? ($common / $userTokenCount) : 0.0;
        } else {
            $contentScore = $maxJobTokens > 0 ? (count($jtokens) / $maxJobTokens) : 0.0;
        }
        $collabRaw = 0.0;
        if (isset($recsByJob[$jid])) $collabRaw = $recsByJob[$jid] / $maxFit;
        elseif (isset($popMap[$jid])) $collabRaw = $maxPop > 0 ? ($popMap[$jid]/$maxPop) : 0.0;
        $collabScore = max(0.0, min(1.0, floatval($collabRaw)));
        $hybridScore = $contentWeight * $contentScore + $collabWeight * $collabScore;
        $candidates[] = ['id'=>$jid,'title'=>$jrow['TITLE'] ?? null,'company'=>$jrow['COMPANY_ID'] ?? null,'content_score'=>round($contentScore,4),'collab_score'=>round($collabScore,4),'hybrid_score'=>round($hybridScore,4)];
    }

    usort($candidates, function($a,$b){ return ($b['hybrid_score'] <=> $a['hybrid_score']); });
    $candidates = array_slice($candidates,0,$topN);

    echo json_encode(['ok'=>true,'uid'=>$uid?:null,'mode'=>'hybrid','hybrid'=>$candidates], JSON_PRETTY_PRINT);
    exit(0);

} catch (Exception $e) {
    echo json_encode(['ok'=>false,'error'=>'exception','message'=>$e->getMessage()]);
    exit(2);
}
