<?php

namespace App\Listeners;

use App\Events\TaskExpired;
use App\Helpers\ProcessStatusHelper;
use App\Models\Process;
use App\Models\User;
use App\Notifications\YourProcessExpiring;
use App\Notifications\YourTaskExpiring;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class NotifyExpiredTask
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(TaskExpired $event): void
    {
        $task = $event->task;
        $processes = $task->processes;

        foreach (User::where('department_id', $task->department_id)->get() as $manager) {
            $manager->notify(new YourTaskExpiring($task));
        }

        $branchIds = $processes->whereIn('status', [ProcessStatusHelper::PROCESSED, ProcessStatusHelper::PUBLISHED, ProcessStatusHelper::REJECTED])->pluck('branch_id')->toArray();
        $branchManagers = User::whereIn('branch_id', $branchIds)->get();

        if (count($branchManagers)) {
            Notification::send($branchManagers, new YourProcessExpiring($task));
        }

        $notified = $branchManagers->pluck('id', 'name');
        Log::info($task->title . " haqida muddati tugagani haqida ogohlantitsh " . count($branchManagers) . " ta filial xodimiga jo'natildi", [
            'notified' => $notified
        ]);
    }
}
