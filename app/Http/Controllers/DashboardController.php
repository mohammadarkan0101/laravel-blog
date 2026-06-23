<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:administrator|editor']);
    }

    public function index(): View
    {
        return view('pages.admin.dashboard.index');
    }
}