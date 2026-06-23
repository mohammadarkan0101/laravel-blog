<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

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

            if (! $googleUser->email) {
                return to_route('login')->with('error', 'Email Google tidak ditemukan.');
            }

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                if (! $user->google_id) {
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
                    'password'          => Hash::make(Str::random(32)),
                ]);

                $user->assignRole('user');
            }

            Log::info('Google Login Success', [
                'user_id'   => $user->id,
                'google_id' => $googleUser->id,
            ]);

            Auth::login($user);

            return redirect()->intended(route('home'));

        } catch (Throwable $e) {
            Log::error('Google Login Failed', [
                'message' => $e->getMessage(),
            ]);

            return to_route('login')->with('error', 'Gagal login dengan Google.');
        }
    }
}