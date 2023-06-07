<?php

namespace App\Http\Controllers\Head;

use App\Events\ProcessApproved;
use App\Events\ProcessRejected;
use App\Helpers\ProcessStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\Process;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function process(Process $process)
    {
        $task = $process->task;
        $files = $process->files;

        return view('head.processes.process', compact('process', 'task', 'files'));
    }

    public function approve(Process $process)
    {
        abort_if(
            !auth()->user()->isAdmin() || auth()->user()->department_id != $process->department_id,
            403, 'Amaliyot uchun huquqlar yetarli emas'
        );

        if (!in_array($process->status, [ProcessStatusHelper::COMPLETED, ProcessStatusHelper::REJECTED])) {
            return redirect()->back()->with('Ushbu holatda jarayonni qabul qilish mumkin emas');
        }

        Log::info('Publishing process', [
            'process' => $process, 'user' => auth()->user()
        ]);
        ProcessApproved::dispatch($process);
        return redirect()->back()->with('success', 'Muvaffaqiyatli bajarildi');
    }

    public function reject(Request $request, Process $process)
    {
        abort_if(
            !auth()->user()->isAdmin() || auth()->user()->department_id != $process->department_id,
            403, 'Amaliyot uchun huquqlar yetarli emas'
        );

        if (!in_array($process->status, [ProcessStatusHelper::COMPLETED, ProcessStatusHelper::REJECTED])) {
            return redirect()->back()->with('Ushbu holatda jarayonni qabul qilish mumkin emas');
        }

        $request->validate(['reject_msg' => 'required|string']);

        Log::info('Rejecting process', [
            'process' => $process, 'user' => auth()->user()
        ]);
        ProcessRejected::dispatch($process, $request->reject_msg);
        return redirect()->back()->with('success', 'Muvaffaqiyatli bajarildi');
    }
}
