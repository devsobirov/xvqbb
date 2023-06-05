<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function delete(Request $request, $id)
    {
        $notification = auth()->user()->notifications()
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->delete();
        }

        return redirect()->back()->with('success', 'Bildirishnoma o\'chrildi');
    }
}
