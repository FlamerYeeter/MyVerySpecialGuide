<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$uid = $argv[1] ?? 'BIPhEcQu6ISF8vdQvqeTpJf4O1D2';
$svc = app(\App\Services\RecommendationService::class);
$fs = app(\App\Services\FirestoreAdminService::class);
try {
    echo "Inspecting uid={$uid}\n";
    $user = $fs->getUser($uid);
    if ($user === null) { echo "getUser returned null\n"; exit(0); }
    echo "User top-level keys: " . implode(', ', array_keys($user)) . "\n";
    echo "User array (truncated):\n" . json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
    // call buildUserText via Reflection or by exposing a small helper
    // buildUserText is protected; we'll call generate with limit=0 to get userText via debugging
    // Instead, use reflection to access protected method
    $ref = new ReflectionClass($svc);
    if ($ref->hasMethod('buildUserText')) {
        $m = $ref->getMethod('buildUserText');
        $m->setAccessible(true);
        $userText = $m->invoke($svc, $user);
        echo "buildUserText output (len=" . strlen($userText) . "):\n" . $userText . "\n";
        // Tokenize: call tokenizeText (protected)
        if ($ref->hasMethod('tokenizeText')) {
            $tok = $ref->getMethod('tokenizeText');
            $tok->setAccessible(true);
            $tokens = $tok->invoke($svc, $userText);
            echo "Tokens (count=" . count($tokens) . "):\n" . json_encode($tokens) . "\n";
        }
    } else {
        echo "No buildUserText method found\n";
    }
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
