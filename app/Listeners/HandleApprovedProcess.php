<?php

namespace App\Listeners;

use App\Events\ProcessApproved;
use App\Helpers\ProcessStatusHelper;
use App\Services\HandleProcessResults;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class HandleApprovedProcess
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

        $process->status =  ProcessStatusHelper::APPROVED;
        $process->approved_at = $process->approved_at ?? now();
        $process->reject_msg = null;
        $process->save();

        Log::info('Process approving completed', compact('process'));

        Log::info('Handling process results', compact('process'));
        (new HandleProcessResults($process))->handle();
        Log::info('Handled process results', compact('process'));
    }
}
