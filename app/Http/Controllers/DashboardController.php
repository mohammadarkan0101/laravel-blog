<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('role:editor,administrator'),
        ];
    }

    public function index(): View
    {
        return view('pages.admin.dashboard.index');
    }
}