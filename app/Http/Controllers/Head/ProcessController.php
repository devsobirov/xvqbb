<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use App\Models\Process;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessController extends Controller
{
    public function task(Task $task)
    {
        $processes = $task->processes()
            ->orderBy('status', 'desc')
            ->orderBy('completed_at')
            ->with('branch:id,name')
            ->withCount('files')
            ->get();

        return view('head.processes.task', compact('task', 'processes'));
    }
}
