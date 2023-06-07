<?php

namespace App\Listeners;

use App\Events\ProcessRejected;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyRejectedProcess
{
    public function __construct()
    {
        //
    }

    public function handle(ProcessRejected $event): void
    {
        $process = $event->process;

        foreach (User::where('branch_id', $process->branch_id)->get() as $user) {
            $user->notify(new \App\Notifications\ProcessRejected($process, $event->msg));
        }
    }
}
