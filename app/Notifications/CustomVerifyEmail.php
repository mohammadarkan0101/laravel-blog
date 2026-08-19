<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomVerifyEmail extends Notification implements ShouldQueue
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
            ->subject('Kode OTP Verifikasi Email')
            ->greeting("Halo, {$notifiable->name}!")
            ->line('Terima kasih telah mendaftar.')
            ->line('Silakan gunakan kode OTP berikut:')
            ->line("**{$this->otp}**")
            ->line('Kode OTP berlaku selama 10 menit.')
            ->action('Verifikasi Sekarang', url('/verify-email'))
            ->salutation("Salam,\n" . config('app.name'));
    }
}