<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class OtpController extends Controller
{
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = $request->user();
        
        $throttleKey = 'verify-otp:' . $user->id;
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'otp' => "Terlalu banyak percobaan salah. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        if (! $user->otp_expires_at || now()->isAfter($user->otp_expires_at)) {
            return back()->withErrors([
                'otp' => 'Kode OTP sudah kedaluwarsa. Silakan klik kirim ulang.',
            ]);
        }

        if (! Hash::check($request->otp, $user->otp)) {
            RateLimiter::hit($throttleKey, 60); 
            
            return back()->withErrors([
                'otp' => 'Kode OTP yang Anda masukkan salah.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        $user->markEmailAsVerified();
        $user->forceFill([
            'otp' => null,
            'otp_expires_at' => null,
        ])->save();

        return to_route('dashboard')->with('success', 'Email Anda berhasil diverifikasi!');
    }

    public function resendOtp(Request $request): RedirectResponse
    {
        $user = $request->user();

        $throttleKey = 'send-otp:' . $user->id;
        if (RateLimiter::tooManyAttempts($throttleKey, 1)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('message', "Tunggu {$seconds} detik sebelum meminta kode baru.");
        }

        RateLimiter::hit($throttleKey, 60); 

        $user->sendEmailVerificationNotification();

        return back()->with('message', 'Kode OTP baru berhasil dikirim ke email Anda.');
    }
}