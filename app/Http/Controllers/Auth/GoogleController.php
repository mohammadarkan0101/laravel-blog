<?php

namespace App\Http\Controllers\Auth;

use Exception;
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
        } catch (Exception $e) {
            Log::error('Google Login Failed: ' . $e->getMessage());

            return to_route('login')->with('error', 'Gagal login dengan Google.');
        }

        if (! $googleUser->email) {
            return to_route('login')->with('error', 'Email Google tidak ditemukan.');
        }

        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            if (! $user->google_id) {
                $user->update(['google_id' => $googleUser->id]);
            }
        } else {
            $user = User::create([
                'google_id' => $googleUser->id,
                'name'      => $googleUser->name,
                'email'     => $googleUser->email,
                'password'  => Hash::make(Str::random(8)),
            ]);

            $user->email_verified_at = now();
            $user->assignRole('user');
            $user->save();
        }

        Log::info('Google Login Success', [
            'user_id'   => $user->id,
            'google_id' => $googleUser->id,
        ]);

        Auth::login($user);

        return redirect()->intended(route('home'));
    }
}
