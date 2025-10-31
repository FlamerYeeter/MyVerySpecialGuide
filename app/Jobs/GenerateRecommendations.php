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
            // Delegate to runAndReturn for the heavy lifting; handle() keeps compatibility by running it and ignoring the return value.
            $this->runAndReturn();
        } catch (\Throwable $e) {
            Log::error('GenerateRecommendations job exception: ' . $e->getMessage());
        }
    }

    /**
     * Run the Python generator and post-processing, then return the decoded JSON result.
     * Returns null on failure.
     *
     * @return array|null
     */
    public function runAndReturn(): ?array
    {
        $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', $this->uid ?: 'anonymous');
        $cachePath = storage_path('app/reco_user_' . $safeUid . '.json');
        $tmpPath = storage_path('app/tmp_reco_users_' . $safeUid . '.json');

    Log::info('GenerateRecommendations runAndReturn start for uid=' . $this->uid);
    // write profile JSON
        @mkdir(dirname($tmpPath), 0755, true);
        $usersJson = json_encode([$this->uid => $this->profile], JSON_UNESCAPED_UNICODE);
        file_put_contents($tmpPath, $usersJson);
        // debug copy
        $debugUsersPath = storage_path('app/reco_debug_users_' . $safeUid . '.json');
        @file_put_contents($debugUsersPath, $usersJson);

        $python = 'python';
        $script = base_path('tools/generate_recommendations.py');
        $input = base_path('public/postings.csv');

        // Request per-user output from the Python script so the produced JSON is keyed by uid
        $cmd = [$python, $script, '--input', $input, '--users', $tmpPath, '--print-per-user', '--output', $cachePath, '--top', '50', '--alpha', '0.6', '--neighbors', '5'];
        $process = new Process($cmd);
        $process->setTimeout(600);
        $process->run();

        $procOut = $process->getOutput();
        $procErr = $process->getErrorOutput();
        $debugOutPath = storage_path('app/reco_debug_out_' . $safeUid . '.log');
        @file_put_contents($debugOutPath, "CMD: " . implode(' ', $cmd) . "\n\nSTDOUT:\n" . $procOut . "\n\nSTDERR:\n" . $procErr);

        if (!$process->isSuccessful()) {
            Log::error('GenerateRecommendations runAndReturn failed for uid=' . $this->uid . ': ' . substr($procErr ?: $procOut, 0, 1000));
        } else {
            Log::info('GenerateRecommendations runAndReturn completed for uid=' . $this->uid . ' (debug: ' . $debugOutPath . ')');
        }

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

        // Read and decode the produced cache file if available
        if (file_exists($cachePath)) {
            $raw = @file_get_contents($cachePath);
            $json = json_decode($raw, true);
            // write parsed debug copy for easy inspection
            try {
                $debugParsedPath = storage_path('app/reco_debug_parsed_' . $safeUid . '.json');
                @file_put_contents($debugParsedPath, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            } catch (\Throwable $_w) {}
            // Clean up tmp file
            if (file_exists($tmpPath)) @unlink($tmpPath);
            $count = 0;
            if (is_array($json)) {
                // if mapping keyed by uid, compute total or per-uid
                if (array_key_exists($this->uid, $json) && is_array($json[$this->uid])) $count = count($json[$this->uid]);
                else $count = count($json);
            }
            Log::info('GenerateRecommendations runAndReturn completed for uid=' . $this->uid . ' count=' . $count);
            return $json;
        }

        if (file_exists($tmpPath)) @unlink($tmpPath);
        Log::warning('GenerateRecommendations runAndReturn finished but no cache produced for uid=' . $this->uid);
        return null;
    }

    /**
     * Run the Python generator for ALL users (bulk mode).
     * Fetches user profiles (Firestore if available, otherwise test users file),
     * invokes the Python generator with --print-per-user and writes per-UID cache files
     * atomically to storage/app/reco_user_<uid>.json.
     * Returns the decoded mapping uid => recommendations on success, or null.
     */
    public static function runForAllUsers(): ?array
    {
        try {
            $fs = app()->make(\App\Services\FirestoreAdminService::class);
            $users = [];
            try {
                $users = $fs->listUsers();
            } catch (\Throwable $_e) {
                // fallback to test users
                $users = [];
            }

            // Fallback to tools/test_users.json if Firestore returned none
            if (empty($users)) {
                $testPath = base_path('tools/test_users.json');
                if (file_exists($testPath)) {
                    $raw = @file_get_contents($testPath);
                    $arr = json_decode($raw, true) ?: [];
                    foreach ($arr as $u) {
                        if (!empty($u['uid'])) $users[$u['uid']] = $u;
                    }
                }
            }

            if (empty($users)) {
                logger()->warning('GenerateRecommendations::runForAllUsers: no users found to generate');
                return null;
            }

            $tmpPath = storage_path('app/tmp_reco_users_all.json');
            @mkdir(dirname($tmpPath), 0755, true);
            $usersJson = json_encode($users, JSON_UNESCAPED_UNICODE);
            file_put_contents($tmpPath, $usersJson, LOCK_EX);

            $python = 'python';
            $script = base_path('tools/generate_recommendations.py');
            $input = base_path('public/postings.csv');
            $outPath = storage_path('app/reco_user_all_output.json');

            $cmd = [$python, $script, '--input', $input, '--users', $tmpPath, '--print-per-user', '--output', $outPath, '--top', '50', '--alpha', '0.6', '--neighbors', '5'];
            $process = new Process($cmd);
            $process->setTimeout(1200);
            $process->run();

            $procOut = $process->getOutput();
            $procErr = $process->getErrorOutput();
            $debugOutPath = storage_path('app/reco_debug_out_all.log');
            @file_put_contents($debugOutPath, "CMD: " . implode(' ', $cmd) . "\n\nSTDOUT:\n" . $procOut . "\n\nSTDERR:\n" . $procErr, LOCK_EX);

            if (!$process->isSuccessful()) {
                logger()->error('GenerateRecommendations::runForAllUsers: python process failed: ' . substr($procErr ?: $procOut, 0, 1000));
                // still attempt to read any output file
            }

            if (!file_exists($outPath)) {
                logger()->warning('GenerateRecommendations::runForAllUsers: expected output not produced: ' . $outPath);
                return null;
            }

            $raw = @file_get_contents($outPath);
            $json = json_decode($raw, true);

            // write parsed debug copy
            try {
                $debugParsed = storage_path('app/reco_debug_parsed_all.json');
                @file_put_contents($debugParsed, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
            } catch (\Throwable $_w) {}

            if (!is_array($json)) {
                logger()->warning('GenerateRecommendations::runForAllUsers: output not an array/map');
                return null;
            }

            // For each uid in json mapping write per-uid cache file atomically
            foreach ($json as $uid => $recList) {
                $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', $uid ?: 'anonymous');
                $final = storage_path('app/reco_user_' . $safeUid . '.json');
                $tmp = $final . '.tmp';
                try {
                    @file_put_contents($tmp, json_encode($recList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), LOCK_EX);
                    @rename($tmp, $final);
                } catch (\Throwable $e) {
                    logger()->warning('GenerateRecommendations::runForAllUsers: failed to write per-uid cache for ' . $uid . ': ' . $e->getMessage());
                }
            }

            // Cleanup temporary output file
            @unlink($outPath);
            if (file_exists($tmpPath)) @unlink($tmpPath);

            // write a small last-run metadata file for monitoring
            try {
                $metaPath = storage_path('app/reco_last_run.json');
                $meta = [
                    'ts' => date('c'),
                    'user_count' => count($json),
                    'debug_out' => $debugOutPath,
                ];
                @file_put_contents($metaPath, json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
            } catch (\Throwable $_w) {}

            logger()->info('GenerateRecommendations::runForAllUsers: completed for ' . count($json) . ' users');
            return $json;
        } catch (\Throwable $e) {
            logger()->error('GenerateRecommendations::runForAllUsers exception: ' . $e->getMessage());
            return null;
        }
    }
}
