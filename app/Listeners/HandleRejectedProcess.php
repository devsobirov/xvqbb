<?php

namespace App\Listeners;

use App\Events\ProcessRejected;
use App\Helpers\ProcessStatusHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleRejectedProcess
{
    public function __construct()
    {
        //
    }

    public function handle(ProcessRejected $event): void
    {
        $process = $event->process;
        $msg = $event->msg;

        $process->status = ProcessStatusHelper::REJECTED;
        $process->reject_msg = $msg;
        $process->rejected_at = now();
        $process->save();

        \Log::info('Process rejecting completed', compact('msg', 'process'));
    }
}
