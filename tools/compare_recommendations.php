<?php
// compare_recommendations.php
// Usage: php compare_recommendations.php
// Reads public/recommendations.json or public/postings.csv and reproduces the server-side
// pipeline used by job-matches and guardianreview-pending-review. Outputs a diff for page 1.

function load_json_recommendations($json_path) {
    $out = [];
    if (!file_exists($json_path)) return $out;
    $json = @file_get_contents($json_path);
    $rows = json_decode($json, true) ?: [];
    if (!is_array($rows)) return $out;
    foreach ($rows as $index => $row) {
        $title = trim($row['title'] ?? $row['Title'] ?? $row['job_title'] ?? '');
        $company = trim($row['company'] ?? $row['Company'] ?? '');
        $job_description = trim($row['job_description'] ?? $row['JobDescription'] ?? $row['description'] ?? '');
        $computedScore = $row['computed_score'] ?? $row['computed_score_normalized'] ?? null;
        $computedMax = $row['computed_max_score'] ?? $row['computed_max'] ?? null;
        $match = $row['match_score'] ?? ($computedScore ?? 0);
        if (is_numeric($match) && $match > 0 && $match <= 1.01) $match = $match * 100;
        $out[] = [
            'job_id' => isset($row['job_id']) ? (string)$row['job_id'] : (string)$index,
            'title' => $title ?: (strlen($job_description) ? mb_substr($job_description, 0, 80) : 'Untitled Job'),
            'company' => $company,
            'match_score' => intval(round(floatval($match))),
            'raw' => $row,
        ];
    }
    return $out;
}

function load_csv_postings($csv_path, $maxRows = 5000) {
    $out = [];
    if (!file_exists($csv_path)) return $out;
    if (($handle = fopen($csv_path, 'r')) === false) return $out;
    $header = fgetcsv($handle);
    if ($header === false) { fclose($handle); return $out; }
    $cols = array_map('trim', $header);
    $numCols = count($cols);
    if ($numCols === 0) { fclose($handle); return $out; }
    $i = 0;
    while (($row = fgetcsv($handle)) !== false) {
        if ($numCols > 0) {
            if (count($row) < $numCols) $row = array_merge($row, array_fill(0, $numCols - count($row), ''));
            elseif (count($row) > $numCols) $row = array_slice($row, 0, $numCols);
            if (count($row) !== $numCols) continue;
        }
        if ($i >= $maxRows) break;
        $assoc = $numCols ? (array_combine($cols, $row) ?: []) : [];
        $title = $assoc['title'] ?? $assoc['jobtitle'] ?? $assoc['Title'] ?? '';
        $company = $assoc['company_name'] ?? $assoc['company'] ?? '';
        $description = $assoc['description'] ?? $assoc['JobDescription'] ?? '';
        // simple heuristic score
        $skills_desc = $assoc['skills_desc'] ?? '';
        $textForScoring = trim($title . ' ' . $description . ' ' . $skills_desc);
        $tokens = preg_split('/\W+/', strtolower($textForScoring));
        $tokens = array_filter($tokens, function($t){ return strlen($t) > 2; });
        $totalTokens = max(1, count($tokens));
        $unique = array_unique($tokens);
        $skillTokens = preg_split('/\W+/', strtolower($skills_desc));
        $skillTokens = array_filter($skillTokens, function($t){ return strlen($t) > 2; });
        $skillCount = count($skillTokens);
        $scoreBase = count($unique) / $totalTokens;
        $skillBoost = min(1.5, $skillCount / max(1, min(50, $totalTokens)) );
        $contentScore = round(($scoreBase * 0.7 + $skillBoost * 0.3) * 100, 2);
        $out[] = [
            'job_id' => isset($assoc['job_id']) ? (string)$assoc['job_id'] : (string)$i,
            'title' => trim($title) ?: (strlen(trim($description)) ? mb_substr(trim($description), 0, 80) : 'Untitled Job'),
            'company' => trim($company),
            'match_score' => intval(round(floatval($assoc['match_score'] ?? $contentScore ?? 0))),
            'raw' => $assoc,
        ];
        $i++;
    }
    fclose($handle);
    return $out;
}

