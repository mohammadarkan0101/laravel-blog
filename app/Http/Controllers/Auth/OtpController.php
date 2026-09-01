<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    public function verifyOtp(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('homepage', absolute: false));
        }

        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $throttleKey = "verify-otp:{$user->id}|{$request->ip()}";

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {

            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'otp' => "Terlalu banyak percobaan. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        $otp = OtpCode::query()
            ->where('user_id', $user->id)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (! $otp || $otp->expires_at->isPast() || ! Hash::check($request->otp, $otp->code)) {

            RateLimiter::hit($throttleKey, 60);

            $attemptsLeft = RateLimiter::remaining($throttleKey, 5);

            return back()->withErrors([
                'otp' => "Kode OTP salah atau sudah kedaluwarsa. Sisa percobaan: {$attemptsLeft}.",
            ]);
        }

        DB::transaction(function () use ($otp, $user) {
            $otp->update(['is_used' => true]);
            $user->markEmailAsVerified();
        });

        RateLimiter::clear($throttleKey);

        return redirect()->intended(route('homepage', absolute: false));
    }

    public function resendOtp(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('homepage', absolute: false));
        }

        $throttleKey = "send-otp:{$user->id}|{$request->ip()}";

        if (RateLimiter::tooManyAttempts($throttleKey, 1)) {
            
            $seconds = RateLimiter::availableIn($throttleKey);
            
            return back()->withErrors([
                'resend' => "Tunggu {$seconds} detik sebelum meminta kode baru.",
            ]);
        }

        RateLimiter::hit($throttleKey, 60);

        $user->sendEmailVerificationNotification();

        return back()->with('message', 'Kode OTP baru berhasil dikirim ke email Anda.');
    }
}