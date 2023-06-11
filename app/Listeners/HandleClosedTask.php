<?php

namespace App\Listeners;

use App\Events\ProcessTerminated;
use App\Events\TaskClosed;
use App\Helpers\ProcessStatusHelper;
use App\Helpers\TaskStatusHelper;
use App\Models\Process;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleClosedTask
{
    public function __construct()
    {
        //
    }

    public function handle(TaskClosed $event): void
    {
        $task = $event->task;

        if (!in_array($task->status, [TaskStatusHelper::STATUS_CLOSED])) {
            $task->status = TaskStatusHelper::STATUS_CLOSED;
            $task->finished_at = now();
            $task->updated_at = now();
            $task->save();
        }

        $processes = Process::where('task_id', $task->id)
            ->whereNot('status', ProcessStatusHelper::APPROVED)
            ->get();

        if (count($processes)) {
            foreach ($processes as $process) {
                ProcessTerminated::dispatch($process);
            }
        }
    }
}
