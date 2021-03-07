<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserNotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Auth::user()->notifications()->latest()->paginate();

        Auth::user()->notifications()->latest()->paginate()->markAsRead();

        if ($request->wantsJson()) {
            return $notifications;
        }

        return Inertia::render('Notification', [
            'notifications' => $notifications
        ]);
    }

    public function destroy($id)
    {
        DB::table('notifications')->where('id', $id)->delete();

        return redirect()->back();
    }
}
