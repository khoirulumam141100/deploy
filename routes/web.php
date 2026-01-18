<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\FinanceController as AdminFinanceController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\WasteBankController as AdminWasteBankController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\EventController as WargaEventController;
use App\Http\Controllers\Warga\FinanceController as WargaFinanceController;
use App\Http\Controllers\Warga\ProfileController as WargaProfileController;
use App\Http\Controllers\Warga\WasteBankController as WargaWasteBankController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Residents (sebelumnya Members)
        Route::get('/residents/pending', [ResidentController::class, 'pending'])->name('residents.pending');
        Route::post('/residents/{user}/approve', [ResidentController::class, 'approve'])->name('residents.approve');
        Route::post('/residents/{user}/reject', [ResidentController::class, 'reject'])->name('residents.reject');
        Route::resource('residents', ResidentController::class);

        // Finance
        Route::get('/finance', [AdminFinanceController::class, 'index'])->name('finance.index');
        Route::get('/finance/report', [AdminFinanceController::class, 'report'])->name('finance.report');
        Route::get('/finance/category/{category}', [AdminFinanceController::class, 'category'])->name('finance.category');
        Route::get('/transactions/create', [AdminFinanceController::class, 'create'])->name('transactions.create');
        Route::post('/transactions', [AdminFinanceController::class, 'store'])->name('transactions.store');
        Route::get('/transactions/{transaction}/edit', [AdminFinanceController::class, 'edit'])->name('transactions.edit');
        Route::put('/transactions/{transaction}', [AdminFinanceController::class, 'update'])->name('transactions.update');
        Route::delete('/transactions/{transaction}', [AdminFinanceController::class, 'destroy'])->name('transactions.destroy');

        // Events
        Route::resource('events', AdminEventController::class);

        // Bank Sampah
        Route::prefix('waste-bank')->name('waste-bank.')->group(function () {
            Route::get('/', [AdminWasteBankController::class, 'index'])->name('index');
            Route::get('/deposits', [AdminWasteBankController::class, 'deposits'])->name('deposits');
            Route::get('/deposits/create', [AdminWasteBankController::class, 'createDeposit'])->name('deposits.create');
            Route::post('/deposits', [AdminWasteBankController::class, 'storeDeposit'])->name('deposits.store');
            Route::get('/types', [AdminWasteBankController::class, 'wasteTypes'])->name('types');
            Route::post('/types', [AdminWasteBankController::class, 'storeWasteType'])->name('types.store');
            Route::put('/types/{wasteType}', [AdminWasteBankController::class, 'updateWasteType'])->name('types.update');
            Route::delete('/types/{wasteType}', [AdminWasteBankController::class, 'destroyWasteType'])->name('types.destroy');
            Route::get('/redemptions', [AdminWasteBankController::class, 'redemptions'])->name('redemptions');
            Route::put('/redemptions/{redemption}', [AdminWasteBankController::class, 'processRedemption'])->name('redemptions.process');
        });

        // Profile
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile');
        Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');

        // Activity Logs
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });

/*
|--------------------------------------------------------------------------
| Warga Routes (sebelumnya Member)
|--------------------------------------------------------------------------
*/

Route::prefix('warga')
    ->name('warga.')
    ->middleware(['auth', 'warga', 'approved'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

        // Events (read-only)
        Route::get('/events', [WargaEventController::class, 'index'])->name('events.index');
        Route::get('/events/{event}', [WargaEventController::class, 'show'])->name('events.show');

        // Finance (read-only - transparency)
        Route::get('/finance', [WargaFinanceController::class, 'index'])->name('finance.index');
        Route::get('/finance/category/{category}', [WargaFinanceController::class, 'category'])->name('finance.category');

        // Bank Sampah
        Route::prefix('waste-bank')->name('waste-bank.')->group(function () {
            Route::get('/', [WargaWasteBankController::class, 'index'])->name('index');
            Route::get('/history', [WargaWasteBankController::class, 'history'])->name('history');
            Route::get('/redeem', [WargaWasteBankController::class, 'redeem'])->name('redeem');
            Route::post('/redeem', [WargaWasteBankController::class, 'storeRedemption'])->name('redeem.store');
        });

        // Profile
        Route::get('/profile', [WargaProfileController::class, 'edit'])->name('profile');
        Route::patch('/profile', [WargaProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [WargaProfileController::class, 'updatePassword'])->name('profile.password');
    });

/*
|--------------------------------------------------------------------------
| Legacy Redirects (untuk backward compatibility)
|--------------------------------------------------------------------------
*/

Route::prefix('member')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/dashboard', fn() => redirect()->route('warga.dashboard'));
        Route::get('/{any}', fn() => redirect()->route('warga.dashboard'))->where('any', '.*');
    });
