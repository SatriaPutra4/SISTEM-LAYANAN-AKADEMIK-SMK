<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];

    public function getListeners()
    {
        if (auth()->check()) {
            return [
                "echo-private:App.Models.User.{$this->getUserId()},Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => '$refresh',
            ];
        }
        return [];
    }

    public function getUserId()
    {
        return auth()->id();
    }

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (auth()->check()) {
            $this->unreadCount = auth()->user()->unreadNotifications->count();
            $this->notifications = auth()->user()->notifications()->take(5)->get();
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
        $this->loadNotifications();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function render()
    {
        // Polling will also trigger render, which will reload notifications
        $this->loadNotifications();

        return view('livewire.layout.notification-bell');
    }
}
