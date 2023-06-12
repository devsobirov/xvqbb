<?php


namespace App\Services;


use App\Models\Process;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AssignBranchProcesses
{
    public function handle(Task $task, ?array $branchIds)
    {
        Log::info('Assigning processes to task', [
            'task' => $task, 'branchIds' => $branchIds
        ]);

        if ($branchIds && count($branchIds)) {
            DB::table('processes')->where('task_id', $task->id)
                ->whereNotIn('branch_id', $branchIds)
                ->delete();

            foreach ($branchIds as $branchId) {
                if (!DB::table('processes')->where('task_id', $task->id)->where('branch_id', $branchId)->exists()) {
                    Process::create(['task_id' => $task->id,
                        'department_id' => $task->department_id,
                        'branch_id' => $branchId,
                        'code' => strtoupper(Str::random(6)),
                        'period' => $task->starts_at
                    ]);
                }
            }
        } else {
            DB::table('processes')->where('task_id', $task->id)->delete();
        }
    }
}
