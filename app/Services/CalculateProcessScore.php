<?php


namespace App\Services;


use App\Models\Process;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CalculateProcessScore
{
    public function __construct(public Process $process)
    {

    }

    public function handle(): ?float
    {
        $process = $this->process;

        if ($process->score) {
            Log::warning('Attempt to scoring already scored process', [
                'process' => $this->process,
            ]);
            return $process->score;
        }

        $maxScore = DB::table('processes')->where('task_id', $this->process->task_id)->count();
        $bonusScore = 0;
        if ($process->completed_at < $process->task->expires_at) {
            $bonusScore = round($maxScore * 1.3, 1);
        }

    }
}
