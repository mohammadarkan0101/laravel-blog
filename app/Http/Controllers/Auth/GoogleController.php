<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

            if (blank($googleUser->email)) {
                return to_route('login')->with('error', 'Email Google tidak ditemukan.');
            }

            $user = User::query()
                ->where('email', $googleUser->email)
                ->first();

            if ($user) {
                if (blank($user->google_id)) {
                    $user->update([
                        'google_id' => $googleUser->id,
                    ]);
                }
            } else {
                $user = User::create([
                    'google_id' => $googleUser->id,
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::uuid7()),
                ]);

                $user->assignRole('user');
            }

            Log::info('Google login success', [
                'user_id'   => $user->id,
                'google_id' => $googleUser->id,
            ]);

            Auth::login($user);

            return redirect()->intended(route('home'));

        } catch (Throwable $e) {
            Log::error('Google login failed', [
                'message' => $e->getMessage(),
            ]);

            return to_route('login')->with('error', 'Gagal login dengan Google.');
        }
    }
}