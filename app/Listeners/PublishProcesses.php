<?php

namespace App\Listeners;

use App\Events\TaskPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class PublishProcesses
{
    public function __construct()
    {
        //
    }

    public function handle(TaskPublished $event): void
    {
        $task = $event->task;

        if ($task->published() || count($task->processes)) {
            foreach ($task->processes as $proccess) {
                /** @var App\Models\Process $process*/
                $proccess->publish();
            }

            Log::info('Yangi topshiriq tasdiqlandi', [
                'task' => $task,
                'user' => auth()->user()
            ]);
        }
    }
}
