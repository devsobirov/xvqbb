<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseStatsController;
use Illuminate\Http\Request;

class StatsController extends BaseStatsController
{
    public function index(Request $request)
    {
        $this->branchId = auth()->user()->branch_id;
        $data = $this->getStatsData($request);
        $currentBranch = $data['branches']->where('id', auth()->user()->branch_id)->first();

        $data['totalProcesses'] = $currentBranch->total;
        $data['totalTasks'] = $currentBranch->score;
        $data['totalValid'] = $currentBranch->valid;
        $data['totalCompleted'] = $currentBranch->completed;

        return view('branch.stats.index', $data);
    }
}
