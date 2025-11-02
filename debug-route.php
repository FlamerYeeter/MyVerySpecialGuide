<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$request = Illuminate\Http\Request::create('/', 'GET');
$response = $app->handle($request);
http_response_code($response->getStatusCode());
echo "Status: " . $response->getStatusCode() . "\n";
echo "Headers:\n";
foreach ($response->headers->all() as $k => $v) {
    echo "$k: " . implode(',',$v) . "\n";
}
echo "\nBody:\n";
echo (string)$response->getContent();
