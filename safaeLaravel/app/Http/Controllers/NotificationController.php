<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('notifikasi.notifikasi', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notif->update(['is_read' => 1]);

        return back();
    }
}
