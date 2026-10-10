<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::latest()->get(); 
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notif = AdminNotification::findOrFail($id);
        $notif->update(['is_read' => true]);
        return back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }

    public function destroy($id)
    {
        $notif = AdminNotification::findOrFail($id);
        $notif->delete();
        return back()->with('success', 'Notifikasi berhasil dihapus');
    }
}

