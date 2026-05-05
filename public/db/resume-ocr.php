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

$response = ['raw_text' => trim($allText), 'pages' => $perPage, 'count' => count($perPage)];
response_json(true, 'OCR completed', $response);

?>