<?php

namespace App\Listeners;

use App\Events\ProcessTerminated;
use App\Helpers\ProcessStatusHelper;
use App\Services\HandleProcessResults;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class HandleTerminatedProcess
{
    public function __construct()
    {
        //
    }

    public function handle(ProcessTerminated $event): void
    {
        $process = $event->process;

        if ($process->status != ProcessStatusHelper::APPROVED) {
            $process->status = ProcessStatusHelper::UN_EXECUTED;
            $process->save();
        }

        Log::info('Process has been terminated', compact('process'));

        Log::info('Handling process results', compact('process'));
        (new HandleProcessResults($process))->handle();
        Log::info('Process results handling', compact('process'));
    }
}
