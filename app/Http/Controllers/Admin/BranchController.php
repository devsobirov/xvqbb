<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index()
    {
        return view('admin.branches.index', [
            'paginated' => Branch::select('id', 'name')->with('users:id,name,branch_id')->paginate(20)
        ]);
    }
}
