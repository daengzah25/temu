<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyRejectedNotification extends Notification
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
            ->subject('❌ Pendaftaran UMKM Perlu Diperbaiki')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Mohon maaf, pendaftaran UMKM "' . $this->company->name . '" belum dapat disetujui.')
            ->line('**Alasan:** ' . $this->company->rejection_reason)
            ->line('Anda bisa memperbaiki data dan mendaftar ulang.')
            ->action('Daftar Ulang', url('/umkm/register'))
            ->line('Jika ada pertanyaan, hubungi admin.')
            ->salutation('Salam, Tim Temu');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
