<?php

namespace App\Listeners;

use App\Events\TaskClosed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyClosedTask
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
    public function handle(TaskClosed $event): void
    {
        $task = $event->task;
        $processes = $task->processes;

        Log::info('notifying task managers', compact('task'));
        Log::info('notifying branch managers', ['total' => count($processes)]);
    }
}
