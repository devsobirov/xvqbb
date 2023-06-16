<?php

namespace App\Console;

use App\Jobs\CheckClosedTasks;
use App\Jobs\CheckExpiredTasks;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(CheckExpiredTasks::class)->dailyAt('07:00');
        $schedule->job(CheckClosedTasks::class)->dailyAt('07:05');
        $schedule->job(CheckClosedTasks::class)->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
