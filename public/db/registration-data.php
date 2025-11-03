<?php
require_once 'oracledb.php'; 

function saveBase64File($base64String, $path = '../uploads/') {
    if (empty($base64String)) {
        return null;
    }

    // Remove possible "data:...;base64," prefix
    if (strpos($base64String, ',') !== false) {
        $base64String = substr($base64String, strpos($base64String, ',') + 1);
    }

    // Decode the base64 data
    $data = base64_decode($base64String);
    if ($data === false) {
        die('base64_decode failed');
    }

    // Auto-detect MIME type from binary content
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->buffer($data);

    // Map MIME types to extensions
    $extMap = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'application/pdf' => 'pdf',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
    ];

    // Detect file extension or fallback
    $ext = isset($extMap[$mime]) ? $extMap[$mime] : 'bin';

    // Ensure upload folder exists
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    // Generate random filename
    $filename = uniqid('file_', true) . '.' . $ext;
    $filePath = $path . $filename;

    // Save file
    file_put_contents($filePath, $data);

    // Return file info
    return [
        'path' => $filePath,
        'filename' => $filename,
        'mime' => $mime,
        'extension' => $ext
    ];
}

$json = file_get_contents('php://input');
$data = json_decode($json, true); // associative array

if (!$data) {
    http_response_code(400);
    die("Invalid JSON input");
}

// ✅ Access by key names
$education_level   = $data['education'] ?? null;
$education_history = json_decode($data['job_experiences'] ?? '[]', true);
$is_graduate       = $data['review_certs'] ?? null;
$user_info         = json_decode($data['rpi_personal'] ?? '{}', true);
$main_course       = $data['school_name'] ?? null;
$work_type         = json_decode($data['selected_work_experience'] ?? '[]', true);
$license_type      = $data['selected_work_year'] ?? null;
$work_method       = json_decode($data['support'] ?? '[]', true);
$file_1         = $data['uploadedProofData0'] ?? null;
$file_2         = $data['uploadedProofData1'] ?? null;
$status            = $data['workplace'] ?? null;
$job_category      = json_decode($data['jobPreferences'] ?? '[]', true);

// ✅ Save uploaded files
$result1 = saveBase64File($file_1);
$result2 = saveBase64File($file_2);

$conn = getOracleConnection();

// ✅ Debug output (for testing)
echo "<pre>";
print_r([
    'education_level' => $education_level,
    'education_history' => $education_history,
    'user_info' => $user_info,
    'work_type' => $work_type,
    'license_type' => $license_type,
    'work_method' => $work_method,
    'status' => $status,
    'job_category' => $job_category,
    'file1' => $result1,
    'file2' => $result2
]);
echo "</pre>";
?>
