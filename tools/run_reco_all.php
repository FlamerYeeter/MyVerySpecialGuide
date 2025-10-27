<?php
// tools/run_reco_all.php
// Bootstrap the Laravel app and run the GenerateRecommendations::runForAllUsers() helper.

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Bootstrap the framework (so app(), config(), storage_path(), etc work)
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting bulk recommendation generation...\n";
try {
    $res = \App\Jobs\GenerateRecommendations::runForAllUsers();
    if ($res === null) {
        echo "Generation failed or produced no output. Check storage/logs/laravel.log and storage/app/reco_debug_out_all.log\n";
        exit(1);
    }
    $count = count($res);
    echo "Generation completed for {$count} users.\n";
    // write a simple summary to stdout
    $uids = array_keys($res);
    foreach ($uids as $i => $uid) {
        if ($i < 20) echo " - {$uid}\n";
    }
    if ($count > 20) echo "... and " . ($count - 20) . " more users\n";
    exit(0);
} catch (\Throwable $e) {
    echo "Exception during generation: " . $e->getMessage() . "\n";
    exit(2);
}
