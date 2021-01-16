<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserNotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->get();

        Auth::user()->unreadNotifications->markAsRead();

        return Inertia::render('Notification', [
            'notifications' => $notifications
        ]);
    }
}
