<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('role:editor'),
            new Middleware('role:administrator'),
        ];
    }

    public function index(): View
    {
        return view('pages.admin.dashboard.index');
    }
}