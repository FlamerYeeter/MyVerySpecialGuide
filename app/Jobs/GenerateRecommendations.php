<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class GenerateRecommendations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $uid;
    public $profile;

    /**
     * Create a new job instance.
     * @param string $uid
     * @param array|null $profile
     */
    public function __construct(string $uid, ?array $profile = null)
    {
        $this->uid = $uid;
        $this->profile = $profile ?: [];
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', $this->uid ?: 'anonymous');
            $cachePath = storage_path('app/reco_user_' . $safeUid . '.json');
            $tmpPath = storage_path('app/tmp_reco_users_' . $safeUid . '.json');

            // write profile JSON
            @mkdir(dirname($tmpPath), 0755, true);
            file_put_contents($tmpPath, json_encode([$this->uid => $this->profile], JSON_UNESCAPED_UNICODE));

            $python = 'python';
            $script = base_path('tools/generate_recommendations.py');
            $input = base_path('public/postings.csv');

            $cmd = [$python, $script, '--input', $input, '--users', $tmpPath, '--output', $cachePath, '--top', '50', '--alpha', '0.6', '--neighbors', '5'];
            $process = new Process($cmd);
            // generous timeout for potential large CSVs
            $process->setTimeout(600);
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error('GenerateRecommendations job failed: ' . $process->getErrorOutput());
            } else {
                Log::info('GenerateRecommendations job completed for uid=' . $this->uid);
                // Attempt to apply ensemble weights (if best_weights.json exists)
                try {
                    $rescoredTmp = storage_path('app/reco_user_' . $safeUid . '_rescored.json');
                    $cmd2 = [$python, base_path('tools/apply_weights_to_file.py'), '--input', $cachePath, '--output', $rescoredTmp];
                    $p2 = new Process($cmd2);
                    $p2->setTimeout(120);
                    $p2->run();
                    if ($p2->isSuccessful()) {
                        @rename($rescoredTmp, $cachePath);
                        Log::info('Applied best_weights to reco for uid=' . $this->uid);
                    } else {
                        Log::warning('apply_weights_to_file failed: ' . $p2->getErrorOutput());
                    }
                } catch (\Throwable $e) {
                    Log::warning('apply_weights_to_file exception: ' . $e->getMessage());
                }

                // Optionally apply stacker model if available
                try {
                    $stackerModel = base_path('tools/stacker_model.pkl');
                    if (file_exists($stackerModel)) {
                        $stackOut = storage_path('app/reco_user_' . $safeUid . '_stacked.json');
                        $cmd3 = [$python, base_path('tools/apply_stacker_to_recommendations.py'), '--model', $stackerModel, '--input', $cachePath, '--output', $stackOut];
                        $p3 = new Process($cmd3);
                        $p3->setTimeout(120);
                        $p3->run();
                        if ($p3->isSuccessful()) {
                            @rename($stackOut, $cachePath);
                            Log::info('Applied stacker model to reco for uid=' . $this->uid);
                        } else {
                            Log::warning('apply_stacker_to_recommendations failed: ' . $p3->getErrorOutput());
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning('apply_stacker exception: ' . $e->getMessage());
                }
            }
        } catch (\Throwable $e) {
            Log::error('GenerateRecommendations job exception: ' . $e->getMessage());
        } finally {
            if (isset($tmpPath) && file_exists($tmpPath)) @unlink($tmpPath);
        }
    }
}
