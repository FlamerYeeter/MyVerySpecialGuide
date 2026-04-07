<?php

error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);

// ================================
// CONFIG
// ================================

define('MAX_BASE64', 10_000_000); // ~10MB

header("Content-Type: application/json");

// ================================
// FUNCTIONS
// ================================

function buildOcrPrompt($fields, $imagePaths, $ocrtype)
{
    $jsonFormat = "{\n";
    foreach ($fields as $key => $value) {
        $jsonFormat .= "  \"$key\": \"$value\",\n";
    }
    $jsonFormat = rtrim($jsonFormat, ",\n") . "\n}";

    $fieldList = "- " . implode("\n- ", array_keys($fields));

    $imageBlock = "";
    foreach ($imagePaths as $i => $path) {
        $label = count($imagePaths) > 1 ? "Image " . ($i+1) : "Main image";
        $imageBlock .= "IMAGE $label: $path\n";
    }

    $extraHint = "";
    if ($ocrtype === 'pwd_id') {
        $extraHint = "This is usually a Philippine PWD ID card — often has front and back sides. if this is not PWD ID then return error else if it contains PWD ID then its good. \n";
    } elseif ($ocrtype === 'medical_certificate') {
        $extraHint = "This is a medical certificate — look for patient name, date, diagnosis, doctor. if this is not Medical Certificate then return error else if it contains Medical Certificate then its good. \n";
    } elseif ($ocrtype === 'membership_proof') {
        $extraHint = "This is a proof of membership document — look for organization Proof of membership in the Down Syndrome Association of the Philippines, Inc. (DSAPI). if this is not Proof of Membership then return error else if it contains Medical Certificate then its good. \n";   
    } elseif ($ocrtype === 'certificate_proof') {
        $extraHint = "This is a certificate proof of training — look for organization name, date, and participant details. if this is not Certificate of Training then return error else if it contains Certificate of Training then its good. \n";   
    } elseif ($ocrtype === 'fit_to_work') {
        $extraHint = "This is a Fit-To-Work certificate — look specifically for explicit statements like 'fit to work', 'cleared for work', 'medically fit', and the examining doctor's name. If such statements are not present, return parsed fields but set contains_fit_to_work=false.\n";
    }          

    return <<<PROMPT
You are an expert at reading Philippine identity documents and medical certificates from images.

TASK:
Read all the provided images carefully.
Extract the requested fields.
Return **only** valid JSON — no other text, no markdown, no explanations.

FIELDS TO EXTRACT:
$fieldList

EXPECTED JSON FORMAT (example):
$jsonFormat

IMAGES:
$imageBlock

$extraHint
- Be careful with handwriting and low-quality prints
- Fix obvious OCR-like mistakes (Januarg → January, etc.)
- Convert dates to YYYY-MM-DD when possible
- Keep addresses complete and natural 

Return only the JSON object.
PROMPT;
}

function callOCR($model, $prompt, $images = [])
{
    $url = "http://localhost:11434/api/generate";

    $payload = [
        "model"    => $model,
        "prompt"   => $prompt,
        "stream"   => false,
    ];

    // If model supports images → send them
    if (!empty($images)) {
        $payload["images"] = [];
        foreach ($images as $path) {
            $payload["images"][] = base64_encode(file_get_contents($path));
        }
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 180);

    $response = curl_exec($ch);
    if (curl_errno($ch)) return null;
    curl_close($ch);

    return json_decode($response, true);
}

function response($status, $msg, $data = [])
{
    http_response_code($status ? 200 : 400);
    echo json_encode(['status' => $status, 'message' => $msg, 'data' => $data], JSON_PRETTY_PRINT);
    exit;
}

function cleanup($files)
{
    foreach ($files as $f) if (file_exists($f)) @unlink($f);
}

// ================================
// 1. READ & VALIDATE JSON
// ================================

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (!$data) response(false, 'Invalid JSON');

$ocrtype = $data['type'] ?? null;

// ================================
// 2. HANDLE BASE64 INPUT
// ================================

