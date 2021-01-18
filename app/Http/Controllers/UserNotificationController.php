<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserNotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Auth::user()->notifications()->latest()->paginate();

        Auth::user()->unreadNotifications->markAsRead();

        if ($request->wantsJson()) {
            return $notifications;
        }

        return Inertia::render('Notification', [
            'notifications' => $notifications
        ]);
    }
}
