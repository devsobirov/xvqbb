<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Department;

class ProfileController extends Controller
{
    public function show()
    {
        $departments = auth()->user()->isAdmin() ? Department::getForList() : [];
        return view('auth.profile', compact('departments'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $data = $request->validated();
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        auth()->user()->update($data);

        return redirect()->back()->with('success', 'Profil ma\'lumotlari yangilandi.');
    }
}