if (!in_array($ocrtype, ['certificate_proof', 'membership_proof', 'pwd_id', 'medical_certificate', 'fit_to_work'])) {
    response(false, "Invalid OCR type");
}

$base64_data = $data['ocr_data'] ?? null;
if (!$base64_data) response(false, "No file data provided");

$tmpDir = getenv('TEMP') ?: getenv('TMP');
if (!$tmpDir) $tmpDir = sys_get_temp_dir();

$images = []; // will hold one or more image file paths (after PDF conversion)
$tmpFilesCreated = [];

// Helper to create temp file from base64 string and detect extension
function createTempFromBase64($raw, $tmpDir, &$tmpFilesCreated) {
    if (strpos($raw, ',') !== false) $parts = explode(',', $raw, 2); else $parts = [null, $raw];
    $prefix = $parts[0] ?? null; $b64 = $parts[1] ?? $parts[0];
    $fileData = base64_decode($b64);
    if (!$fileData) return [null, null];
    if (strlen($b64) > MAX_BASE64) return [null, null];

    $ext = null;
    if ($prefix !== null) {
        if (str_starts_with($prefix, 'data:image/jpeg')) $ext = '.jpg';
        elseif (str_starts_with($prefix, 'data:image/png')) $ext = '.png';
        elseif (str_starts_with($prefix, 'data:application/pdf')) $ext = '.pdf';
    }
    if (!$ext) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_buffer($finfo, $fileData);
        finfo_close($finfo);
        $extMap = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'application/pdf' => '.pdf'];
        $ext = $extMap[$mime] ?? null;
    }
    if (!$ext) return [null, null];

    $tmp = tempnam($tmpDir, 'ocr_');
    $tmpFile = $tmp . $ext;
    rename($tmp, $tmpFile);
    file_put_contents($tmpFile, $fileData);
    $tmpFilesCreated[] = $tmpFile;
    return [$tmpFile, $ext];
}

if (is_array($base64_data)) {
    foreach ($base64_data as $raw) {
        list($tmpFile, $ext) = createTempFromBase64($raw, $tmpDir, $tmpFilesCreated);
        if (!$tmpFile) continue;
        // PDF conversion
        if ($ext === '.pdf') {
            $out = $tmpFile . '_img';
            shell_exec("pdftoppm -png " . escapeshellarg($tmpFile) . " " . escapeshellarg($out));
            $page = 1;
            while (file_exists($out . "-$page.png")) {
                $images[] = $out . "-$page.png";
                $page++;
            }
            if (empty($images)) {
                cleanup(array_merge($tmpFilesCreated));
                response(false, "PDF conversion failed");
            }
        } else {
            $images[] = $tmpFile;
        }
    }
    if (empty($images)) response(false, "No valid images in payload");
} else {
    list($tmpFile, $ext) = createTempFromBase64($base64_data, $tmpDir, $tmpFilesCreated);
    if (!$tmpFile) response(false, "Invalid Base64 file");
    // PDF conversion for single file
    if ($ext === '.pdf') {
        $out = $tmpFile . '_img';
        shell_exec("pdftoppm -png " . escapeshellarg($tmpFile) . " " . escapeshellarg($out));
        $page = 1;
        while (file_exists($out . "-$page.png")) {
            $images[] = $out . "-$page.png";
            $page++;
        }
        if (empty($images)) {
            cleanup(array_merge([$tmpFile]));
            response(false, "PDF conversion failed");
        }
    } else {
        $images[] = $tmpFile;
    }
}

// ================================
// 6. IMAGE PREPROCESSING (recommended even for vision models)
// ================================

$cleanImages = [];
foreach ($images as $img) {
    $clean = $tmpFile . pathinfo($img, PATHINFO_FILENAME) . "_clean.png";

    $cmd = "magick " . escapeshellarg($img)
         . " -resize 200%"
         . " -colorspace Gray"
         . " -sharpen 0x1"
         . " -contrast-stretch 0 "
         . escapeshellarg($clean);

    shell_exec($cmd);

    if (!file_exists($clean)) {
        cleanup(array_merge([$tmpFile], $images));
        response(false, "Image preprocessing failed");
    }

    $cleanImages[] = $img;
}

