<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class OtpController extends Controller
{
    public function verifyOtp(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $throttleKey = "verify-otp:{$user->id}|{$request->ip()}";

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'otp' => "Terlalu banyak percobaan. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        $otp = OtpCode::query()
            ->where('user_id', $user->id)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (! $otp || $otp->expires_at->isPast()) {
            return back()->withErrors([
                'otp' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang.',
            ]);
        }

        if (! Hash::check($request->otp, $otp->code)) {
            RateLimiter::hit($throttleKey, 60);

            return back()->withErrors([
                'otp' => 'Kode OTP yang Anda masukkan salah.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        $otp->update(['is_used' => true]);

        $user->markEmailAsVerified();

        return redirect()->intended(route('dashboard'));
    }

    public function resendOtp(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        $throttleKey = "send-otp:{$user->id}|{$request->ip()}";

        if (RateLimiter::tooManyAttempts($throttleKey, 1)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('message', "Tunggu {$seconds} detik sebelum meminta kode baru.");
        }

        RateLimiter::hit($throttleKey, 60); 

        $user->sendEmailVerificationNotification();

        return back()->with('message', 'Kode OTP baru berhasil dikirim ke email Anda.');
    }
}