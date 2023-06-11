<?php


namespace App\Services;


use App\Helpers\ProcessStatusHelper;
use App\Models\Process;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class HandleProcessResults
{
    public Process $process;
    public ?int $totalProcesses = null;
    public ?int $totalApprovedProcesses = null;
    protected ?bool $accomplished = null;
    protected ?int $position = null;

    public function __construct(Process $process)
    {
        $this->process = $process;
    }

    public function handle()
    {
        $this->process->update(
            $this->getResultsArray()
        );
    }

    #[ArrayShape(['score' => "float", 'position' => "int|null", 'accomplished' => "bool"])]
    public function getResultsArray(): array
    {
        return [
            'score' => $this->getScore(),
            'position' => $this->getPosition(),
            'accomplished' => $this->isAccomplished()
        ];
    }

    public function getScore(): float
    {
        $maxScore = $this->getTotalProcesses();
        $baseScore = $maxScore - $this->getTotalApprovedProcesses();
        $bonusScore = 0;
        $penaltyScore = 0;

        if ($this->isAccomplished()) {
            $bonusScore = round($maxScore * 1.3, 1);

        }

        if (in_array($this->process->status, [ProcessStatusHelper::UN_EXECUTED, ProcessStatusHelper::PUBLISHED])) {
            $penaltyScore = round($maxScore * 0.3, 1) * -1;
        } elseif ($this->process->attempts > 1) {
            $penaltyScore = $baseScore * 0.1 * ($this->process->attempts - 1);
        }

        return $baseScore + $bonusScore + $penaltyScore;
    }

    public function getPosition(): ?int
    {
        if (!is_numeric($this->position)) {
            $finished = $this->getTotalApprovedProcesses();
            $this->position = $this->process->status == ProcessStatusHelper::APPROVED
                ? $finished + 1
                : $this->getTotalProcesses();
        }

        return $this->position;
    }

    public function isAccomplished(): bool
    {
        if (!is_bool($this->accomplished)) {
            $this->accomplished = $this->process->status == ProcessStatusHelper::APPROVED && !$this->process->task->expired();
        }

        return $this->accomplished;
    }

    public function getTotalProcesses(): int
    {
        if (!$this->totalProcesses) {
            $this->totalProcesses = DB::table('processes')->where('task_id', $this->process->task_id)->count();
        }

        return $this->totalProcesses;
    }

    public function getTotalApprovedProcesses(): int
    {
        if (!$this->totalApprovedProcesses) {
            $this->totalApprovedProcesses = DB::table('processes')
                ->where('task_id', $this->process->task_id)
                ->where('status', ProcessStatusHelper::APPROVED)
                ->count();
        }

        return $this->totalApprovedProcesses;
    }
}