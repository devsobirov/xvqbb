<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveDepartmentRequest;
use App\Models\Department;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('admin.departments.index', [
            'paginated' => Department::select(['id', 'name', 'prefix'])->with('users:id,name,department_id')->paginate(20)
        ]);
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(SaveDepartmentRequest $request)
    {
        $department = Department::create($request->validated());
        Log::info(auth()->user()->name . ' created new department - '. $department->name);

        return redirect()->route('departments.index')->with('success', "Muvaffaqiyatli yaratildi!");
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(SaveDepartmentRequest $request, Department $department)
    {
        $old = $department;
        $department->update($request->validated());
        Log::info(auth()->user()->name . ' updated department - '. $department->name, [
            'admin' => auth()->user(),
            'old' => $old,
            'updated' => $department
        ]);

        return redirect()->back()->with('success', "Muvaffaqiyatli yangilandi!");
    }
}
