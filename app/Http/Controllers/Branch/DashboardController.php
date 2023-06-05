<?php

namespace App\Http\Controllers\Branch;

use App\Helpers\ProcessStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\Process;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $tasks = Process::select(['id', 'branch_id', 'task_id','department_id', 'status', 'completed_at', 'processed_at', 'rejected_at'])
            ->where('branch_id', auth()->user()->branch_id + 50)
            ->whereNotIn('status', [ProcessStatusHelper::PENDING, ProcessStatusHelper::COMPLETED, ProcessStatusHelper::APPROVED])
            ->with('task:id,expires_at,title', 'department:id,name')
            ->orderBy('status')->orderByDesc('id')
            ->get();

        return view('branch.dashboard', compact('tasks'));
    }
}
