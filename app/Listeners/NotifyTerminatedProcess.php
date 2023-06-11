<?php

namespace App\Listeners;

use App\Events\ProcessTerminated;
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
        //
    }
}
