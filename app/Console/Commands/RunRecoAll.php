<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunRecoAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reco:run-all {--now : Run synchronously and print output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run bulk recommendations generation for all users (wraps GenerateRecommendations::runForAllUsers)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting GenerateRecommendations::runForAllUsers');
        try {
            $res = \App\Jobs\GenerateRecommendations::runForAllUsers();
            if ($res === null) {
                $this->error('Generation failed or produced no output. Check storage/logs/laravel.log and storage/app/reco_debug_out_all.log');
                return 1;
            }
            $count = count($res);
            $this->info("Generation completed for {$count} users.");
            if ($this->option('now')) {
                $uids = array_keys($res);
                $shown = array_slice($uids, 0, 20);
                foreach ($shown as $u) $this->line(' - ' . $u);
                if ($count > 20) $this->line('... and ' . ($count - 20) . ' more users');
            }
            return 0;
        } catch (\Throwable $e) {
            $this->error('Exception during generation: ' . $e->getMessage());
            return 2;
        }
    }
}
