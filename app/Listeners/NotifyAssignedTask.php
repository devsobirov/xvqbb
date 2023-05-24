<?php

namespace App\Listeners;

use App\Events\TaskPublished;
use App\Models\User;
use App\Notifications\TaskPublished as NotificationsTaskPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Log;

class NotifyAssignedTask
{
    public function handle(TaskPublished $event): void
    {
        $assignedBrandIds = $event->task->processes()->get()->pluck('branch_id');
        $branchManagers = User::whereIn('branch_id', $assignedBrandIds)->get();

        if (count($branchManagers)) {
            Notification::send($branchManagers, new NotificationsTaskPublished($event->task));
        }

        $notified = $branchManagers->pluck('id', 'name');

        Log::info($event->task->title . " haqida ogohlantitsh " . count($branchManagers) . " ta filial xodimiga jo'natildi", [
            'notified' => $notified
        ]);
    }
}
