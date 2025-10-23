<?php
$path = __DIR__ . '/../public/postings.csv';
if (!file_exists($path)) { echo "missing\n"; exit(1); }
$h = fopen($path, 'r');
$header = fgetcsv($h);
echo "HEADER:\n" . json_encode($header) . "\n";
$i = 0;
while (($r = fgetcsv($h)) !== false && $i < 20) {
    echo 'ROW ' . ($i+1) . ': ' . json_encode($r) . "\n";
    $i++;
}
fclose($h);
