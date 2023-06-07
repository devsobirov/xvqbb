<?php

namespace App\Http\Controllers\Branch;

use App\Events\ProcessCompleted;
use App\Helpers\ProcessStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Process;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcessController extends Controller
{
    public function index()
    {
        $paginated = Process::select()
            ->where('branch_id', auth()->user()->branch_id)
            ->whereNot('status', ProcessStatusHelper::PENDING)
            ->with('task', 'department')
            ->latest()
            ->paginate();

        return view('branch.tasks.index', compact('paginated'));
    }

    public function show(Process $process)
    {
        abort_if($process->branch_id !== auth()->user()->branch_id, 403);
        $this->processTask($process);
        $task = $process->task;
        $files = $task->files;
        return view('branch.tasks.show', compact('process', 'task', 'files'));
    }

    public function complete(Process $process)
    {
        if (!count($process->files) || !$process->editable()) {
            return redirect()->back()->with('msg', 'Topshiriqni joriy holatda yakulash mumkin emas!');
        }

        $process->completed_at = now();
        $process->status = ProcessStatusHelper::COMPLETED;
        $process->save();

        ProcessCompleted::dispatch($process, auth()->user());
        return redirect()->back()->with('success', 'Muvaffaqiyatli bajarildi');
    }

    public function deleteFile(Process $process, File $file)
    {
        $this->checkTaskStatus($process);
        abort_if(
            $process->branch_id != auth()->user()->branch_id,
            403,
            'Faylni ochirish uchun huquqlar yetarli emas'
        );

        $path = $file->path;
        $file->delete();
        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        return $this->getFiles($process);
    }

    public function getFiles(Process $process)
    {
        return response()->json(['files' => $process->files]);
    }

    protected function processTask(Process $process)
    {
        if ($process->status == ProcessStatusHelper::PUBLISHED) {
            $process->status = ProcessStatusHelper::PROCESSED;
            $process->processed_at = now();
            $process->save();

            \Log::info(
                '(ID'.auth()->id().') '.  auth()->user()->name . ' №'. $process->task->id .
                ' '. $process->task->title . ' bilan tanishdi. (Filial: '. auth()->user()->branch->name . ')',
                [
                    'process' => $process
                ]
            );
        }
    }

    protected function checkTaskStatus(Process $process)
    {
        abort_if(
            in_array($process->status, [ProcessStatusHelper::COMPLETED, ProcessStatusHelper::APPROVED]),
            403,
            "Fayllarni faqat bajarish jarayonida o'chirish mumkin, ushbu statusda mumkin emas!"
        );
    }
}
