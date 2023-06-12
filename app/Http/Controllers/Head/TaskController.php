<?php

namespace App\Http\Controllers\Head;

use App\Events\TaskPublished;
use App\Helpers\ProcessStatusHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Head\SaveTaskRequest;
use App\Models\Branch;
use App\Models\File;
use App\Models\Process;
use App\Models\Task;
use App\Services\AssignBranchProcesses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function index()
    {
        $paginated = Task::with('department:id,name', 'user:id,name')
            ->withCount('processes as total')
            ->withCount(['processes as completed' => function ($query) {
                $query->where('status', ProcessStatusHelper::APPROVED);
            }])
            ->latest()->paginate();
        return view('head.tasks.index', compact('paginated'));
    }

    public function create()
    {
        return view('head.tasks.create', ['task' => new Task()]);
    }

    public function edit(Task $task)
    {
        $this->checkTaskStatus($task);
        $branches = Branch::getForList();
        $branchIds = $task->processes()->get()->pluck(['branch_id']);
        return view('head.tasks.edit', compact('task', 'branches', 'branchIds'));
    }

    public function save(SaveTaskRequest $request, ?Task $task)
    {
        $this->checkTaskStatus($task);
        if (!$task->exists) {
            $task = Task::create($request->validated());
            $msg = $task->title . " muvaffaqiyatli yaratildi!";
        } else {
            $task->update($request->validated());
            $msg = $task->title . " asosiy ma'lumotlari muvaffaqiyatli yangilandi!";
        }

        return redirect()->route('head.tasks.edit', ['task' => $task->id])->with('success', $msg);
    }

    public function publish(Task $task)
    {
        $this->checkTaskStatus($task);
        $task->publish();
        TaskPublished::dispatch($task);

        return redirect()->route('head.process.task', ['task' => $task->id])
            ->with('success', "Topshiriq muvaffaqiyatli tasdiqlandi!");
    }

    public function deleteFile(Task $task, File $file)
    {
        $this->checkTaskStatus($task);
        abort_if(
            !auth()->user()->isAdmin() || $file->filable_id != auth()->user()->department_id,
            403,
            'Faylni ochirish uchun huquqlar yetarli emas'
        );

        $path = $file->path;
        $file->delete();
        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        return $this->getFiles($task);
    }

    public function getFiles(Task $task)
    {
        return response()->json(['files' => $task->files]);
    }

    public function processes(Request $request, Task $task)
    {
        $request->validate([
            'branchIds' => ['required', 'array'],
            'branchIds.*' => ['nullable', 'numeric', 'exists:branches,id']
        ]);

        (new AssignBranchProcesses())->handle($task, $request->branchIds);

        if ($request->expectsJson()) {
            return response()->json([
                'branchIds' => $task->processes()->get()->pluck('id')
            ]);
        }

        return redirect()->back()->with('success', 'Filaillar muvaffaqiyatli saqlandi!');
    }

    protected function checkTaskStatus(Task $task)
    {
        if ($task->published_at) {
            return redirect()->route('head.process.task', ['task' => $task->id])
                ->with('msg', 'Tasdiqlangan topshiriqlar uchun ushbu amaliyot mumkin emas');
        }
    }
}
