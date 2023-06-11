<?php

namespace App\Listeners;

use App\Events\TaskExpired;
use App\Helpers\TaskStatusHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleExpiredTask
{

    public function __construct()
    {
        //
    }

    public function handle(TaskExpired $event): void
    {
        $task = $event->task;

        if (!in_array($task->status, [TaskStatusHelper::STATUS_EXPIRED, TaskStatusHelper::STATUS_CLOSED])) {
            $task->status = TaskStatusHelper::STATUS_EXPIRED;
            $task->updated_at = now();
            $task->save();
        }
    }
}
