<?php

namespace App\Listeners;

use App\Events\TaskExpired;
use App\Models\Process;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotifyExpiredTask
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskExpired $event): void
    {
        $task = $event->task;
        $processes = $task->processes;

        Log::info('notifying task managers', compact('task'));
        Log::info('notifying branch managers', ['total' => count($processes)]);
    }
}
