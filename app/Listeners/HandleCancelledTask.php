<?php

namespace App\Listeners;

use App\Events\TaskCancelled;
use App\Helpers\TaskStatusHelper;
use App\Models\File;
use App\Models\Process;
use App\Models\Task;
use App\Models\User;
use App\Notifications\YourProcessCancelled;
use App\Notifications\YourTaskCancelled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class HandleCancelledTask
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
    public function handle(TaskCancelled $event): void
    {
        $task = $event->task;
        Log::debug('Task cancelled - '. $task->title, [
            'user' => auth()->user(),
            'task' => $task
        ]);

        if (!in_array($task->status, [TaskStatusHelper::STATUS_CLOSED, TaskStatusHelper::STATUS_ARCHIVED])) {
            $isPublished = !$task->pending();
            $processes = $task->processes;
            $filesDir = 'files/'.$task->getUploadDirName();

            $taskName = $task->title;
            $taskId = $task->id;
            $currentUser = auth()->user();

            $processesIds = $isPublished ? $processes->pluck('id')->toArray() : [];
            $branchIds = $isPublished ? $processes->pluck('branch_id')->toArray() : [];

            $managers = User::where('department_id', $task->department_id)->get();

            Log::debug('deleting task files (models)');
            $result = $task->files()->delete();
            Log::debug('task files deleted', compact('result'));
            Log::debug('deleting task processes');
            $result = $task->processes()->delete();
            Log::debug('task processes deleted', compact('result'));
            $task->delete();
            Log::debug("task deleted: $taskId - $taskName");
            Log::debug("deleting task directory ($filesDir) with files from disk");
            $result = Storage::deleteDirectory($filesDir);
            Log::debug("task directory ($filesDir) deleted with files from disk", compact('result'));

            if (count($managers)) {
                Notification::send($managers, new YourTaskCancelled($currentUser, $taskName, $taskId));
                Log::info('deleted task notified to related department users', [
                    'managers' => $managers->pluck('id', 'name')->toArray()
                ]);
            }

            if ($isPublished) {
                Log::debug('deleting task process files');
                $result = File::where('filable_type', Process::class)->whereIn('filable_id', $processesIds)->delete();
                Log::debug('task process files deleted', compact('result'));

                $branchManagers = User::whereIn('branch_id', $branchIds)->get();
                if (count($branchManagers)) {
                    Notification::send($branchManagers, new YourProcessCancelled($taskName, $taskId));
                    Log::info('deleted process notified to related branch users', [
                        'managers' => $branchManagers->pluck('id', 'name')->toArray()
                    ]);
                }
            }
        }
    }
}
