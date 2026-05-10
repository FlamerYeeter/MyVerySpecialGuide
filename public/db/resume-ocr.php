<?php
// resume-ocr.php
// Endpoint: extracts raw text from an uploaded resume (image or PDF) using tesseract
// Accepts JSON POST { ocr_data: <base64 string> } or multipart file upload (file)

error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);
header('Content-Type: application/json');

// Maximum base64 length ~15MB
define('MAX_BASE64_RESUME', 15_000_000);

function response_json($ok, $message, $data = []) {
    http_response_code($ok ? 200 : 400);
    echo json_encode(array_merge(['success' => $ok, 'message' => $message], $data), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function create_temp_from_base64_resume($raw, $tmpDir, &$created) {
    if (strpos($raw, ',') !== false) $parts = explode(',', $raw, 2); else $parts = [null, $raw];
    $prefix = $parts[0] ?? null; $b64 = $parts[1] ?? $parts[0];
    if (!is_string($b64) || $b64 === '') return [null, null];
    if (strlen($b64) > MAX_BASE64_RESUME) return [null, null];
    $fileData = base64_decode($b64);
    if ($fileData === false) return [null, null];

    $ext = null;
    if ($prefix !== null) {
        if (str_starts_with($prefix, 'data:image/jpeg')) $ext = '.jpg';
        elseif (str_starts_with($prefix, 'data:image/png')) $ext = '.png';
        elseif (str_starts_with($prefix, 'data:application/pdf')) $ext = '.pdf';
        elseif (str_starts_with($prefix, 'data:image/tiff')) $ext = '.tif';
    }
    if (!$ext) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_buffer($finfo, $fileData);
        finfo_close($finfo);
        $map = ['image/jpeg'=>'.jpg','image/png'=>'.png','application/pdf'=>'.pdf','image/tiff'=>'.tif'];
        $ext = $map[$mime] ?? null;
    }
    if (!$ext) return [null, null];

    $tmp = tempnam($tmpDir, 'rocr_');
    $tmpFile = $tmp . $ext;
    rename($tmp, $tmpFile);
    if (file_put_contents($tmpFile, $fileData) === false) return [null, null];
    $created[] = $tmpFile;
    return [$tmpFile, $ext];
}

function cleanup_files($files) {
    foreach ($files as $f) if ($f && file_exists($f)) @unlink($f);
}

// Read input
$rawInput = file_get_contents('php://input');
$body = json_decode($rawInput, true);
$tmpDir = sys_get_temp_dir();
$createdFiles = [];
$images = [];

// Support multipart file upload first
if (!empty($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
    $up = $_FILES['file'];
    $name = $up['tmp_name'];
    $orig = $up['name'] ?? 'upload';
    $mime = mime_content_type($name);
    $ext = pathinfo($orig, PATHINFO_EXTENSION);
    $target = tempnam($tmpDir, 'rocr_') . '.' . ($ext ?: 'bin');
    if (!move_uploaded_file($name, $target)) {
        response_json(false, 'Failed to move uploaded file');
    }
    $createdFiles[] = $target;
    // If pdf -> convert, else treat as image
    if (strtolower($ext) === 'pdf' || $mime === 'application/pdf') {
        $outPrefix = $target . '_img';
        // use pdftoppm to convert to PNG pages
        @shell_exec('pdftoppm -png ' . escapeshellarg($target) . ' ' . escapeshellarg($outPrefix));
        $page = 1;
        while (file_exists($outPrefix . '-' . $page . '.png')) {
            $images[] = $outPrefix . '-' . $page . '.png';
            $page++;
        }
        if (empty($images)) {
            cleanup_files($createdFiles);
            response_json(false, 'PDF conversion failed or produced no pages');
        }
    } else {
        $images[] = $target;
    }

} else {
    // JSON body with base64
    $b64 = $body['ocr_data'] ?? null;
    if (empty($b64)) response_json(false, 'No file provided (multipart or JSON base64 expected)');

    if (is_array($b64)) {
        foreach ($b64 as $raw) {
            list($tmpFile, $ext) = create_temp_from_base64_resume($raw, $tmpDir, $createdFiles);
            if (!$tmpFile) continue;
            if ($ext === '.pdf') {
                $outPrefix = $tmpFile . '_img';
                @shell_exec('pdftoppm -png ' . escapeshellarg($tmpFile) . ' ' . escapeshellarg($outPrefix));
                $page = 1;
                while (file_exists($outPrefix . '-' . $page . '.png')) {
                    $images[] = $outPrefix . '-' . $page . '.png';
                    $createdFiles[] = $outPrefix . '-' . $page . '.png';
                    $page++;
                }
            } else {
                $images[] = $tmpFile;
            }
        }
    } else {
        list($tmpFile, $ext) = create_temp_from_base64_resume($b64, $tmpDir, $createdFiles);
        if (!$tmpFile) { cleanup_files($createdFiles); response_json(false, 'Invalid base64 file'); }
        if ($ext === '.pdf') {
            $outPrefix = $tmpFile . '_img';
            @shell_exec('pdftoppm -png ' . escapeshellarg($tmpFile) . ' ' . escapeshellarg($outPrefix));
            $page = 1;
            while (file_exists($outPrefix . '-' . $page . '.png')) {
                $images[] = $outPrefix . '-' . $page . '.png';
                $createdFiles[] = $outPrefix . '-' . $page . '.png';
                $page++;
            }
            if (empty($images)) { cleanup_files($createdFiles); response_json(false, 'PDF conversion failed'); }
        } else {
            $images[] = $tmpFile;
        }
    }
}

if (empty($images)) { cleanup_files($createdFiles); response_json(false, 'No images to OCR'); }

// Optional preprocessing: convert to PNG and enhance (ImageMagick) - skip heavy ops to keep simple
$processed = [];
foreach ($images as $img) {
    // ensure it's PNG
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    if ($ext !== 'png') {
        $out = $img . '_conv.png';
        @shell_exec('magick ' . escapeshellarg($img) . ' -flatten -colorspace Gray -resize 200% -sharpen 0x1 ' . escapeshellarg($out));
        if (file_exists($out)) {
            $processed[] = $out;
            $createdFiles[] = $out;
        } else {
            $processed[] = $img;
        }
    } else {
        $processed[] = $img;
    }
}

// Run Tesseract on each processed image and collect text
$allText = '';
$perPage = [];
foreach ($processed as $idx => $pimg) {
    $outTxt = $pimg . '.txt';
    // Tesseract: output to stdout is also possible, but we'll write file to be safe
    // Use English by default; user can adjust locale if needed
    $cmd = 'tesseract ' . escapeshellarg($pimg) . ' ' . escapeshellarg($pimg) . ' -l eng --oem 1 --psm 3 2>&1';
    $execOut = shell_exec($cmd);
    // tesseract writes to $pimg . '.txt'
    $txtFile = $pimg . '.txt';
    $text = '';
    if (file_exists($txtFile)) {
        $text = file_get_contents($txtFile);
        $createdFiles[] = $txtFile;
    } else {
        // fallback: try to capture stdout if tesseract printed text
        $text = trim($execOut ?: '');
    }
    $perPage[] = ['page' => $idx+1, 'image' => basename($pimg), 'text' => $text];
    $allText .= ($text ? $text . "\n\n" : '');
}

// Cleanup temp images but keep text files if needed; we clean everything we created
cleanup_files($createdFiles);

$raw = trim($allText);

// --- Structured extraction heuristics ---
function extract_emails($text) {
    preg_match_all('/[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}/', $text, $m);
    $arr = array_values(array_unique($m[0] ?? []));
    return $arr;
}

function extract_phones($text) {
    // common phone patterns (international, with spaces, dashes, parenthesis)
    preg_match_all('/(?:\+?\d{1,3}[\s\-\.])?(?:\(\d{2,4}\)|\d{2,4})[\s\-\.]*\d{3,4}[\s\-\.]*\d{3,4}/', $text, $m);
    $arr = array_values(array_unique(array_filter(array_map(function($s){ return preg_replace('/\s+/', ' ', trim($s)); }, $m[0] ?? []))));
    return $arr;
}

function extract_name_candidate($text) {
    // Improved name extraction heuristics:
    // 1. If explicit 'Name:' label exists, use it.
    // 2. Prefer lines immediately above an email/phone block (common layout).
    // 3. Scan for likely name lines: 2-4 word tokens, alphabetic, not a section heading.
    // 4. Reject common section headings like 'CAREER SUMMARY', 'PROJECTS', etc.

    $stop_headings = [
        'career summary','summary','objective','profile','projects','experience','education','skills','certificates','certifications','contact','language','languages','references'
    ];

    // 1) explicit 'Name:' pattern
    if (preg_match('/\bName\s*[:\-]\s*([A-Z][A-Za-z\'\-]+(?:\s+[A-Z][A-Za-z\'\-]+){0,3})/i', $text, $m)) {
        return trim($m[1]);
    }

    // Helper: validate a candidate string as a probable person name
    $is_valid_name = function($s) use ($stop_headings) {
        if (!$s) return false;
        $s = trim($s);
        if (strlen($s) < 3 || strlen($s) > 80) return false;
        // reject if contains digits or excessive punctuation
        if (preg_match('/[0-9]/', $s)) return false;
        // normalize for checks
        $low = strtolower($s);
        // reject if matches any stop heading tokens
        foreach ($stop_headings as $h) {
            if (preg_match('/\b' . preg_quote($h, '/') . '\b/i', $low)) return false;
        }
        // require at least two words
        $parts = preg_split('/\s+/', $s);
        if (count($parts) < 2) return false;
        // each word should be alphabetic or single initial
        $okCount = 0;
        foreach ($parts as $p) {
            $p = trim($p, ".,\-\'");
            if ($p === '') continue;
            if (preg_match('/^[A-Za-z]$/', $p) || preg_match('/^[A-Za-z][A-Za-z\'\-]{1,}$/', $p)) $okCount++; 
        }
        return $okCount >= 2;
    };

    // 2) Prefer name just above email/phone lines
    if (preg_match_all('/^.*@[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/m', $text, $_emails) || preg_match_all('/@/', $text)) {
        // find email positions
        if (preg_match_all('/^.*[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}.*$/m', $text, $emMatches, PREG_OFFSET_CAPTURE)) {
            foreach ($emMatches[0] as $em) {
                $pos = $em[1];
                // take up to 3 lines before this position
                $prefix = substr($text, 0, $pos);
                $lines = preg_split('/\r?\n/', trim($prefix));
                for ($i = count($lines)-1; $i >= 0 && $i >= count($lines)-5; $i--) {
                    $cand = trim($lines[$i]);
                    if ($cand === '') continue;
                    // If the line contains both name and role (e.g. 'THOMAS ADRIAN M. NAGUIT BACKEND DEVELOPER'), remove common role tokens
                    $cleanCand = $cand;
                    $roleTokens = ['developer','backend','frontend','engineer','officer','manager','intern','lead','consultant','analyst','designer','administrator','teacher','assistant','coordinator'];
                    // remove trailing role phrases
                    $parts = preg_split('/\s{2,}|\s-\s|\s—\s|\s–\s|,\s*/', $cleanCand);
                    $maybe = $parts[0];
                    // also try trimming trailing role words from single-line candidates
                    $words = preg_split('/\s+/', $maybe);
                    while (count($words) > 1 && in_array(strtolower(end($words)), $roleTokens)) { array_pop($words); }
                    $maybe2 = trim(implode(' ', $words));
                    if ($is_valid_name($maybe2)) return $maybe2;
                    if ($is_valid_name($cand)) return $cand;
                    // sometimes name appears with role on same line, try extracting uppercase portion
                    if (preg_match('/([A-Z][A-Za-z\'\-]+(?:\s+[A-Z][A-Za-z\'\-]+){1,3})/', $cand, $m)) {
                        $c2 = trim($m[1]);
                        if ($is_valid_name($c2)) return $c2;
                    }
                }
            }
        }
    }

    // 3) Scan all lines for name-like candidates, prefer those near the end or centered around contact block
    $lines = preg_split('/\r?\n/', $text);
    // scan bottom-up (names often near top of contact block but sometimes at top; scanning both)
    for ($pass = 0; $pass < 2; $pass++) {
        if ($pass === 0) $range = range(count($lines)-1, 0); else $range = range(0, count($lines)-1);
        foreach ($range as $idx) {
            $line = trim($lines[$idx]);
            if ($line === '' || strlen($line) > 80) continue;
            // skip obvious headings
            $low = strtolower($line);
            $skip = false;
            foreach ($stop_headings as $h) if (strpos($low, $h) !== false) { $skip = true; break; }
            if ($skip) continue;
            // skip lines with colon or '—' that are section lines
            if (preg_match('/[:|\-]{1}/', $line) && !preg_match('/\b[A-Z][a-z]+\b/', $line)) continue;
            if ($is_valid_name($line)) return $line;
            // allow extraction from lines with role beneath name: e.g. 'THOMAS ADRIAN M. NAGUIT BACKEND DEVELOPER' -> extract name portion
            if (preg_match('/([A-Z][A-Za-z\'\-]+(?:\s+[A-Z](?:\.|)\s*)?(?:\s+[A-Z][A-Za-z\'\-]+){1,3})/i', $line, $m)) {
                $cand = trim($m[1]);
                if ($is_valid_name($cand)) return $cand;
            }
        }
    }

    return null;
}

function find_section_blocks($text, $section_patterns) {
    $lc = $text;
    $matches = [];
    foreach ($section_patterns as $name => $pattern) {
        if (preg_match_all($pattern, $lc, $ms, PREG_OFFSET_CAPTURE)) {
            foreach ($ms[0] as $m) {
                $matches[] = ['name'=>$name, 'pos'=>$m[1], 'len'=>strlen($m[0])];
            }
        }
    }
    // sort by position
    usort($matches, function($a,$b){ return $a['pos'] <=> $b['pos']; });
    $out = [];
    for ($i=0;$i<count($matches);$i++) {
        $start = $matches[$i]['pos'] + $matches[$i]['len'];
        $end = isset($matches[$i+1]) ? $matches[$i+1]['pos'] : strlen($lc);
        $block = trim(substr($lc, $start, $end - $start));
        if ($block !== '') $out[$matches[$i]['name']][] = $block;
    }
    return $out;
}

function extract_by_heading($text, $heading_variants) {
    $alts = array_map(function($h){ return preg_quote($h, '/'); }, $heading_variants);
    $pat = '/(^|\\n)\s*(?:' . implode('|', $alts) . ')\s*[:\-\n]/i';
    return $pat;
}

// Define headings to find
$section_map = [
    'work_experience' => ['Work Experience','Professional Experience','Employment History','Experience'],
    'education' => ['Education','Academic Background','Qualifications','Academic Qualifications'],
    'certifications' => ['Certifications','Certificates','Licenses','Licensed'],
    'skills' => ['Skills','Technical Skills','Key Skills'],
];

$heading_patterns = [];
foreach ($section_map as $k => $variants) {
    $heading_patterns[$k] = '/(^|\n)\s*(?:' . implode('|', array_map('preg_quote', $variants)) . ')\s*[:\-\n]/i';
}

// Use heading search to extract blocks
$found_sections = find_section_blocks("\n" . $raw, $heading_patterns);

// Post-process found sections into arrays of lines/entries
$normalize_blocks = function($blocks) {
    $out = [];
    foreach ($blocks as $b) {
        // split on double newlines or lines starting with year/date
        $parts = preg_split('/\n{2,}|(?=\n\s*[0-9]{4}|\n\s*[A-Z][a-z]{2,}\s+[0-9]{4})/', $b);
        foreach ($parts as $p) {
            $p = trim($p);
            if ($p !== '') $out[] = preg_replace('/\s+/', ' ', $p);
        }
    }
    return $out;
};

$work = isset($found_sections['work_experience']) ? $normalize_blocks($found_sections['work_experience']) : [];
$education = isset($found_sections['education']) ? $normalize_blocks($found_sections['education']) : [];
$certs = isset($found_sections['certifications']) ? $normalize_blocks($found_sections['certifications']) : [];
$skills = isset($found_sections['skills']) ? $normalize_blocks($found_sections['skills']) : [];

// --- Improved parsing helpers for structured extraction ---
function parse_date_range_from_text($s) {
    // Try patterns like 'Jan 2018 - Feb 2020', '2018 – Present', '2016 to 2019', '2017-2018'
    $s = trim($s);
    $patterns = [
        '/(?P<start>\b(?:Jan(?:uary)?|Feb(?:ruary)?|Mar(?:ch)?|Apr(?:il)?|May|Jun(?:e)?|Jul(?:y)?|Aug(?:ust)?|Sep(?:t(?:ember)?)?|Oct(?:ober)?|Nov(?:ember)?|Dec(?:ember)?)[\.\s-]*\d{4})\s*(?:-|–|—|to|until|until)\s*(?P<end>Present|present|\b(?:Jan(?:uary)?|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[\.\s-]*\d{4})/i',
        '/(?P<start>\b\d{4})\s*(?:-|–|—|to|until)\s*(?P<end>Present|present|\d{4})/i',
        '/(?P<start>\b(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\.?\s+\d{4})/i'
    ];
    foreach ($patterns as $pat) {
        if (preg_match($pat, $s, $m)) {
            return [ 'start' => $m['start'] ?? null, 'end' => $m['end'] ?? null ];
        }
    }
    return null;
}

function split_title_company($line) {
    // common separators
    $seps = [' at ', ' @ ', ' - ', ' – ', ' — ', '|'];
    foreach ($seps as $sep) {
        if (stripos($line, $sep) !== false) {
            $parts = preg_split('/' . preg_quote($sep, '/') . '/i', $line, 2);
            if (count($parts) === 2) return [trim($parts[0]), trim($parts[1])];
        }
    }
    // fallback: if comma counts and first part short, treat as title, company
    $parts = explode(',', $line, 3);
    if (count($parts) >= 2) {
        if (strlen(trim($parts[0])) < 60) return [trim($parts[0]), trim($parts[1])];
    }
    return [trim($line), ''];
}

function parse_work_experience_blocks($blocks) {
    $out = [];
    $count = count($blocks);
    for ($i = 0; $i < $count; $i++) {
        $blk = $blocks[$i];
        $lines = preg_split('/\r?\n/', $blk);
        // collect non-empty trimmed lines
        $clean = [];
        foreach ($lines as $ln) { $t = trim($ln); if ($t !== '') $clean[] = $t; }
        if (empty($clean)) continue;

        $firstLine = $clean[0];

        // Heuristics to detect continuation-only blocks
        $containsDate = (bool) parse_date_range_from_text($firstLine);
        $hasTitleCompanySep = (stripos($firstLine, ' at ') !== false || stripos($firstLine, ' @ ') !== false || stripos($firstLine, ' - ') !== false || stripos($firstLine, ' – ') !== false || stripos($firstLine, ',') !== false);
        $startsWithBullet = preg_match('/^[\*\+\-•\u2022\.]/u', $firstLine);
        $startsLower = preg_match('/^[a-z]/', $firstLine);

        $isContinuation = false;
        if ($startsWithBullet) $isContinuation = true;
        elseif (!$containsDate && !$hasTitleCompanySep && ($startsLower || mb_strlen($firstLine) < 80)) $isContinuation = true;

        // Aggressive: if block is very short (1 line) and next block looks like continuation/description, merge now
        if (!$isContinuation && count($clean) === 1 && ($i + 1) < $count) {
            // peek next block
            $nextLines = preg_split('/\r?\n/', $blocks[$i+1]);
            $nextFirst = null;
            foreach ($nextLines as $nl) { $t = trim($nl); if ($t !== '') { $nextFirst = $t; break; } }
            if ($nextFirst !== null) {
                $nextContainsDate = (bool) parse_date_range_from_text($nextFirst);
                $nextStartsWithBullet = preg_match('/^[\*\+\-•\u2022\.]/u', $nextFirst);
                // company-like heuristics: presence of 'Inc|Ltd|Co|Corporation|LLC|Company' or many TitleCase words
                $company_like = preg_match('/\b(Inc|Ltd|Co|Corporation|LLC|Company|Limited|Corporation|S\.A\.|Pty)\b/i', $nextFirst);
                $titlecase_words = preg_match('/^(?:[A-Z][a-z]{2,}\s*){1,4}$/', $nextFirst);
                if (!$nextContainsDate && ($nextStartsWithBullet || $company_like || $titlecase_words || mb_strlen($nextFirst) < 60)) {
                    // merge current and next block into one and advance index
                    $blk = $blk . "\n" . $blocks[$i+1];
                    $clean[] = $nextFirst;
                    $i++; // skip next as it's merged
                }
            }
        }

        // If this block is a continuation and we have a previous entry, append
        if ($isContinuation && !empty($out)) {
            $appendParts = $clean;
            $toAdd = implode("\n", $appendParts);
            if ($toAdd !== '') {
                if (!empty($out[count($out)-1]['description'])) $out[count($out)-1]['description'] .= "\n" . $toAdd;
                else $out[count($out)-1]['description'] = $toAdd;
                // also append raw
                $out[count($out)-1]['raw'] .= "\n" . $blk;
            }
            continue;
        }

        // Parse this (possibly merged) block as a new work entry
        // find header line index among clean lines
        $headerIdx = 0; // choose first non-empty by default
        $header = $clean[$headerIdx];
        // try to find a date line adjacent to header
        $dateRange = parse_date_range_from_text($header);
        if (!$dateRange && isset($clean[$headerIdx+1])) $dateRange = parse_date_range_from_text($clean[$headerIdx+1]);
        $start = $dateRange['start'] ?? null; $end = $dateRange['end'] ?? null;
        $hdrNoDate = $header;
        if ($dateRange) {
            if (!empty($dateRange['start'])) $hdrNoDate = preg_replace('/' . preg_quote($dateRange['start'], '/') . '/i', '', $hdrNoDate);
            if (!empty($dateRange['end'])) $hdrNoDate = str_ireplace($dateRange['end'], '', $hdrNoDate);
            $hdrNoDate = trim($hdrNoDate);
        }
        list($title, $company) = split_title_company($hdrNoDate ?: $header);

        // collect description from remaining clean lines (skip date-only lines)
        $descParts = [];
        for ($j = $headerIdx+1; $j < count($clean); $j++) {
            $tln = $clean[$j];
            if (parse_date_range_from_text($tln)) continue;
            $descParts[] = $tln;
        }

        $description = $descParts ? implode("\n", $descParts) : null;

        // Normalize description: if lines are not predominantly bullets, join into single paragraph
        if ($description) {
            $linesDesc = preg_split('/\r?\n/', $description);
            $bulletCount = 0; $total = 0; $trimmed = [];
            foreach ($linesDesc as $ld) { $t = trim($ld); if ($t==='') continue; $total++; if (preg_match('/^[\*\+\-•\u2022\.]/u', $t)) $bulletCount++; $trimmed[] = $t; }
            if ($total > 0 && $bulletCount / $total < 0.5) {
                // join with space to make a single flowing description
                $description = implode(' ', $trimmed);
            } else {
                // keep bullets/lines but normalize spacing
                $description = implode("\n", $trimmed);
            }
        }

        $entry = ['title' => $title ?: null, 'company' => $company ?: null, 'start' => $start, 'end' => $end, 'description' => $description, 'raw' => $blk];
        $out[] = $entry;
    }
    // Post-process: merge adjacent entries that likely belong together
    $merged = [];
    $n = count($out);
    for ($k = 0; $k < $n; $k++) {
        $cur = $out[$k];
        // look ahead to next
        if ($k + 1 < $n) {
            $next = $out[$k+1];
            $shouldMerge = false;
            // If next has no title and no company -> continuation
            if ((empty($next['title']) || trim($next['title']) === '') && (empty($next['company']) || trim($next['company']) === '')) $shouldMerge = true;
            // If current has no company but next has company -> likely header split
            if ((empty($cur['company']) || trim($cur['company']) === '') && !empty($next['company'])) $shouldMerge = true;
            // If both have descriptions and combined length is small, merge
            $lenA = isset($cur['description']) ? mb_strlen($cur['description']) : 0;
            $lenB = isset($next['description']) ? mb_strlen($next['description']) : 0;
            if ($lenA > 0 && $lenB > 0 && ($lenA + $lenB) < 240) $shouldMerge = true;

            if ($shouldMerge) {
                // merge next into current
                $aDesc = $cur['description'] ?? '';
                $bDesc = $next['description'] ?? $next['raw'] ?? '';
                $combined = trim($aDesc === '' ? $bDesc : ($aDesc . "\n" . $bDesc));
                $cur['description'] = $combined ?: null;
                $cur['raw'] = trim(($cur['raw'] ?? '') . "\n" . ($next['raw'] ?? ''));
                // consume next by skipping increment of k (advance extra)
                $k++;
            }
        }
        $merged[] = $cur;
    }

    return array_values($merged);
}

// Normalize many human date formats into ISO-ish YYYY-MM-DD where possible
function normalize_date_string($s) {
    if (!$s) return null;
    $s = trim($s);
    // common patterns: Jan 2018, Jan 1, 2018, 2018
    if (preg_match('/(\d{4})/', $s, $m) && preg_match('/^\s*\d{4}\s*$/', $s)) return $m[1] . '-01-01';
    // try strtotime fallback
    $ts = strtotime($s);
    if ($ts !== false) return date('Y-m-d', $ts);
    return null;
}

function extract_year_month_components($s) {
    // Returns ['year'=>YYYY|null, 'month'=>MM|null, 'iso'=>YYYY-MM-DD|null]
    $out = ['year' => null, 'month' => null, 'iso' => null];
    if (!$s) return $out;
    $s = trim($s);
    // common month names
    if (preg_match('/\b(Jan(?:uary)?|Feb(?:ruary)?|Mar(?:ch)?|Apr(?:il)?|May|Jun(?:e)?|Jul(?:y)?|Aug(?:ust)?|Sep(?:t(?:ember)?)?|Oct(?:ober)?|Nov(?:ember)?|Dec(?:ember)?)\b\s*(\d{4})/i', $s, $m)) {
        $monthName = $m[1]; $year = $m[2];
        $dt = strtotime($monthName . ' 1 ' . $year);
        if ($dt !== false) {
            $out['year'] = date('Y', $dt);
            $out['month'] = date('m', $dt);
            $out['iso'] = date('Y-m-d', $dt);
            return $out;
        }
    }
    // month name with month abbrev and year e.g. 'Mar 2019'
    if (preg_match('/\b([A-Za-z]{3,9})\.?(?:\s+)?(\d{4})\b/', $s, $m)) {
        $dt = strtotime($m[1] . ' 1 ' . $m[2]);
        if ($dt !== false) { $out['year'] = date('Y', $dt); $out['month'] = date('m', $dt); $out['iso'] = date('Y-m-d', $dt); return $out; }
    }
    // plain year or year ranges: capture first year
    if (preg_match('/(19|20)\d{2}/', $s, $m2)) {
        $out['year'] = $m2[0]; $out['iso'] = $out['year'] . '-01-01';
        return $out;
    }
    // try strtotime as fallback
    $ts = strtotime($s);
    if ($ts !== false) { $out['year'] = date('Y', $ts); $out['month'] = date('m', $ts); $out['iso'] = date('Y-m-d', $ts); }
    return $out;
}

function extract_dob($text) {
    if (!$text) return null;
    // look for labels: Date of birth, DOB, Birthdate, Born
    if (preg_match('/\b(Date of Birth|DOB|Birthdate|Born)[:\s\-]*([A-Za-z0-9,\/\-\.\s]+)\b/i', $text, $m)) {
        $cand = trim($m[2]);
        $iso = normalize_date_string($cand);
        return $iso ?: $cand;
    }
    // fallback: any isolated date-looking token near the top of the document
    if (preg_match('/\b(\d{1,2}[\/-]\d{1,2}[\/-]\d{2,4}|[A-Za-z]{3,9}\s+\d{1,2},?\s+\d{4})\b/', $text, $m)) {
        $iso = normalize_date_string($m[1]);
        return $iso ?: $m[1];
    }
    return null;
}

function extract_summary($text) {
    // Return the leading paragraph before the first recognized section heading
    $text = trim($text);
    if ($text === '') return null;
    $headings = ['experience','education','skills','certifications','certificates','work experience','professional experience','employment history','summary','objective','profile'];
    $parts = preg_split('/\r?\n{2,}/', $text, 4);
    foreach ($parts as $p) {
        $low = strtolower($p);
        $isHeading = false;
        foreach ($headings as $h) if (strpos($low, $h) !== false) { $isHeading = true; break; }
        if (!$isHeading && strlen(trim($p)) > 30) return preg_replace('/\s+/', ' ', trim($p));
    }
    return null;
}

function extract_education_entries($blocks) {
    $out = [];
    foreach ($blocks as $b) {
        $lines = preg_split('/\r?\n/', trim($b));
        $header = trim($lines[0] ?? '');
        // degrees and years
        $degree = null; $school = null; $year = null;
        if (preg_match('/\b(Bachelor|B\.|BSc|BA|BS|Master|M\.|MSc|MBA|Associate|Diploma|High School|Secondary|PhD|Doctor)\b/i', $header, $m)) {
            $degree = trim($header);
        }
        // try capture year
        if (preg_match('/(19|20)\d{2}/', $b, $m2)) $year = $m2[0];
        // attempt to split by comma: school usually after comma
        $parts = preg_split('/,\s*/', $header, 2);
        if (count($parts) === 2) { $school = trim($parts[1]); if (!$degree) $degree = trim($parts[0]); }
        if (!$school && isset($lines[1])) $school = trim($lines[1]);
        $out[] = ['degree' => $degree ?: null, 'school' => $school ?: null, 'year' => $year ?: null, 'raw' => $b];
    }
    return $out;
}

function extract_skills($skillBlocks, $fullText) {
    $out = [];
    // first, use explicit skills blocks
    foreach ($skillBlocks as $b) {
        $candidates = preg_split('/[,;\/\|\n]+/', $b);
        foreach ($candidates as $c) { $t = trim($c); if ($t) $out[] = $t; }
    }
    // also search for 'Skills:' inline
    if (preg_match('/Skills?\s*[:\-]\s*([A-Za-z0-9\,\/\-\+\.# ]{10,})/i', $fullText, $m)) {
        $candidates = preg_split('/[,;\/\|]+/', $m[1]);
        foreach ($candidates as $c) { $t = trim($c); if ($t) $out[] = $t; }
    }
    // dedupe and normalize
    $out = array_values(array_unique(array_map(function($s){ return preg_replace('/\s+/', ' ', trim($s)); }, $out)));
    return $out;
}

function extract_languages($text) {
    $out = [];
    if (preg_match('/Languages?\s*[:\-]\s*([A-Za-z0-9,\/\s]+)$/mi', $text, $m)) {
        $cand = preg_split('/[,;\/\|]+/', $m[1]);
        foreach ($cand as $c) { $t = trim($c); if ($t) $out[] = $t; }
    } else {
        // look for single-line mentions e.g. 'English (fluent)'
        preg_match_all('/\b(English|Filipino|Tagalog|Cebuano|Spanish|Chinese|Mandarin|Japanese|Korean|French|German)\b/i', $text, $m2);
        foreach (($m2[0] ?? []) as $l) $out[] = trim($l);
    }
    return array_values(array_unique($out));
}

function parse_certifications_blocks($blocks) {
    $out = [];
    foreach ($blocks as $blk) {
        $lines = preg_split('/[\r\n]+|\u2022|•|\-\s+/', $blk);
        foreach ($lines as $ln) {
            $ln = trim($ln);
            if ($ln === '') continue;
            // look for keywords
            if (preg_match('/\b(certif|certificate|certified|license|licensed|licen)\b/i', $ln)) {
                // clean common bullets and dates
                $ln2 = preg_replace('/\s{2,}/', ' ', preg_replace('/\(.*?\)/', '', $ln));
                $out[] = trim($ln2);
            }
        }
    }
    // also try to pick up one-line certifications from the whole text if none found
    if (empty($out)) {
        // look for lines that include 'Certified' or 'Certificate' anywhere
        preg_match_all('/^.*\b(Certificate|Certified|Licensed|License|Diploma)\b.*$/mi', implode("\n", $blocks), $m);
        foreach (($m[0] ?? []) as $ln) { $ln = trim($ln); if ($ln) $out[] = $ln; }
    }
    return array_values(array_unique($out));
}

// Convert work/education/certs candidates into richer structures
$work_structured = parse_work_experience_blocks($work);
$certs_structured = parse_certifications_blocks($certs);

// Normalize start/end dates into year/month/iso for work entries
foreach ($work_structured as $i => $w) {
    $startComp = extract_year_month_components($w['start'] ?? null);
    $endComp = extract_year_month_components($w['end'] ?? null);
    $work_structured[$i]['start_year'] = $startComp['year'];
    $work_structured[$i]['start_month'] = $startComp['month'];
    $work_structured[$i]['start_iso'] = $startComp['iso'];
    $work_structured[$i]['end_year'] = $endComp['year'];
    $work_structured[$i]['end_month'] = $endComp['month'];
    $work_structured[$i]['end_iso'] = $endComp['iso'];
}

// Normalize education structured years
$education_structured = isset($education_structured) ? $education_structured : [];
foreach ($education_structured as $i => $e) {
    // some education entries may include a year range in raw or degree
    $yearFound = null;
    if (!empty($e['year'])) $yearFound = $e['year'];
    else if (preg_match('/(19|20)\d{2}\s*(?:[\-–]\s*(?:19|20)\d{2})?/', $e['raw'] ?? '', $m)) $yearFound = $m[0];
    if ($yearFound) {
        if (preg_match('/(19|20)\d{2}/', $yearFound, $m2)) {
            $education_structured[$i]['year_completed'] = $m2[0];
        }
        if (preg_match('/(19|20)\d{2}\s*[\-–]\s*(19|20)\d{2}/', $yearFound, $mm)) {
            $education_structured[$i]['year_started'] = $mm[1];
            $education_structured[$i]['year_completed'] = $mm[2];
        }
    }
}

// Fallback heuristics if sections not found
if (empty($work)) {
    // try to extract lines containing year ranges
    preg_match_all('/^.*?(?:19|20)\d{2}[^\n]*$/m', $raw, $m);
    foreach (($m[0] ?? []) as $ln) { $ln = trim($ln); if ($ln) $work[] = $ln; }
}
if (empty($education)) {
    preg_match_all('/^.*\b(Bachelor|B\.Sc|BSc|BA|Master|MSc|Diploma|High School|Secondary)\b.*$/mi', $raw, $m);
    foreach (($m[0] ?? []) as $ln) { $ln = trim($ln); if ($ln) $education[] = $ln; }
}
if (empty($certs)) {
    preg_match_all('/^.*\b(Certif|Certificate|Certified|Licen)\b.*$/mi', $raw, $m);
    foreach (($m[0] ?? []) as $ln) { $ln = trim($ln); if ($ln) $certs[] = $ln; }
}
if (empty($skills)) {
    // look for comma-lists of short tokens
    if (preg_match('/Skills\s*[:\-]\s*([A-Za-z0-9,\/\s\-\+\.#]+)/i', $raw, $m)) {
        $s = preg_split('/[,;\/\\|]/', $m[1]);
        foreach ($s as $t) { $t = trim($t); if ($t) $skills[] = $t; }
    }
}

$emails = extract_emails($raw);
$phones = extract_phones($raw);
$name = extract_name_candidate($raw);

// Additional top-level extractions
$dob = extract_dob($raw);
$summary = extract_summary($raw);

// education structured entries and improved skills/languages
$education_structured = extract_education_entries($education);
$skills_list = extract_skills($skills, $raw);
$languages = extract_languages($raw);

// --- Address extraction heuristics ---
function extract_address_candidate($text) {
    $lines = preg_split('/\r?\n/', $text);
    $candidates = [];
    // keywords commonly found in Filipino addresses
    $addrKeywords = ['brgy','barangay','street','st.','road','rd.','blk','lot','purok','zone','city','municipality','province','poblacion'];

    // collect lines containing any keyword
    foreach ($lines as $i => $ln) {
        $s = trim($ln);
        if ($s === '') continue;
        foreach ($addrKeywords as $kw) {
            if (stripos($s, $kw) !== false) { $candidates[] = ['line'=>$s,'idx'=>$i]; break; }
        }
    }

    // If found candidates, prefer the longest (more detailed) or the one nearest to contact block
    if (count($candidates)) {
        usort($candidates, function($a,$b){ return strlen($b['line']) <=> strlen($a['line']); });
        return $candidates[0]['line'];
    }

    // fallback: look for a line above an email or phone occurrence
    foreach ($lines as $i => $ln) {
        if (preg_match('/[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}/', $ln) || preg_match('/\d{7,}/', preg_replace('/\D/', '', $ln))) {
            // check up to 3 lines above
            for ($k = 1; $k <= 3; $k++) {
                if (!isset($lines[$i-$k])) break;
                $cand = trim($lines[$i-$k]);
                if ($cand !== '' && strlen($cand) > 6) return $cand;
            }
        }
    }

    // last resort: look for a line with a number followed by street-like tokens
    foreach ($lines as $ln) {
        if (preg_match('/\b\d{1,4}\b.*\b(street|st\.|road|rd\.|blk|lot|brgy|barangay)\b/i', $ln)) return trim($ln);
    }

    return null;
}

$addressCandidate = extract_address_candidate($raw);

// Build structured payload
$structured = [
    'name' => $name,
    'date_of_birth' => $dob,
    'emails' => $emails,
    'phones' => $phones,
    'address' => $addressCandidate,
    // provide both raw arrays and structured parsed arrays
    'work_experience' => array_values(array_unique($work)),
    'work_experience_structured' => $work_structured,
    'education' => array_values(array_unique($education)),
    'education_structured' => $education_structured,
    'certifications' => array_values(array_unique($certs)),
    'certifications_structured' => $certs_structured,
    'skills' => $skills_list,
    'languages' => $languages,
    'summary' => $summary,
    'raw_text' => $raw,
    'pages' => $perPage,
];

// Add presence flags so client can hide empty sections
$structured['has_work_experience'] = !empty($structured['work_experience_structured']) || !empty($structured['work_experience']);
$structured['has_certifications'] = !empty($structured['certifications_structured']) || !empty($structured['certifications']);
// additional presence flags
$structured['has_education'] = !empty($structured['education_structured']) || !empty($structured['education']);
$structured['has_skills'] = !empty($structured['skills']);
$structured['has_languages'] = !empty($structured['languages']);

// Persist extracted JSON to storage/app/resumes
$projRoot = dirname(__DIR__); // public/db -> public -> project root
$resumesDir = $projRoot . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'resumes';
if (!is_dir($resumesDir)) @mkdir($resumesDir, 0755, true);

$uploadId = bin2hex(random_bytes(8));
$userId = null;
// Allow optional user_id via POST field or query param
if (!empty($_POST['user_id'])) $userId = preg_replace('/[^A-Za-z0-9_\-]/', '', $_POST['user_id']);
elseif (!empty($_GET['user_id'])) $userId = preg_replace('/[^A-Za-z0-9_\-]/', '', $_GET['user_id']);

$saved = false;
$uploadFilename = $resumesDir . DIRECTORY_SEPARATOR . 'upload_' . $uploadId . '.json';
file_put_contents($uploadFilename, json_encode(array_merge(['upload_id'=>$uploadId,'user_id'=>$userId,'created_at'=>date('c')], $structured), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
$saved = file_exists($uploadFilename);

// If user id provided, also maintain user_{id}.json index mapping to uploads
if ($userId) {
    $userFile = $resumesDir . DIRECTORY_SEPARATOR . 'user_' . $userId . '.json';
    $index = [];
    if (file_exists($userFile)) {
        $rawIdx = @file_get_contents($userFile);
        $idx = json_decode($rawIdx, true);
        if (is_array($idx)) $index = $idx;
    }
    $index[$uploadId] = ['file' => basename($uploadFilename), 'created_at' => date('c')];
    file_put_contents($userFile, json_encode($index, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
}

$response = ['success' => true, 'message' => 'OCR completed', 'upload_id' => $uploadId, 'saved' => $saved, 'saved_path' => $saved ? ('storage/app/resumes/' . basename($uploadFilename)) : null, 'data' => $structured];
echo json_encode($response, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
exit;

?>