// ================================
// 7. BUILD PROMPT
// ================================

// Common useful fields we want when autofilling forms
$common = [
    "first_name"   => "Given / First name",
    "last_name"    => "Family / Last name",
    "name"         => "Full name (if first/last not separable)",
    "date_of_birth"=> "YYYY-MM-DD",
    "address"      => "Full mailing/address text",
    "phone"        => "Phone or mobile number",
    "email"        => "Email address",
];

if ($ocrtype === 'pwd_id') {
    // PWD ID: prefer name, dob, address, id number, disability
    $fields = array_merge($common, [
        "id_number" => "ID / card number",
        "type_of_disability" => "Type of disability (if present)"
    ]);
    } elseif ($ocrtype === 'medical_certificate') {
    // Medical certificate: patient name/date, optionally dob and doctor
    $fields = array_merge($common, [
        "date" => "Exam/issue date (YYYY-MM-DD)",
        "doctor" => "Doctor or physician name",
        "diagnosis" => "Diagnosis/notes"
    ]);
} elseif ($ocrtype === 'fit_to_work') {
    // Fit-To-Work certificate: focus on fit statements, doctor, and any fit-specific phrasing
    $fields = array_merge($common, [
        "date" => "Exam/issue date (YYYY-MM-DD)",
        "doctor" => "Doctor or physician name",
        "fit_statement" => "Explicit statement indicating fitness to work (e.g. 'fit to work', 'cleared for work', etc.)",
        "notes" => "Any additional notes or restrictions"
    ]);
} elseif ($ocrtype === 'membership_proof') {
    $fields = array_merge($common, [
        "is_membership" => "true or false",
        "member_name" => "Member name on the proof (if any)",
        "membership_id" => "Membership number (if any)"
    ]);
} elseif ($ocrtype === 'certificate_proof') {
    $fields = array_merge($common, [
        "cert_name" => "Name of the Certificate",
        "issued_by" => "Issuing Organization",
        "date_completed" => "YYYY-MM-DD"
    ]);
} else {
    $fields = array_merge($common, ["summary" => "short summary of document content"]);
}

$prompt = buildOcrPrompt($fields, $cleanImages, $ocrtype);

$model = implode('', [
    chr(109), chr(105), chr(110), chr(105), chr(115), chr(116), chr(114),
    chr(97), chr(108), chr(45), chr(51), chr(58), chr(49), chr(52), chr(98),
    chr(45), chr(99), chr(108), chr(111), chr(117), chr(100)
]);

$model = base64_decode('bWluaXN0cmFsLTM6MTRiLWNsb3Vk');

// Call OCR per image so we can detect which side (front/back) contains the disability
$per_image_results = [];
foreach ($cleanImages as $imgPath) {
    $singleResp = callOCR($model, $prompt, [$imgPath]);
    if (!$singleResp || empty($singleResp['response'])) {
        // keep going; record null for this image
        $per_image_results[basename($imgPath)] = ['ok' => false, 'raw' => null, 'parsed' => null];
        continue;
    }
    $rawText = trim($singleResp['response']);
    $rawText = preg_replace('/```json\s*|\s*```/', '', $rawText);
    $rawText = preg_replace('/<think>.*?<\/think>/s', '', $rawText);
    preg_match('/\{.*\}/s', $rawText, $m);
    if (empty($m)) {
        $per_image_results[basename($imgPath)] = ['ok' => false, 'raw' => $rawText, 'parsed' => null];
        continue;
    }
    $jsonOnly = $m[0];
    $parsedSingle = json_decode($jsonOnly, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $per_image_results[basename($imgPath)] = ['ok' => false, 'raw' => $jsonOnly, 'parsed' => null, 'json_error' => json_last_error_msg()];
        continue;
    }
    $per_image_results[basename($imgPath)] = ['ok' => true, 'raw' => $rawText, 'parsed' => $parsedSingle];
}

