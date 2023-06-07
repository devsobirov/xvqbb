<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('admin.departments.index', [
            'paginated' => Department::select('id', 'name', 'prefix')->with('users:id,name,department_id')->paginate(20)
        ]);
    }
}
