<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusPembayaranNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $pembayaran;
    public $status;
    public $catatan;

    public function __construct($pembayaran, $status, $catatan = null)
    {
        $this->pembayaran = $pembayaran;
        $this->status = $status;
        $this->catatan = $catatan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $type = $this->status == 'Disetujui' ? 'success' : 'error';
        $icon = $this->status == 'Disetujui' ? '✅' : '❌';
        return [
            'type' => $type,
            'title' => "$icon Pembayaran SPP {$this->status}",
            'message' => "Bukti pembayaran SPP sebesar Rp" . number_format($this->pembayaran->nominal_bayar, 0, ',', '.') . " telah {$this->status}." . ($this->catatan ? " Catatan: {$this->catatan}" : ""),
            'url' => route('siswa-role.spp'),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
