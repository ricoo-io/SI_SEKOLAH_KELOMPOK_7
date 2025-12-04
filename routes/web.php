<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\DashboardController;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
})->name('dashboar_admin');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
    // Route /dashboard akan redirect otomatis berdasarkan role
    Route::get('/dashboard', function () {
        /** @var User $user */
        $user = Auth::user();
        
        // Redirect berdasarkan role
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.admin');
        }
        
        if ($user->isGuru()) {
            return redirect()->route('dashboard.guru');
        }
        
        // Jika role tidak dikenali
        abort(403, 'Role tidak valid atau tidak memiliki akses ke dashboard.');
    })->name('dashboard');

    // Dashboard Admin - hanya admin yang bisa akses
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
            ->name('dashboard.admin');
    });

    // Dashboard Guru - hanya guru yang bisa akses
    Route::middleware(['role:guru'])->group(function () {
        Route::get('/dashboard/guru', [DashboardController::class, 'guru'])
            ->name('dashboard.guru');
    });

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::post('/toggle-theme', function () {
    $currentTheme = session('theme_mode', 'light');
    $newTheme = $currentTheme === 'dark' ? 'light' : 'dark';
    session(['theme_mode' => $newTheme]);
    
    return back();
})->name('toggle-theme');
