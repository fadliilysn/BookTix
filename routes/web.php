<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\EventController as AdminEventController; // ← alias
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

// ── ADMIN AUTH (public) ──────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// ── PUBLIC ──────────────────────────────────────────────────
Route::get('/', [EventController::class, 'home'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

// ── AUTH USER ────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/orders', [EventController::class, 'book'])->name('orders.store');

    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order:order_code}', [UserOrderController::class, 'show'])->name('orders.show');

    Route::get('/orders/{order}/snap-token', [PaymentController::class, 'snapToken'])
        ->name('payment.snap-token');
});

// ── WEBHOOK ──────────────────────────────────────────────────
Route::post('/webhook/midtrans', [MidtransWebhookController::class, 'handle'])
    ->name('webhook.midtrans');

Route::get('/admin', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});

// ── ADMIN ────────────────────────────────────────────────────
Route::middleware(['auth:admin', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            $events = \App\Models\Event::latest()->paginate(20);
            return view('admin.dashboardAdmin', compact('events'));
        })->name('dashboard');

        Route::resource('events', AdminEventController::class) // ← pakai alias
            -> parameters(['events' => 'event:slug']); 

        Route::resource('orders', OrderController::class)->only(['index', 'show'])->parameters(['orders' => 'order:order_code']);
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    });

require __DIR__.'/auth.php';