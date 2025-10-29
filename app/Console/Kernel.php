<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\RunRecoAll::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Run the bulk recommendations generator hourly. The scheduler itself must be
        // invoked by the system (cron / Task Scheduler) via `php artisan schedule:run`.
        $schedule->command('reco:run-all')->hourly()->appendOutputTo(storage_path('logs/reco_schedule.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        // load commands if present
        if (file_exists(app_path('Console/Commands')) ) {
            $this->load(app_path('Console/Commands'));
        }
    }
}
