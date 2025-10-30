<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->notifications()->orderBy('created_at', 'desc');
        if ($request->get('status') === 'unread') {
            $query->whereNull('read_at');
        }
        $perPage = (int) ($request->get('per_page') ?: 15);
        return $this->returnSuccess(200, $query->paginate($perPage));
    }

    public function unreadCount(Request $request)
    {
        $count = $request->user()->unreadNotifications()->count();
        return $this->returnSuccess(200, ['count' => $count]);
    }

    public function markAsRead(Request $request, string $id)
    {
        $notification = $request->user()->notifications()->where('id', $id)->first();
        if (!$notification) {
            return $this->returnFail(404, 'Notificación no encontrada');
        }
        $notification->markAsRead();
        return $this->returnSuccess(200, 'ok');
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return $this->returnSuccess(200, 'ok');
    }
}
