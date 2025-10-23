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
            }
        } catch (\Throwable $e) {
            Log::error('GenerateRecommendations job exception: ' . $e->getMessage());
        } finally {
            if (isset($tmpPath) && file_exists($tmpPath)) @unlink($tmpPath);
        }
    }
}
