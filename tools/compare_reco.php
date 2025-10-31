<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$uid = $argv[1] ?? 'BIPhEcQu6ISF8vdQvqeTpJf4O1D2';
$limit = intval($argv[2] ?? 50);
$svc = app(\App\Services\RecommendationService::class);
try {
    echo "Running RecommendationService->generateCompare for uid={$uid} limit={$limit}\n";
    $start = microtime(true);
    $cmp = $svc->generateCompare($uid, $limit);
    $dur = microtime(true) - $start;
    echo "DONE in " . round($dur,2) . "s\n";

    // helper to compute stats
    $stats = function($arr) {
        $vals = array_values($arr);
        if (empty($vals)) return ['count'=>0,'nonzero'=>0,'min'=>0,'max'=>0,'avg'=>0];
        $d = array_map('floatval', $vals);
        $nonzero = count(array_filter($d, function($v){ return $v > 0.0; }));
        return ['count'=>count($d),'nonzero'=>$nonzero,'min'=>min($d),'max'=>max($d),'avg'=>array_sum($d)/count($d)];
    };

    $ja = $stats($cmp['jaccard'] ?? []);
    $tf = $stats($cmp['tfidf'] ?? []);
    $ct = $stats($cmp['context'] ?? []);

    echo "Jaccard (CBF) stats: count={$ja['count']} nonzero={$ja['nonzero']} min={$ja['min']} max={$ja['max']} avg=".round($ja['avg'],6)."\n";
    echo "TF-IDF stats: count={$tf['count']} nonzero={$tf['nonzero']} min={$tf['min']} max={$tf['max']} avg=".round($tf['avg'],6)."\n";
    echo "Context stats: count={$ct['count']} nonzero={$ct['nonzero']} min={$ct['min']} max={$ct['max']} avg=".round($ct['avg'],6)."\n";

    // show top 10 by each
    echo "\nTop 10 by Jaccard:\n";
    arsort($cmp['jaccard']);
    $i=0; foreach ($cmp['jaccard'] as $k=>$v) { if ($i++>=10) break; echo "  {$k}: {$v}\n"; }
    echo "\nTop 10 by TF-IDF:\n";
    arsort($cmp['tfidf']);
    $i=0; foreach ($cmp['tfidf'] as $k=>$v) { if ($i++>=10) break; echo "  {$k}: {$v}\n"; }
    echo "\nTop 10 by Context-aware score:\n";
    $i=0; foreach ($cmp['top_context'] as $k=>$v) { if ($i++>=10) break; echo "  {$k}: {$v}\n"; }

    // sample diff: jobs that changed rank between jaccard and tfidf
    echo "\nSample differences (Jaccard vs TF-IDF):\n";
    $ja_sorted = array_keys($cmp['jaccard']);
    $tf_sorted = array_keys($cmp['tfidf']);
    $common = array_intersect($ja_sorted, $tf_sorted);
    $sample = array_slice($common, 0, 10);
    foreach ($sample as $jid) {
        $jv = $cmp['jaccard'][$jid] ?? 0;
        $tv = $cmp['tfidf'][$jid] ?? 0;
        echo "  {$jid}: jaccard={$jv} tfidf={$tv}\n";
    }

    // dump full comparison to storage for further inspection
    $outPath = __DIR__ . "/../storage/app/reco_compare_{$uid}.json";
    file_put_contents($outPath, json_encode($cmp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo "\nFull comparison written to {$outPath}\n";

} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
