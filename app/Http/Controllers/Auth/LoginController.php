<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function index(): RedirectResponse|View
    {
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }

        return view('pages.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return $this->redirectUserByRole(Auth::user());
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function redirectUserByRole(User $user): RedirectResponse
    {
        if ($user->hasAnyRole(['administrator', 'editor'])) {
            return redirect()->intended(route('dashboard'));
        }

        if ($user->hasRole('user')) {
            return redirect()->intended(route('home'));
        }

        return to_route('login')->with('error', 'Role tidak dikenali.');
    }
}
