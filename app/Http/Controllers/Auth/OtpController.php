<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function generateOtp(Request $request): RedirectResponse
    {
        $user = $this->resolveUser($request);

        if (! $user) {
            return back()->withErrors(['email' => 'User tidak ditemukan atau sesi tidak valid.']);
        }
        
        $user->sendEmailVerificationNotification();

        return back()->with('message', 'Kode OTP baru berhasil dikirim ke email Anda.');
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = $this->resolveUser($request);

        if (! $user) {
            return back()->withErrors(['otp' => 'Sesi verifikasi tidak valid.']);
        }

        if ((string) $user->otp !== (string) $request->otp) {
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

    private function resolveUser(Request $request): ?User
    {
        if (Auth::check()) {
            return $request->user();
        }

        return $request->email 
            ? User::where('email', strtolower(trim($request->email)))->first() 
            : null;
    }
}