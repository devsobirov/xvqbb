<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select(['id', 'name', 'email', 'role','telegram_chat_id', 'branch_id', 'department_id', 'created_at'])
            ->search(request()->get('search'))->byRole(request()->get('role'))
            ->with(['branch', 'department'])
            ->orderBy('id', 'desc')->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create', [
            'branches' => Branch::getForList(),
            'departments' => Department::getForList()
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'branches' => Branch::getForList(),
            'departments' => Department::getForList()
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        Log::info("#" . auth()->id() . ' ' . auth()->user()->name . ' created new user #' . $user->id . ' ' . $user->name);

        return redirect()
            ->route('users.index')
            ->with('success', 'User successfully created!');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        Log::info("#" . auth()->id() . ' ' . auth()->user()->name . ' updated user #' . $user->id . ' ' . $user->name);

        return redirect()->back()->with('success', 'User successfully updated');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->back()
                ->withErrors('msg', 'Admin maqomidagi foydalanuvchilarni o\'chirish mumkin emas');
        }

        Log::info(auth()->user()->name . ' deleting user '. $user->name, [
            'admin' => auth()->user(),
            'user' => $user
        ]);

        $user->delete();

        return redirect()->back()->with('success', 'Muvaffaqiyatli o\'chirildi');
    }
}
