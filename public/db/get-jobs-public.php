<?php
// get-jobs-public.php
// Lightweight public endpoint to list job postings for unauthenticated viewers.
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ERROR | E_PARSE);

require_once 'oracledb.php';

$limit = 10;
if (!empty($_GET['limit'])) $limit = intval($_GET['limit']);
if ($limit <= 0) $limit = 10;
if ($limit > 200) $limit = 200;

$title = !empty($_GET['title']) ? trim($_GET['title']) : null;
$location = !empty($_GET['location']) ? trim($_GET['location']) : null;

// Attempt DB connection
$conn = null;
try {
    $conn = getOracleConnection();
} catch (Throwable $e) {
    $conn = null;
}

// If DB not available, try to return fallback JSON if present
if (!$conn) {
    $fallback = __DIR__ . DIRECTORY_SEPARATOR . 'jobs_public_fallback.json';
    if (file_exists($fallback)) {
        $raw = @file_get_contents($fallback);
        $data = json_decode($raw, true);
        if (is_array($data)) {
            echo json_encode(['success' => true, 'jobs' => $data], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
            exit;
        }
    }
    // graceful empty response
    echo json_encode(['success' => true, 'jobs' => [], 'message' => 'DB unavailable, no fallback found']);
    exit;
}

// Build lightweight SQL (avoid blobs and heavy joins)
// Use a subquery so filters are applied before limiting rows with ROWNUM
$inner = "SELECT ID, COMPANY_NAME, JOB_DESCRIPTION, ADDRESS, JOB_TYPE, EMPLOYEE_CAPACITY, APPLY_BEFORE, TO_CHAR(JOB_POST_DATE,'YYYY-MM-DD\"T\"HH24:MI:SS') AS JOB_POST_DATE, COMPANY_IMAGE FROM MVSG.JOB_POSTINGS WHERE 1=1";
// Apply simple filters if provided
if ($title !== null) $inner .= " AND LOWER(JOB_DESCRIPTION) LIKE :title_like";
if ($location !== null) $inner .= " AND LOWER(ADDRESS) LIKE :location_like";
$inner .= " ORDER BY JOB_POST_DATE DESC";

$sql = "SELECT * FROM (" . $inner . ") WHERE ROWNUM <= :limit";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':limit', $limit, -1);
if ($title !== null) {
    $tl = '%' . strtolower($title) . '%';
    oci_bind_by_name($stid, ':title_like', $tl, -1);
}
if ($location !== null) {
    $ll = '%' . strtolower($location) . '%';
    oci_bind_by_name($stid, ':location_like', $ll, -1);
}

if (!@oci_execute($stid)) {
    // fallback: return empty success so frontend shows friendly message
    echo json_encode(['success' => true, 'jobs' => [], 'message' => 'Query failed or returned no rows']);
    exit;
}

// Helper: convert BLOB (OCI LOB or binary string) to data URI
function blob_to_data_uri($blob)
{
    if (!$blob) return null;
    if (is_object($blob) && method_exists($blob, 'load')) {
        $data = $blob->load();
    } else {
        $data = $blob;
    }
    if ($data === null || $data === '') return null;

    // detect mime type if possible
    $mime = null;
    if (function_exists('finfo_open')) {
        $f = finfo_open(FILEINFO_MIME_TYPE);
        if ($f !== false) {
            $m = finfo_buffer($f, $data);
            if ($m) $mime = $m;
            finfo_close($f);
        }
    }
    if (!$mime) $mime = 'image/png';
    return 'data:' . $mime . ';base64,' . base64_encode($data);
}

$jobs = [];
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS)) {
    $dataUri = null;
    if (isset($row['COMPANY_IMAGE']) && $row['COMPANY_IMAGE'] !== null) {
        $dataUri = blob_to_data_uri($row['COMPANY_IMAGE']);
    }
    $logo = $dataUri ?: 'https://via.placeholder.com/150?text=Logo';

    $jobs[] = [
        'id' => isset($row['ID']) ? $row['ID'] : null,
        'company_name' => $row['COMPANY_NAME'] ?? null,
        // `JOB_ROLE` removed from schema; expose job_type and description instead
        'description' => $row['JOB_DESCRIPTION'] ?? null,
        'address' => $row['ADDRESS'] ?? null,
        'job_type' => $row['JOB_TYPE'] ?? null,
        'employee_capacity' => isset($row['EMPLOYEE_CAPACITY']) ? $row['EMPLOYEE_CAPACITY'] : null,
        'apply_before' => $row['APPLY_BEFORE'] ?? null,
        'posted_date' => $row['JOB_POST_DATE'] ?? null,
        'company_image_data_uri' => $dataUri,
        'logo' => $logo,
    ];
}

oci_free_statement($stid);
@oci_close($conn);

echo json_encode(['success' => true, 'jobs' => $jobs], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
exit;

?>
