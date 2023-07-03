<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\BaseStatsController;
use Illuminate\Http\Request;

class StatsController extends BaseStatsController
{
    public function index(Request $request)
    {
        $data = $this->getStatsData($request);
        return view('head.stats.index', $data);
    }
}
