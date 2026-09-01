<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            if (empty($googleUser->email)) {
                return to_route('login')->with('error', 'Email Google tidak ditemukan.');
            }

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                if (empty($user->google_id)) {
                    $user->update([
                        'google_id' => $googleUser->id,
                    ]);
                }
            } else {
                $user = User::create([
                    'google_id'         => $googleUser->id,
                    'name'              => $googleUser->name,
                    'email'             => $googleUser->email,
                    'email_verified_at' => now(),
                    'password'          => Str::password(8),
                ]);

                $user->assignRole('user');
            }

            if ($user->status === false) {
                return to_route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi admin.');
            }

            Auth::login($user);

            $request->session()->regenerate();

            return redirect()->intended(route('homepage', absolute: false));

        } catch (Throwable $e) {
            Log::error('Google login failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return to_route('login')->with('error', 'Gagal login dengan Google.');
        }
    }
}