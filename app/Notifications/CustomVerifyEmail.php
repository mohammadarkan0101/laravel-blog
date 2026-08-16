<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomVerifyEmail extends Notification
{
    public function __construct(
        public readonly string|int $otp
    ) {}

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verifikasi Alamat Email Anda')
            ->greeting("Halo, {$notifiable->name}!")
            ->line('Terima kasih telah mendaftar. Silakan gunakan kode OTP di bawah ini:')
            ->line('**KODE OTP ANDA:**')
            ->line('# ' . $this->otp)
            ->line('Kode ini berlaku selama 10 menit.')
            ->action('Verifikasi Sekarang', url('/verify-email'))
            ->salutation("Salam,\n" . config('app.name'));
    }
}