function sort_recommendations(&$arr) {
    usort($arr, function($a, $b) {
        $getRaw = function($x) {
            if (isset($x['raw']['content_score']) && $x['raw']['content_score'] !== null) return floatval($x['raw']['content_score']);
            if (isset($x['raw']['computed_score']) && $x['raw']['computed_score'] !== null) return floatval($x['raw']['computed_score']);
            if (isset($x['content_score']) && $x['content_score'] !== null) return floatval($x['content_score']);
            return floatval($x['match_score'] ?? 0);
        };
        $norm = function($val) {
            if ($val > 0 && $val <= 1.01) return $val * 100.0;
            return $val;
        };
        $aScore = $norm($getRaw($a));
        $bScore = $norm($getRaw($b));
        return $bScore <=> $aScore;
    });
}

// Load datasets
$base = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
$json_path = realpath($base . 'public' . DIRECTORY_SEPARATOR . 'recommendations.json');
$csv_path = realpath($base . 'public' . DIRECTORY_SEPARATOR . 'postings.csv');

$matches = [];
if ($json_path && file_exists($json_path)) {
    $matches = load_json_recommendations($json_path);
} elseif ($csv_path && file_exists($csv_path)) {
    $matches = load_csv_postings($csv_path);
}

$guardian_jobs = [];
// guardian pending logic uses same pipeline; simulate same source
if ($json_path && file_exists($json_path)) {
    $guardian_jobs = load_json_recommendations($json_path);
} elseif ($csv_path && file_exists($csv_path)) {
    $guardian_jobs = load_csv_postings($csv_path);
}

// Normalize fractional values and content_score if missing
foreach ($matches as &$m) {
    $raw = $m['raw'] ?? [];
    $rawContent = $raw['content_score'] ?? $raw['computed_score'] ?? $m['match_score'] ?? 0;
    if (is_numeric($rawContent) && $rawContent > 0 && $rawContent <= 1.01) $rawContent = $rawContent * 100;
    $m['match_percent'] = intval(round(floatval($rawContent)));
}
foreach ($guardian_jobs as &$g) {
    $raw = $g['raw'] ?? [];
    $rawContent = $raw['content_score'] ?? $raw['computed_score'] ?? $g['match_score'] ?? 0;
    if (is_numeric($rawContent) && $rawContent > 0 && $rawContent <= 1.01) $rawContent = $rawContent * 100;
    $g['match_percent'] = intval(round(floatval($rawContent)));
}

// Sort both using same comparator
sort_recommendations($matches);
sort_recommendations($guardian_jobs);

// Take first page (10)
$perPage = 10;
$matchesPage = array_slice($matches, 0, $perPage);
$guardianPage = array_slice($guardian_jobs, 0, $perPage);

// Build maps for comparison
$matchesMap = [];
foreach ($matchesPage as $i => $m) {
    $matchesMap[$i] = ['job_id'=>$m['job_id'],'title'=>$m['title'],'match_percent'=>$m['match_percent']];
}
$guardianMap = [];
foreach ($guardianPage as $i => $g) {
    $guardianMap[$i] = ['job_id'=>$g['job_id'],'title'=>$g['title'],'match_percent'=>$g['match_percent']];
}

// Compare titles and percents per position
$diffs = ['positions' => [], 'missing_in_guardian' => [], 'missing_in_matches' => []];
for ($i=0;$i<$perPage;$i++) {
    $m = $matchesMap[$i] ?? null;
    $g = $guardianMap[$i] ?? null;
    if ($m && $g) {
        if ($m['job_id'] !== $g['job_id'] || $m['title'] !== $g['title'] || $m['match_percent'] !== $g['match_percent']) {
            $diffs['positions'][] = ['pos'=>$i+1,'matches'=>$m,'guardian'=>$g];
        }
    } elseif ($m && !$g) {
        $diffs['missing_in_guardian'][] = $m;
    } elseif (!$m && $g) {
        $diffs['missing_in_matches'][] = $g;
    }
}

// Additionally, list job_ids that are in matchesPage but at different positions in guardianPage
$matchesIds = array_column($matchesPage,'job_id');
$guardianIds = array_column($guardianPage,'job_id');
$positionDiffs = [];
foreach ($matchesIds as $pos => $jid) {
    $gPos = array_search($jid, $guardianIds, true);
    if ($gPos === false) continue;
    if ($gPos !== $pos) {
        $positionDiffs[] = ['job_id'=>$jid,'matches_pos'=>$pos+1,'guardian_pos'=>$gPos+1];
    }
}

$report = [
    'matchesPage' => $matchesMap,
    'guardianPage' => $guardianMap,
    'diffs' => $diffs,
    'positionDiffs' => $positionDiffs,
];

echo json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;

return 0;
