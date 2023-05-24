<?php

namespace App\Observers;

use App\Models\Task;
use Log;

class TaskObserver
{
    public function created(Task $task): void
    {
        Log::info(
            'ID: ' . auth()->id() . ' ' . auth()->user()->name . ' yangi topshiriq yaratdi: ' . $task->id . ' - ' . $task->title
        );
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
