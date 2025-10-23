<?php
// simulate_local_approval.php
// Usage: php simulate_local_approval.php <jobId> [approved|flagged] [feedback] [actioned_by]
// Writes to storage/app/guardian_job_approvals.json like the controller's fallback does.

$jobId = $argv[1] ?? 'test123';
$status = $argv[2] ?? 'approved';
$feedback = $argv[3] ?? 'Simulated approval for debug';
$actionedBy = $argv[4] ?? 'cli:test';
$path = __DIR__ . '/../storage/app/guardian_job_approvals.json';
$map = [];
if (file_exists($path)) {
    $map = json_decode(file_get_contents($path), true) ?: [];
}
$map[(string)$jobId] = [
    'status' => $status,
    'feedback' => $feedback,
    'actioned_by' => $actionedBy,
    'actioned_at' => date('c'),
];
file_put_contents($path, json_encode($map, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "WROTE $path\n";
echo json_encode($map[(string)$jobId], JSON_PRETTY_PRINT) . PHP_EOL;
