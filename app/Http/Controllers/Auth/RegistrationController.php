<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\StoreDataRegisterRequest;

class RegistrationController extends Controller
{
    public function index(): View
    {
        return view('pages.auth.register');
    }

    public function register(StoreDataRegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $user->assignRole('user');

        event(new Registered($user));

        Auth::login($user);

        return to_route('verification.notice');
    }
}