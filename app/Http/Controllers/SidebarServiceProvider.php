<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('components.layouts.app.sidebar', function ($view) {
            $user = Auth::user();

            $isAdmin = false;
            $isGuru = false;
            $guruTeachesMapel = false;
            $isWaliKelas = false;

            if ($user) {
                // Sesuai model users (kolom enum 'role')
                $isAdmin = $user->hasRole('admin');
                $isGuru  = $user->hasRole('guru');

                // Placeholder aman agar Blade tidak error
                $guruTeachesMapel = $isGuru;
                $isWaliKelas      = false;
            }

            $view->with(compact('isAdmin', 'isGuru', 'guruTeachesMapel', 'isWaliKelas'));
        });
    }
}