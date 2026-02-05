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
    $url = "http://192.168.100.30:11434/api/generate";

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

if (!in_array($ocrtype, ['certificate_proof', 'membership_proof', 'pwd_id', 'medical_certificate'])) {
    response(false, "Invalid OCR type");
}

$base64_data = $data['ocr_data'] ?? null;
if (!$base64_data) response(false, "No file data provided");

if (strpos($base64_data, ',') !== false) {
    $base64_data = explode(',', $base64_data)[1];
}

$fileData = base64_decode($base64_data);
if (!$fileData) response(false, "Invalid Base64 file");
if (strlen($base64_data) > MAX_BASE64) response(false, "File too large");

// ================================
// 3. DETECT FILE TYPE
// ================================

$ext = null;
if (str_starts_with($data['ocr_data'], 'data:image/jpeg')) $ext = '.jpg';
elseif (str_starts_with($data['ocr_data'], 'data:image/png')) $ext = '.png';
elseif (str_starts_with($data['ocr_data'], 'data:application/pdf')) $ext = '.pdf';

if (!$ext) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_buffer($finfo, $fileData);
    finfo_close($finfo);
    $extMap = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'application/pdf' => '.pdf'];
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
    shell_exec("pdftoppm -png " . escapeshellarg($tmpFile) . " " . escapeshellarg($out));
    $page = 1;
    while (file_exists($out . "-$page.png")) {
        $images[] = $out . "-$page.png";
        $page++;
    }
    if (empty($images)) {
        cleanup([$tmpFile]);
        response(false, "PDF conversion failed");
    }
} else {
    $images[] = $tmpFile;
}

// ================================
// 6. IMAGE PREPROCESSING (recommended even for vision models)
// ================================

$cleanImages = [];
foreach ($images as $img) {
    $clean = pathinfo($img, PATHINFO_FILENAME) . "_clean.png";

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

if ($ocrtype === 'pwd_id') {
    $fields = [
        "type_of_disability"    => "Physical Disability"
    ];
} elseif ($ocrtype === 'medical_certificate') {
    $fields = [
        "date"                  => "YYYY-MM-DD"
    ];
}  elseif ($ocrtype === 'membership_proof') {
    $fields = [
        "is_membership"         => "true or false"
    ];
}  elseif ($ocrtype === 'certificate_proof') {
    $fields = [
        "cert_name"             => "Name of the Certificate",
        "issued_by"             => "Issuing Organization",
        "date_completed"        => "YYYY-MM-DD"
    ];
}
else {
    $fields = [
        "summary" => "short summary of document content",
    ];
}

$prompt = buildOcrPrompt($fields, $cleanImages, $ocrtype);

$model = implode('', [
    chr(109), chr(105), chr(110), chr(105), chr(115), chr(116), chr(114),
    chr(97), chr(108), chr(45), chr(51), chr(58), chr(49), chr(52), chr(98),
    chr(45), chr(99), chr(108), chr(111), chr(117), chr(100)
]);

$model = base64_decode('bWluaXN0cmFsLTM6MTRiLWNsb3Vk');

$aiResponse = callOCR($model, $prompt, $cleanImages);

if (!$aiResponse || empty($aiResponse['response'])) {
    response(false, "Did not return any response");
}

// ================================
// 8. PARSE RESPONSE
// ================================

$aiText = trim($aiResponse['response']);
$aiText = preg_replace('/```json\s*|\s*```/', '', $aiText);
$aiText = preg_replace('/<think>.*?<\/think>/s', '', $aiText);

preg_match('/\{.*\}/s', $aiText, $matches);
if (empty($matches)) {
    response(false, "No JSON found in response", ["raw" => $aiText]);
}

$jsonOnly = $matches[0];
$parsed = json_decode($jsonOnly, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    response(false, "Invalid JSON", [
        "error" => json_last_error_msg(),
        "raw"   => $jsonOnly
    ]);
}

// ================================
// 9. FINAL RESULT
// ================================

$result = [
    "ocrtype"  => $ocrtype,
    "ai_data"  => $parsed,
    "images"   => array_map('basename', $cleanImages),
];

cleanup(array_merge([$tmpFile], $images, $cleanImages));

response(true, "Extraction completed", $result);

?>
