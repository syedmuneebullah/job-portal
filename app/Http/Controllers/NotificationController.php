<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user
     */
    public function index(Request $request)
{
    $query = Notification::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc');

    // Filter by read status
    if ($request->has('filter')) {
        if ($request->filter === 'unread') {
            $query->where('is_read', false);
        } elseif ($request->filter === 'read') {
            $query->where('is_read', true);
        }
    }

    // Filter by type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Filter by date range
    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

    $perPage = $request->per_page ?? 20;
    $notifications = $query->paginate($perPage);

    // Get unread count
    $unreadCount = Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();

    return view('jobseeker.pages.notifications', compact('notifications', 'unreadCount'));
}

    /**
     * ✅ ADD THIS METHOD - Get latest notifications for dropdown
     */
    public function latest(Request $request)
    {
        $limit = $request->limit ?? 10;
        
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
        
        $unreadCount = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
        
        return response()->json([
            'success' => true,
            'data' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'unread_count' => $count,
        ]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
        ]);
    }

    /**
     * Get notification details
     */
    public function show($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        // Mark as read when viewed
        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        // Get related notifications (same type or from same application)
        $relatedNotifications = Notification::where('user_id', auth()->id())
            ->where('id', '!=', $notification->id)
            ->when($notification->data && isset($notification->data['application_id']), function($query) use ($notification) {
                return $query->where('data->application_id', $notification->data['application_id']);
            })
            ->orWhere('type', $notification->type)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('jobseeker.pages.notification-show', compact('notification', 'relatedNotifications'));
    }

    /**
     * Get notification details as JSON (for AJAX)
     */
    public function getNotification($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return response()->json([
            'success' => true,
            'data' => $notification
        ]);
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted',
        ]);
    }

    /**
     * Delete all read notifications
     */
    public function deleteRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', true)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'All read notifications deleted',
        ]);
    }
}