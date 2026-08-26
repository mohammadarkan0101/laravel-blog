<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataRegisterRequest;
use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(): View
    {
        return view('pages.auth.register');
    }

    public function register(StoreDataRegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create($validated);

        $user->assignRole('user');

        $user->otpCodes()->where('is_used', false)->update(['is_used' => true]);

        $otp = random_int(100000, 999999);

        $user->otpCodes()->create([
            'code'       => Hash::make($otp),
            'expires_at' => now()->addMinutes(10),
            'is_used'    => false,
        ]);

        $user->notify(new CustomVerifyEmail($otp));

        Auth::login($user);

        return to_route('verification.notice');
    }
}