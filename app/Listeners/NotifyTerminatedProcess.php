<?php

namespace App\Listeners;

use App\Events\ProcessTerminated;
use App\Models\User;
use App\Notifications\YourProcessTerminated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyTerminatedProcess
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
    public function handle(ProcessTerminated $event): void
    {
        foreach (User::where('branch_id', $event->process->branch_id)->get() as $user) {
            $user->notify(new YourProcessTerminated($event->process));
        }
    }
}
