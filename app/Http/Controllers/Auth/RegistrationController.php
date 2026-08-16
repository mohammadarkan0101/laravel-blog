<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataRegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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

        $user->sendEmailVerificationNotification();        

        Auth::login($user);

        return to_route('verification.notice');
    }
}