// Ensure we at least have one successful parse
$anyOk = false;
foreach ($per_image_results as $r) { if (!empty($r['ok'])) { $anyOk = true; break; } }
if (!$anyOk) {
    // If the client provided a previously-detected disability (from the other side),
    // accept the request and use that provided detection.
    $previous_disability = $data['previous_disability'] ?? null;
    $previous_disability_source = $data['previous_disability_source'] ?? null;
    if (!empty($previous_disability)) {
        // allow processing to continue and use the provided previous detection
        $parsed = [];
        $detected_disability = $previous_disability;
        $disability_source = $previous_disability_source ?? 'previous';
        $used_previous = true;
    } else {
        // No strict JSON parsed. Rather than rejecting, continue with empty parsed
        // results and return available raw texts so the frontend can still autofill
        // using fallback heuristics. Treat disability as optional/bonus.
        $parsed = [];
        $detected_disability = null;
        $disability_source = null;
        $used_previous = false;
        // keep per_image_results populated for debugging and fallback extraction on client
    }
}

// Merge per-image parsed results into a combined parsed object (prefer first non-empty values)
$parsed = [];
$detected_disability = null;
$disability_source = null;
foreach ($per_image_results as $img => $info) {
    if (empty($info['ok']) || empty($info['parsed']) || !is_array($info['parsed'])) continue;
    foreach ($info['parsed'] as $k => $v) {
        if (!isset($parsed[$k]) || $parsed[$k] === null || $parsed[$k] === '') {
            $parsed[$k] = $v;
        }
    }
    // check disability field presence (common keys)
    $typeKeys = ['type_of_disability','disability','diagnosis'];
    foreach ($typeKeys as $tk) {
        if ($detected_disability === null && !empty($info['parsed'][$tk])) {
            $detected_disability = $info['parsed'][$tk];
            $disability_source = $img; // basename of image that provided the info
            break;
        }
    }
}

// If we didn't find a disability in any parsed image, allow the client to supply
// a previously-detected disability (useful when the front side was already
// processed and the user is now uploading only the back side).
if ($detected_disability === null) {
    $previous_disability = $data['previous_disability'] ?? null;
    $previous_disability_source = $data['previous_disability_source'] ?? null;
    if (!empty($previous_disability)) {
        $detected_disability = $previous_disability;
        $disability_source = $previous_disability_source ?? 'previous';
        $used_previous = true;
    } else {
        $used_previous = false;
    }
} else {
    $used_previous = false;
}

// ================================
// 9. FINAL RESULT
// ================================

