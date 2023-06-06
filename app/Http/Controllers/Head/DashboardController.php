<?php

namespace App\Http\Controllers\Head;

use App\Helpers\ProcessStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $tasks = Task::select(['id', 'user_id', 'expires_at', 'published_at', 'title'])
            ->where('department_id', auth()->user()->department_id)
            ->with('user:id,name')
            ->withCount('processes as processes')
            ->withCount(['processes as approved' => function ($query) {$query->where('status', ProcessStatusHelper::APPROVED);}])
            ->latest('expires_at')
            ->get();

        return view('head.dashboard', compact('tasks'));
    }
}
