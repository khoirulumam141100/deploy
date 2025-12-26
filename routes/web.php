<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\FinanceController as AdminFinanceController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\EventController as MemberEventController;
use App\Http\Controllers\Member\FinanceController as MemberFinanceController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
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

        // Members
        Route::get('/members/pending', [MemberController::class, 'pending'])->name('members.pending');
        Route::post('/members/{user}/approve', [MemberController::class, 'approve'])->name('members.approve');
        Route::post('/members/{user}/reject', [MemberController::class, 'reject'])->name('members.reject');
        Route::resource('members', MemberController::class);

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

        // Profile
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile');
        Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');

        // Activity Logs
        Route::get('/activity-logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    });

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/

Route::prefix('member')
    ->name('member.')
    ->middleware(['auth', 'member', 'approved'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');

        // Events (read-only)
        Route::get('/events', [MemberEventController::class, 'index'])->name('events.index');
        Route::get('/events/{event}', [MemberEventController::class, 'show'])->name('events.show');

        // Finance (read-only)
        Route::get('/finance', [MemberFinanceController::class, 'index'])->name('finance.index');
        Route::get('/finance/category/{category}', [MemberFinanceController::class, 'category'])->name('finance.category');

        // Profile
        Route::get('/profile', [MemberProfileController::class, 'edit'])->name('profile');
        Route::patch('/profile', [MemberProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [MemberProfileController::class, 'updatePassword'])->name('profile.password');
    });
