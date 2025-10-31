<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Services\RecommendationService;

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

        Log::info('GenerateRecommendations runAndReturn (PHP) start for uid=' . $this->uid);

        try {
            // Use the PHP RecommendationService to generate results
            $recoSvc = app()->make(RecommendationService::class);
            $list = $recoSvc->generate($this->uid, 50);

            // Ensure we return a mapping keyed by the original uid (keeps compatibility)
            $mapping = [$this->uid => $list];

            // Write per-uid cache for compatibility with existing controllers/views
            try {
                @mkdir(dirname($cachePath), 0755, true);
                @file_put_contents($cachePath, json_encode($mapping, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), LOCK_EX);
                Log::info('GenerateRecommendations: wrote PHP-generated cache for uid=' . $this->uid . ' -> ' . $cachePath);
            } catch (\Throwable $_w) {
                Log::warning('GenerateRecommendations: failed to write cache for uid=' . $this->uid . ' : ' . $_w->getMessage());
            }

            return $mapping;
        } catch (\Throwable $e) {
            Log::error('GenerateRecommendations runAndReturn (PHP) failed for uid=' . $this->uid . ': ' . $e->getMessage());
            return null;
        }
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

            $recoSvc = app()->make(RecommendationService::class);
            $outMap = [];
            foreach ($users as $uid => $profile) {
                try {
                    $list = $recoSvc->generate((string)$uid, 50);
                    $outMap[(string)$uid] = $list;
                    // write per-uid cache for compatibility
                    $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', $uid ?: 'anonymous');
                    $final = storage_path('app/reco_user_' . $safeUid . '.json');
                    $tmp = $final . '.tmp';
                    @file_put_contents($tmp, json_encode([$uid => $list], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), LOCK_EX);
                    @rename($tmp, $final);
                } catch (\Throwable $e) {
                    logger()->warning('GenerateRecommendations::runForAllUsers: generation failed for ' . $uid . ': ' . $e->getMessage());
                }
            }

            // write a small last-run metadata file for monitoring
            try {
                $metaPath = storage_path('app/reco_last_run.json');
                $meta = [
                    'ts' => date('c'),
                    'user_count' => count($outMap),
                ];
                @file_put_contents($metaPath, json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
            } catch (\Throwable $_w) {}

            logger()->info('GenerateRecommendations::runForAllUsers: completed for ' . count($outMap) . ' users');
            return $outMap;
        } catch (\Throwable $e) {
            logger()->error('GenerateRecommendations::runForAllUsers exception: ' . $e->getMessage());
            return null;
        }
    }
}
