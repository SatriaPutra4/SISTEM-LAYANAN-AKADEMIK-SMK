<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PembayaranSppNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $pembayaran;
    public $siswa;

    public function __construct($pembayaran, $siswa)
    {
        $this->pembayaran = $pembayaran;
        $this->siswa = $siswa;
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
        return [
            'type' => 'info',
            'title' => '💰 Pembayaran SPP Baru',
            'message' => "Siswa {$this->siswa->user->name} telah mengupload bukti pembayaran SPP sebesar Rp" . number_format($this->pembayaran->nominal_bayar, 0, ',', '.'),
            'url' => route('spp.index'),
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
