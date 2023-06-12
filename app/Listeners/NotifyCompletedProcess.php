<?php

namespace App\Listeners;

use App\Events\ProcessCompleted;
use App\Models\User;
use App\Notifications\NewCompletedProcess;
use App\Notifications\YourProcessCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class NotifyCompletedProcess
{
    public function __construct()
    {
        //
    }

    public function handle(ProcessCompleted $event): void
    {
        $process = $event->process;
        $user = $event->user;

        $username = $user->name;
        $branch = $process->branch?->name;
        $taskName = $process->task->name;
        $taskCode = $process->task->code;

        Log::info("$username $branch filiali uchun topshiriq $taskName ($taskCode) ijrosini yakunladi", [
            'user' => $user,
            'process' => $process
        ]);

        $moderators = User::where('department_id', $process->department_id)->get();
        $executors = User::where('branch_id', $process->branch_id)->get();

        if (count($moderators)) {
            Notification::send($moderators, new NewCompletedProcess($process, $username));

            Log::info("Ko'rik uchun $branch filialidan qabul qilingan topshiriq haqida bildirishnoma jo'natildi", [
                'users' => $moderators->pluck(['id', 'name'])
            ]);
        }

        if (count($executors)) {
            Notification::send($executors, new YourProcessCompleted($process, $username));
        }
    }
}
