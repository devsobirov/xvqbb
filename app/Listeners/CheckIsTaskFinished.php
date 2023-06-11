<?php

namespace App\Listeners;

use App\Events\ProcessApproved;
use App\Events\TaskClosed;
use App\Helpers\ProcessStatusHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CheckIsTaskFinished
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
    public function handle(ProcessApproved $event): void
    {
        $task = $event->process->task;
        $unFinishedProcessesExists = DB::table('processes')
            ->where('task_id', $task->id)
            ->whereNot('status', ProcessStatusHelper::APPROVED)
            ->exists();

        if (!$unFinishedProcessesExists) {
            TaskClosed::dispatch($task);
        }
    }
}
