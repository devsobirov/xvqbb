<?php


namespace App\Http\Controllers;

use App\Exports\StatsExport;
use App\Helpers\ProcessStatusHelper;
use App\Models\Branch;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

abstract class BaseStatsController
{
    protected false|int $branchId = false;

    abstract public function index(Request $request);

    public function export(Request $request)
    {
        $data = $this->getStatsData($request);
        $filename = 'hisobot-'.Carbon::parse($data['from'])->format('d_M_Y').'-'.Carbon::parse($data['to'])->format('d_M_Y');

        Log::info('Generating report file - '. $filename.".xlsx", ['user' => auth()->user()]);

        return Excel::download(new StatsExport($data), $filename.'.xlsx');
    }

    protected function getStatsData(Request $request): array
    {
        $min = DB::table('processes')->min('period');
        $max = DB::table('processes')->max('period');

        $from  = $request->from ?? $min;
        $to = $request->to ?? $max;
        $d_id = $request->department_id ?? null;

        $branches = Branch::query()
            ->withSum(['processes as score' => function ($query) use ($from, $to, $d_id) {
                $query->finished()->byPeriod($from, $to)->byDepartment($d_id);
            }], 'score')
            ->withCount(['processes as total' => function ($query) use ($from, $to, $d_id) {
                $query->finished()->byPeriod($from, $to)->byDepartment($d_id);
            }])
            ->withCount(['processes as valid' => function ($query) use ($from, $to, $d_id) {
                $query->where('accomplished', true)->finished()->byPeriod($from, $to)->byDepartment($d_id);
            }])
            ->withCount(['processes as completed' => function ($query) use ($from, $to, $d_id) {
                $query->where('status', ProcessStatusHelper::APPROVED)->finished()->byPeriod($from, $to)->byDepartment($d_id);
            }])
            ->orderBy('score', 'desc')
            ->get();

        $branches->each(function ($item) {
            $item->validity = $item->total ? round(($item->valid * 100) / $item->total, 2) : 0;
        });

        $currentBranchId = $this->branchId;

        $departments = Department::select(['id', 'name'])
            ->withCount(['tasks as tasks' => function ($query) use ($from, $to) {
                $query->finished()->byPeriod($from, $to);
            }])->withCount(['processes as processes' => function ($query) use ($from, $to, $currentBranchId) {
                if ($currentBranchId) {
                    $query->where('branch_id', $currentBranchId)->finished()->byPeriod($from, $to);
                } else {
                    $query->finished()->byPeriod($from, $to);
                }
            }])
            ->orderByDesc('tasks')->get();


        $totalTasks = $d_id ? $departments->where('id', $d_id)->sum('tasks') : $departments->sum('tasks');
        $totalProcesses = $branches->sum('total');
        $totalValid = $branches->sum('valid');
        $totalCompleted = $branches->sum('completed');

        $totalValidityRate = $totalProcesses ? round($totalValid * 100/$totalProcesses, 2) : 0;
        $totalCompletedRate = $totalProcesses ? round($totalCompleted * 100/$totalProcesses, 2) : 0;

        return compact(
            'from', 'to', 'min', 'max',
            'totalTasks', 'totalProcesses', 'totalValid', 'totalCompleted',
            'totalValidityRate',  'totalCompletedRate', 'branches', 'departments'
        );
    }
}
