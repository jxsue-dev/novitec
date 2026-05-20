<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\SocialLink;
use App\Models\Setting;

class PageController extends Controller
{
    public function servicios()
    {
        $branches = Branch::where('active', true)->orderBy('order')->get();
        $socials = SocialLink::where('active', true)->orderBy('order')->get();
        $settings = Setting::pluck('value', 'key');
        return view('pages.servicios', compact('branches', 'socials', 'settings'));
    }
}
