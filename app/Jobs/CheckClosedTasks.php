<?php

namespace App\Jobs;

use App\Events\TaskClosed;
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

class CheckClosedTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $tasks = Task::whereIn('status', [TaskStatusHelper::STATUS_ACTIVE, TaskStatusHelper::STATUS_EXPIRED])
            ->where('expires_at', '<=', now()->addDays(Task::CLOSE_AFTER_DAYS_SINCE_EXPIRED ?? 3))
            ->get();

        if ($total = count($tasks)) {
            Log::info("Found $total expired tasks for closing");

            foreach ($tasks as $task) {
                Log::info('Dispatched closing event for task - № '. $task->id . '- '.$task->code, ['task' => $task]);
                TaskClosed::dispatch($task);
            }
        } else {
            Log::info('Not expired tasks found for '. date('d-M-Y H:i'));
        }
    }
}
