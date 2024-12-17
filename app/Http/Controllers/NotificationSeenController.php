<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Notifications\DatabaseNotification;

class NotificationSeenController extends Controller
{
    use AuthorizesRequests;
    /**
     * Handle the incoming request.
     */
    public function __invoke(DatabaseNotification $notification)
    {   # Notification Policy 
        $this->authorize('update', $notification);
        $notification->markAsRead();
        return redirect()->back()->with('success', 'Notification marked as read');
    }
}