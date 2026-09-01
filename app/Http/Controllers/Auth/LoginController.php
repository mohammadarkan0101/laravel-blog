<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('pages.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        return $this->redirectUserByRole($user);
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
            return redirect()->intended(route('dashboard', absolute: false));
        }

        if ($user->hasRole('user')) {
            return redirect()->intended(route('homepage', absolute: false));
        }

        return to_route('login')->with('error', 'Role tidak dikenali.');
    }
}