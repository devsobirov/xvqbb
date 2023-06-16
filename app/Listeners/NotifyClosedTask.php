<?php

namespace App\Listeners;

use App\Events\TaskClosed;
use App\Helpers\ProcessStatusHelper;
use App\Models\User;
use App\Notifications\YourProcessExpiring;
use App\Notifications\YourTaskClosed;
use App\Notifications\YourTaskExpiring;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

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

        foreach (User::where('department_id', $task->department_id)->get() as $manager) {
            $manager->notify(new YourTaskClosed($task));
        }
    }
}
