<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Get user's notifications
     */
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user()->id)
                                     ->orderBy('created_at', 'desc')
                                     ->get();

        return ResponseHelper::success($notifications, 'Notifications retrieved successfully');
    }

    /**
     * Get unread notifications
     */
    public function unread(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user()->id)
                                     ->where('is_read', false)
                                     ->orderBy('created_at', 'desc')
                                     ->get();

        return ResponseHelper::success($notifications, 'Unread notifications retrieved successfully');
    }

    /**
     * Get notification by ID
     */
    public function show(Request $request, $id)
    {
        $notification = Notification::where('user_id', $request->user()->id)
                                    ->where('id', $id)
                                    ->first();

        if (!$notification) {
            return ResponseHelper::error('Notification not found', 404);
        }

        return ResponseHelper::success($notification, 'Notification retrieved successfully');
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('user_id', $request->user()->id)
                                    ->where('id', $id)
                                    ->first();

        if (!$notification) {
            return ResponseHelper::error('Notification not found', 404);
        }

        $notification->update(['is_read' => true]);

        return ResponseHelper::success($notification, 'Notification marked as read');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $count = Notification::where('user_id', $request->user()->id)
                             ->where('is_read', false)
                             ->update(['is_read' => true]);

        return ResponseHelper::success([
            'updated_count' => $count,
        ], 'All notifications marked as read');
    }

    /**
     * Delete notification
     */
    public function destroy(Request $request, $id)
    {
        $notification = Notification::where('user_id', $request->user()->id)
                                    ->where('id', $id)
                                    ->first();

        if (!$notification) {
            return ResponseHelper::error('Notification not found', 404);
        }

        $notification->delete();

        return ResponseHelper::success(null, 'Notification deleted successfully');
    }

    /**
     * Get unread count
     */
    public function unreadCount(Request $request)
    {
        $count = Notification::where('user_id', $request->user()->id)
                             ->where('is_read', false)
                             ->count();

        return ResponseHelper::success([
            'unread_count' => $count,
        ], 'Unread count retrieved successfully');
    }

    /**
     * Create notification (Admin or system)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'url' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $notification = Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'url' => $request->url,
            'is_read' => false,
        ]);

        return ResponseHelper::success($notification, 'Notification created successfully', 201);
    }
}
