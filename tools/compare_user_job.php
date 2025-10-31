<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$uid = $argv[1] ?? 'BIPhEcQu6ISF8vdQvqeTpJf4O1D2';
$fs = app(\App\Services\FirestoreAdminService::class);
$svc = app(\App\Services\RecommendationService::class);
try {
    echo "Calling FirestoreAdminService->getUser()...\n";
    $user = $fs->getUser($uid);
    echo "Calling FirestoreAdminService->listJobs()...\n";
    $jobs = $fs->listJobs();
    if (empty($jobs)) { echo "No jobs found\n"; exit(0); }
    reset($jobs);
    $firstId = key($jobs);
    $job = $jobs[$firstId];
    echo "Sample job id: {$firstId}\n";
    echo "Job title: " . ($job['title'] ?? '(no title)') . "\n";
    echo "Job company: " . ($job['company'] ?? '') . "\n";
    echo "Job description (truncated):\n" . substr(($job['description'] ?? ''),0,400) . "\n\n";

    // Use reflection to call protected methods
    $ref = new ReflectionClass($svc);
    $buildUser = $ref->getMethod('buildUserText'); $buildUser->setAccessible(true);
    $tokMethod = $ref->getMethod('tokenizeText'); $tokMethod->setAccessible(true);
    $buildJob = $ref->getMethod('buildJobText'); $buildJob->setAccessible(true);

    $userText = $buildUser->invoke($svc, $user);
    $jobText = $buildJob->invoke($svc, $job);
    $userTokens = $tokMethod->invoke($svc, $userText);
    $jobTokens = $tokMethod->invoke($svc, $jobText);

    echo "User tokens (" . count($userTokens) . "): " . json_encode($userTokens) . "\n";
    echo "Job tokens (" . count($jobTokens) . "): " . json_encode(array_slice($jobTokens,0,60)) . "\n";

    $inter = array_values(array_intersect($userTokens, $jobTokens));
    echo "Intersection (" . count($inter) . "): " . json_encode($inter) . "\n";

    // compute similarity as RecommendationService does
    $interCount = count($inter);
    $unionCount = max(count($userTokens) + count($jobTokens) - $interCount, 1);
    $sim = round($interCount / $unionCount, 4);
    echo "Jaccard-like similarity = {$sim}\n";

} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