// Detect presence of 'fit to work' or semantically similar phrases in the combined parsed result.
$containsFit = false;
try {
    // Build a searchable string combining all per-image raw text and parsed values
    $searchParts = [];
    foreach ($per_image_results as $info) {
        if (!empty($info['raw'])) $searchParts[] = $info['raw'];
        if (!empty($info['parsed'])) $searchParts[] = json_encode($info['parsed']);
    }
    $searchText = strtolower(implode(" \n ", $searchParts));

    // Positive indicators (case-insensitive and flexible)
    $positivePatterns = [
        '/fit to work/i',
        '/fit for work/i',
        '/fit to return to work/i',
        '/fit to resume work/i',
        '/medically fit/i',
        '/fit for duty/i',
        '/cleared to work/i',
        '/cleared to return to work/i',
        '/able to work/i',
        '/\bfit\b.*\bwork\b/i',
        '/\bwork\b.*\bfit\b/i',
        '/cleared for work/i',
        '/suitable to work/i',
    ];

    // Negative indicators — look for explicit negations
    $negativePatterns = [
        '/not fit to work/i', '/not fit for work/i', '/not fit/i', '/unfit/i', '/not cleared/i', '/unsuitable/i', '/not able to work/i', '/unable to work/i',
        // stricter phrasings specifically disallowing work-related tasks
        '/not fit to perform work-related tasks/i', '/not fit to perform work related tasks/i', '/not fit to perform work related duties/i', '/not fit to perform work related/i'
    ];

    $positiveMatches = 0;
    foreach ($positivePatterns as $pp) {
        if (preg_match($pp, $searchText)) $positiveMatches++;
    }

    $negativeMatches = 0;
    foreach ($negativePatterns as $np) {
        if (preg_match($np, $searchText)) $negativeMatches++;
    }

    // Also inspect parsed fields (prefer structured parsed output from AI)
    $parsedSuggestsFit = false;
    foreach ($per_image_results as $info) {
        if (empty($info['parsed']) || !is_array($info['parsed'])) continue;
        foreach ($info['parsed'] as $k => $v) {
            if (!is_string($v)) continue;
            $kv = strtolower($v);
            foreach ($positivePatterns as $pp) {
                if (@preg_match($pp, $kv)) { $parsedSuggestsFit = true; break 2; }
            }
        }
    }

    // Decision rules:
    // - If any explicit negative/unfit phrase is found, reject immediately.
    // - Otherwise prefer parsed evidence: if parsedSuggestsFit is true and negativeMatches == 0 => accept
    // - Otherwise use counts: accept if positiveMatches > negativeMatches
    $explicitUnfitFound = ($negativeMatches > 0);
    if ($explicitUnfitFound) {
        $containsFit = false;
    } else {
        if ($parsedSuggestsFit && $negativeMatches == 0) {
            $containsFit = true;
        } elseif ($positiveMatches > $negativeMatches && $positiveMatches > 0) {
            $containsFit = true;
        } else {
            $containsFit = false;
        }
    }

    // Write a small debug trace to help diagnose failing cases
    try {
        $dbg = ['searchText_snippet' => substr($searchText,0,800), 'positive' => $positiveMatches, 'negative' => $negativeMatches, 'parsedSuggestsFit' => $parsedSuggestsFit, 'time' => date('c')];
        @file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp_debug_ocr_fit_debug.json', json_encode($dbg, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    } catch (Exception $e) { /* ignore */ }

} catch (Exception $e) {
    $containsFit = false;
}

$result = [
    "ocrtype"  => $ocrtype,
    "ai_data"  => $parsed,
    "images"   => array_map('basename', $cleanImages),
    // per-image parsed results for debugging and source attribution
    "per_image" => $per_image_results,
    // disability detection from per-image merge
    "detected_disability" => $detected_disability,
    "disability_source" => $disability_source,
    // Additional validation flags
    "contains_fit_to_work" => $containsFit,
    // whether explicit negative/unfit statements were detected (reason for rejection)
    "contains_unfit_statement" => ($negativeMatches > 0),
    // helpful hint: whether we inferred fitness from doctor + date presence
    "inferred_by_doctor_date" => false,
];

// If not explicitly containing fit-to-work text, infer if parsed AI found a doctor and a date
// Do not infer fitness when an explicit unfit statement was detected.
if (!$result['contains_fit_to_work'] && empty($result['contains_unfit_statement'])) {
    $foundDoctor = false;
    $foundDate = false;
    foreach ($result['per_image'] as $p) {
        if (!empty($p['parsed']) && is_array($p['parsed'])) {
            foreach ($p['parsed'] as $k => $v) {
                $lk = strtolower($k);
                if (in_array($lk, ['doctor','physician','doctor_name','doctor name','doctor'])) {
                    if (!empty($v) && is_string($v) && trim($v) !== '') $foundDoctor = true;
                }
                if (in_array($lk, ['date','issue_date','exam_date','date_of_exam','date_of_issue','date_of_service'])) {
                    if (!empty($v) && is_string($v) && preg_match('/\d{4}-\d{2}-\d{2}|\d{1,2}\/\d{1,2}\/\d{2,4}|\w+ \d{1,2}, \d{4}/', $v)) $foundDate = true;
                }
            }
        }
    }
    if ($foundDoctor && $foundDate) {
        $result['contains_fit_to_work'] = true;
        $result['inferred_by_doctor_date'] = true;
        try {
            @file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp_debug_ocr_fit_inferred.json', json_encode(['foundDoctor'=>$foundDoctor,'foundDate'=>$foundDate,'time'=>date('c')], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (Exception $e) { }
    }
}

cleanup(array_merge([$tmpFile], $images, $cleanImages));

response(true, "Extraction completed", $result);

?>
