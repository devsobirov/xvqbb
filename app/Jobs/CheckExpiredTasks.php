<?php

namespace App\Jobs;

use App\Events\TaskExpired;
use App\Helpers\TaskStatusHelper;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckExpiredTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $tasks = Task::whereIn('status', [TaskStatusHelper::STATUS_ACTIVE])
            ->whereDate('expires_at', '<=', now())
            ->get();

        if (count($tasks)) {
            foreach ($tasks as $task) {
                Log::info('Dispatched expiring event for task - № '. $task->id . '- '.$task->code, ['task' => $task]);
                TaskExpired::dispatch($task);
            }
        } else {
            Log::info('Not expired tasks found for '. date('d-M-Y H:i'));
        }
    }
}
