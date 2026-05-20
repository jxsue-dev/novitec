<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use App\Models\SocialLink;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'    => User::count(),
            'admins'   => User::where('is_admin', true)->count(),
            'branches' => Branch::count(),
            'socials'  => SocialLink::count(),
        ];

        $latestUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestUsers'));
    }
}
