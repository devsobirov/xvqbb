<?php

namespace App\Observers;

use App\Models\Task;
use Log;

class TaskObserver
{
    public function created(Task $task): void
    {
        Log::info(
            'ID: ' . auth()->id() . ' ' . auth()->user()?->name . ' yangi topshiriq yaratdi: ' . $task->id . ' - ' . $task->title
        );
    }
}
