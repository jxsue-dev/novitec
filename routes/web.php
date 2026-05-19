<?php

use Illuminate\Support\Facades\Route;
use App\Models\Setting;
use App\Models\Branch;
use App\Models\SocialLink;

Route::get('/', function () {
    $branches = Branch::where('active', true)->orderBy('order')->get();
    $socials = SocialLink::where('active', true)->orderBy('order')->get();
    $settings = Setting::pluck('value', 'key');
    return view('welcome', compact('branches', 'socials', 'settings'));
});
