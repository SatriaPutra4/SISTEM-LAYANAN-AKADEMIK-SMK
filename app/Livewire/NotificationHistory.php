<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class NotificationHistory extends Component
{
    use WithPagination;

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
    
    public function delete($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->delete();
        }
    }

    public function render()
    {
        $notifications = auth()->user()->notifications()->paginate(10);
        return view('livewire.notification-history', [
            'notifications' => $notifications
        ]);
    }
}
