<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusSuratNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $surat;
    public $status;
    public $keterangan;

    public function __construct($surat, $status, $keterangan = null)
    {
        $this->surat = $surat;
        $this->status = $status;
        $this->keterangan = $keterangan;
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
            'title' => "$icon Surat Anda telah {$this->status}",
            'message' => "Pengajuan {$this->surat->jenis_surat} Anda telah {$this->status}." . ($this->keterangan ? " Catatan: {$this->keterangan}" : ""),
            'url' => route('siswa-role.surat'),
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
