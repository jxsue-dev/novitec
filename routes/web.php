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
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\PageController;

Route::get('/servicios', [PageController::class, 'servicios'])->name('servicios');
Route::get('/conocenos', [PageController::class, 'conocenos'])->name('conocenos');
Route::get('/', function () {
    $branches = Branch::where('active', true)->orderBy('order')->get();
    $socials = SocialLink::where('active', true)->orderBy('order')->get();
    $settings = Setting::pluck('value', 'key');
    return view('welcome', compact('branches', 'socials', 'settings'));
});

Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('client.orders');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('mi-cuenta')->middleware(['auth'])->group(function () {
    Route::get('/ordenes', [ClientOrderController::class, 'index'])->name('client.orders');
    Route::get('/ordenes/{nro_orden}', [ClientOrderController::class, 'show'])->name('client.order.show');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.users');
    Route::patch('/usuarios/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('admin.users.toggle');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/sucursales', [BranchController::class, 'index'])->name('admin.branches');
    Route::post('/sucursales', [BranchController::class, 'store'])->name('admin.branches.store');
    Route::patch('/sucursales/{branch}', [BranchController::class, 'update'])->name('admin.branches.update');
    Route::delete('/sucursales/{branch}', [BranchController::class, 'destroy'])->name('admin.branches.destroy');

    Route::get('/redes', [SocialLinkController::class, 'index'])->name('admin.socials');
    Route::post('/redes', [SocialLinkController::class, 'store'])->name('admin.socials.store');
    Route::patch('/redes/{social}', [SocialLinkController::class, 'update'])->name('admin.socials.update');
    Route::delete('/redes/{social}', [SocialLinkController::class, 'destroy'])->name('admin.socials.destroy');

    Route::get('/configuracion', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/configuracion', [SettingController::class, 'update'])->name('admin.settings.update');

    Route::get('/ordenes', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/ordenes/crear', [AdminOrderController::class, 'create'])->name('admin.orders.create');
    Route::post('/ordenes', [AdminOrderController::class, 'store'])->name('admin.orders.store');
    Route::patch('/ordenes/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/ordenes/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
});

require __DIR__.'/auth.php';
