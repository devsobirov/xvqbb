<?php

namespace App\Listeners;

use App\Events\ProcessApproved;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyApprovedProcess
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
    public function handle(ProcessApproved $event): void
    {
        $process = $event->process;

        foreach (User::where('branch_id', $process->branch_id)->get() as $user) {
            $user->notify(new \App\Notifications\ProcessApproved($process));
        }
    }
}
