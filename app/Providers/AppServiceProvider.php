<?php

namespace App\Providers;

use App\Models\Branch;
use App\Models\SocialLink;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with('branches', Branch::where('active', true)->orderBy('order')->get());
            $view->with('socials', SocialLink::where('active', true)->orderBy('order')->get());
        });
    }
}
