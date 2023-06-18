<?php

namespace App\Console;

use App\Jobs\CheckClosedTasks;
use App\Jobs\CheckExpiredTasks;
use App\Jobs\ScheduleStatusLoggerJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(ScheduleStatusLoggerJob::class)->everyTwoHours();
        $schedule->job(CheckExpiredTasks::class)->dailyAt('16:50');
        $schedule->job(CheckClosedTasks::class)->dailyAt('16:55');
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
