<?php

use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\WarrantyController;
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
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PageController;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::post('/garantias/consulta', [PageController::class, 'consultaGarantia'])->middleware('throttle:consulta')->name('garantias.consulta');
Route::get('/garantias', [PageController::class, 'garantias'])->name('garantias');
Route::get('/soporte-autorizado', [PageController::class, 'soporteAutorizado'])->name('soporte-autorizado');
Route::post('/contacto', [PageController::class, 'sendContacto'])->middleware('throttle:5,1')->name('contacto.send');
Route::get('/contacto', [PageController::class, 'contacto'])->name('contacto');
Route::get('/servicios', [PageController::class, 'servicios'])->name('servicios');
Route::get('/servicios/{service:slug}', [ServiceController::class, 'show'])->name('servicios.show');
Route::get('/conocenos', [PageController::class, 'conocenos'])->name('conocenos');
Route::get('/resenas', [PageController::class, 'resenas'])->name('resenas');
Route::post('/resenas', [ReviewController::class, 'store'])->middleware('throttle:5,1')->name('reviews.store');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/portfolio', [FaqController::class, 'portfolio'])->name('portfolio');
Route::get('/politica-de-privacidad', [PageController::class, 'privacidad'])->name('privacidad');
Route::get('/terminos-y-condiciones', [PageController::class, 'terminos'])->name('terminos');

Route::get('/warranties', [WarrantyController::class, 'index'])->name('warranties');
Route::get('/warranties/validar-factura', [WarrantyController::class, 'validarFactura'])->middleware('throttle:30,1')->name('warranties.validar');
Route::get('/warranties/buscar-producto', [WarrantyController::class, 'buscarProducto'])->middleware('throttle:30,1')->name('warranties.producto');
Route::post('/warranties/guardar', [WarrantyController::class, 'guardar'])->middleware('throttle:5,1')->name('warranties.guardar');
Route::post('/warranties/sugerencia', [WarrantyController::class, 'guardarSugerencia'])->middleware('throttle:5,1')->name('warranties.sugerencia');

Route::get('/', function () {
    $branches        = Branch::where('active', true)->orderBy('order')->get();
    $socials         = SocialLink::where('active', true)->orderBy('order')->get();
    $settings        = Setting::pluck('value', 'key');
    $featuredReviews = \App\Models\Review::where('featured', true)->latest()->take(3)->get();
    return view('welcome', compact('branches', 'socials', 'settings', 'featuredReviews'));
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

Route::prefix('recepcion')->middleware(['auth', 'receptionist'])->group(function () {
    Route::get('/', [ReceptionistController::class, 'dashboard'])->name('recepcion.dashboard');
    Route::get('/ordenes', [ReceptionistController::class, 'index'])->name('recepcion.ordenes');
    Route::get('/informe-foto/{fotoId}', [ReceptionistController::class, 'fotoInforme'])->name('recepcion.foto');
    Route::post('/ai-chat', [ReceptionistController::class, 'aiChat'])->name('recepcion.ai-chat')->middleware('throttle:30,1');
    Route::get('/cuenta', fn() => view('recepcion.cuenta'))->name('recepcion.cuenta');
    Route::patch('/cuenta', [ProfileController::class, 'update'])->name('recepcion.cuenta.update');
    Route::put('/cuenta/password', [\App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('recepcion.cuenta.password');
});

Route::prefix('chat')->middleware(['auth'])->group(function () {
    Route::get('/widget-data', [ChatController::class, 'widgetData'])->name('chat.widget.data');
    Route::post('/widget-message', [ChatController::class, 'widgetMessage'])->name('chat.widget.message');
});

Route::prefix('mi-cuenta')->middleware(['auth'])->group(function () {
    Route::get('/ordenes', [ClientOrderController::class, 'index'])->name('client.orders');
    Route::get('/ordenes/{nro_orden}', [ClientOrderController::class, 'show'])->name('client.order.show');
    Route::post('/sugerencia', [ClientOrderController::class, 'sendSugerencia'])->name('client.sugerencia.send');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/mi-cuenta', fn() => view('admin.account'))->name('admin.account');
    Route::patch('/mi-cuenta', [ProfileController::class, 'update'])->name('admin.account.update');
    Route::put('/mi-cuenta/password', [\App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('admin.account.password');

    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.users');
    Route::patch('/usuarios/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('admin.users.toggle');
    Route::patch('/usuarios/{user}/assign-branch', [UserController::class, 'assignBranch'])->name('admin.users.assign-branch');
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

    Route::get('/servicios', [ServiceController::class, 'index'])->name('admin.services');
    Route::post('/servicios', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::patch('/servicios/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/servicios/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');

    Route::get('/resenas', [AdminReviewController::class, 'index'])->name('admin.reviews');
    Route::patch('/resenas/{review}/toggle', [AdminReviewController::class, 'toggleFeatured'])->name('admin.reviews.toggle');
    Route::delete('/resenas/{review}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');
});

require __DIR__.'/auth.php';
