<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        if ($user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah.']);
        }
        
        if (! $user->otp_expires_at || now()->isAfter($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan klik kirim ulang.']);
        }
        
        $user->markEmailAsVerified();
        $user->forceFill([
            'otp' => null,
            'otp_expires_at' => null,
        ])->save();

        return redirect()->route('dashboard')->with('success', 'Email Anda berhasil diverifikasi!');
    }

    public function generateOtp(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        $user->sendEmailVerificationNotification();

        return back()->with('message', 'Kode OTP baru berhasil dikirim ke email Anda.');
    }
}