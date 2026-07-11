<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuratPengajuanNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $surat;
    public $siswa;

    public function __construct($surat, $siswa)
    {
        $this->surat = $surat;
        $this->siswa = $siswa;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'info',
            'title' => '📄 Pengajuan Surat Baru',
            'message' => "Siswa {$this->siswa->user->name} mengajukan {$this->surat->jenis_surat}.",
            'url' => route('surat.admin'),
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengajuan Surat Baru')
            ->greeting('Halo Admin,')
            ->line('Terdapat pengajuan surat baru dari siswa.')
            ->line('Nama Siswa: ' . $this->siswa->user->name)
            ->line('Jenis Surat: ' . $this->surat->jenis_surat)
            ->line('Tanggal Pengajuan: ' . $this->surat->created_at->format('d-m-Y H:i'))
            ->line('Silakan melakukan pengecekan melalui sistem.')
            ->action('Lihat Pengajuan', route('surat.admin'));
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
