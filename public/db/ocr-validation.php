<?php
/**************************************
 * OCR API - Base64 to OCR Extraction (Windows)
 * Handles:
 * - membership_proof (optional)
 * - pwd_id (PWD ID Philippine)
 * - medical_certificate
 * Requirements:
 * - Tesseract
 * - Poppler (for PDFs)
 * - ImageMagick
 **************************************/

error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);

// ================================
// CONFIG
// ================================

define('TESSERACT', '"C:\\Program Files\\Tesseract-OCR\\tesseract.exe"');
define('MAX_BASE64', 10_000_000); // ~10MB

header("Content-Type: application/json");

// ================================
// FUNCTIONS
// ================================

function buildOcrPrompt($fields, $text)
{
    // Build JSON format dynamically
    $jsonFormat = "{\n";
    foreach ($fields as $key => $value) {
        $jsonFormat .= "  \"$key\": \"$value\",\n";
    }
    $jsonFormat = rtrim($jsonFormat, ",\n") . "\n}";

    // Build field list
    $fieldList = "- " . implode("\n- ", array_keys($fields));

    return <<<PROMPT
TASK:
Extract data from the OCR text and determine where each value should be placed. Return the extracted information in the specified JSON format. Convert unstructured OCR text into structured fields. Do not leave any fields missing. If the data is not immediately found, carefully analyze and search the text to locate it. If Filipino addresses or Filipino words are found, align them to the appropriate fields.
Strictly provide full data and return only the JSON object without any additional text or explanations and follow the format.

FIELDS:
$fieldList

JSON FORMAT:
$jsonFormat

OCR TEXT:
$text
PROMPT;
}

function callAI($model, $prompt)
{
    $url = "http://localhost:11434/api/generate";

    $payload = json_encode([
        "model" => $model,
        "prompt" => $prompt,
        "stream" => false
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);

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

if (in_array($ocrtype, ['membership_proof', 'pwd_id', 'medical_certificate'])) {
    $base64_data = $data['ocr_data'] ?? null;
    if (!$base64_data) response(false, "No file data provided");

    if (strpos($base64_data, ',') !== false) $base64_data = explode(',', $base64_data)[1];
    $fileData = base64_decode($base64_data);
    if (!$fileData) response(false, "Invalid Base64 file");
    if (strlen($base64_data) > MAX_BASE64) response(false, "File too large");
} else {
    response(false, "Invalid OCR type");
}

// ================================
// 3. DETECT FILE TYPE
// ================================

$ext = null;

if (isset($base64_data)) {
    if (str_starts_with($data['ocr_data'], 'data:image/jpeg')) $ext = '.jpg';
    elseif (str_starts_with($data['ocr_data'], 'data:image/png')) $ext = '.png';
    elseif (str_starts_with($data['ocr_data'], 'data:application/pdf')) $ext = '.pdf';
}

if (!$ext && $fileData) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_buffer($finfo, $fileData);
    finfo_close($finfo);
    $extMap = ['image/jpeg' => '.jpg','image/png'=>'.png','application/pdf'=>'.pdf'];
    $ext = $extMap[$mime] ?? null;
}

if (!$ext) response(false, "Unsupported file type");

// ================================
// 4. CREATE TEMP FILE
// ================================

$tmp = tempnam(sys_get_temp_dir(), 'ocr_');
$tmpFile = $tmp . $ext;
rename($tmp, $tmpFile);
file_put_contents($tmpFile, $fileData);

// ================================
// 5. PDF → IMAGE
// ================================

$images = [];
if ($ext === '.pdf') {
    $out = $tmp . '_img';
    shell_exec("pdftoppm -png \"$tmpFile\" \"$out\"");
    $page = 1;
    while (file_exists($out . "-$page.png")) {
        $images[] = $out . "-$page.png";
        $page++;
    }
    if (empty($images)) { cleanup([$tmpFile]); response(false, "PDF conversion failed"); }
} else $images[] = $tmpFile;

// ================================
// 6. IMAGE PREPROCESSING
// ================================

$cleanImages = [];
foreach ($images as $img) {     
    $clean = $img . "_clean.png";
    shell_exec("magick \"$img\" -resize 200% -colorspace Gray -sharpen 0x1 \"$clean\"");
    if (!file_exists($clean)) { cleanup(array_merge([$tmpFile], $images)); response(false, "Image processing failed"); }
    $cleanImages[] = $clean;
}

// ================================
// 7. OCR
// ================================

$text = '';
foreach ($cleanImages as $clean) {
    $pageText = shell_exec(TESSERACT . " \"$clean\" stdout -l eng+fil");
    if ($pageText) $text .= "\n" . $pageText;
}
if (!$text) { cleanup(array_merge([$tmpFile], $images, $cleanImages)); response(false, "OCR failed"); }

// ================================
// 8. BUILD PROMPT
// ================================

if ($ocrtype === 'pwd_id') {
    $fields = [
        "full_name" => "Juan Dela Cruz",
        "type_of_disability" => "Physical Disability",
        "id_number" => "just find what looks like an ID number",
        "address" => "Brgy. San Isidro, Quezon City, Metro Manila, Philippines"
    ];
} elseif ($ocrtype === 'medical_certificate') {
    $fields = [
        "patient_name" => "just find a name that looks like the patient name",
        "date" => "just find a date that looks like the issue date",
        "diagnosis" => "just find the diagnosis information",
        "doctor_name" => "just find a name that looks like the doctor's name",
        "clinic_name" => "just find a name that looks like the clinic or hospital name"
    ];
} else {
    $fields = [
        "summary" => "The document contains general medical information including patient details, diagnosis, and treatment recommendations."
    ];
}

$prompt = buildOcrPrompt($fields, $text);

// ================================
// 9. CALL AI
// ================================

$aiResponse = callAI("phi4-mini:3.8b", $prompt);
if (!$aiResponse || empty($aiResponse['response'])) response(false, "AI extraction failed");

// ================================
// 10. PARSE AI JSON
// ================================

$aiText = trim($aiResponse['response']);
$aiText = preg_replace('/<think>.*?<\/think>/s', '', $aiText);
$aiText = preg_replace('/```json|```/', '', $aiText);

preg_match_all('/\{(?:[^{}]|(?R))*\}/s', $aiText, $matches);
if (empty($matches[0])) response(false, "No JSON found in AI response", ["raw_ai_response"=>$aiText]);

$jsonOnly = end($matches[0]);
$parsed = json_decode($jsonOnly, true);
if (json_last_error() !== JSON_ERROR_NONE) response(false, "AI returned invalid JSON", ["json_error"=>json_last_error_msg(), "raw_ai_response"=>$jsonOnly]);

// ================================
// 11. FINAL RESULT
// ================================

$result = [
    "ocrtype" => $ocrtype,
    "ai_data" => $parsed,   
    "raw_text" => $text
];

cleanup(array_merge([$tmpFile], $images, $cleanImages));

response(true, "OCR completed", $result);

?>
