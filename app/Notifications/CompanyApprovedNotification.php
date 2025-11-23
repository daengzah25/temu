<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyApprovedNotification extends Notification
{
    use Queueable;

    protected $company;

    public function __construct($company)
    {
        $this->company = $company;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('✅ Pendaftaran UMKM Anda Disetujui!')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Selamat! Pendaftaran UMKM "' . $this->company->name . '" telah disetujui oleh admin Temu.')
            ->line('Anda sekarang bisa:')
            ->line('✅ Mengelola produk')
            ->line('✅ Menggunakan AI Promosi')
            ->line('✅ Muncul di pencarian pengunjung')
            ->action('Masuk ke Dashboard', url('/umkm/dashboard'))
            ->line('Terima kasih telah bergabung dengan Temu!')
            ->salutation('Salam, Tim Temu');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
