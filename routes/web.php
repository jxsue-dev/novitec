<?php

use Illuminate\Support\Facades\Route;
use App\Models\Setting;
use App\Models\Branch;
use App\Models\SocialLink;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\SettingController;

Route::get('/', function () {
    $branches = Branch::where('active', true)->orderBy('order')->get();
    $socials = SocialLink::where('active', true)->orderBy('order')->get();
    $settings = Setting::pluck('value', 'key');
    return view('welcome', compact('branches', 'socials', 'settings'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.users');
    Route::get('/sucursales', [BranchController::class, 'index'])->name('admin.branches');
    Route::get('/redes', [SocialLinkController::class, 'index'])->name('admin.socials');
    Route::get('/configuracion', [SettingController::class, 'index'])->name('admin.settings');
});

require __DIR__.'/auth.php';
