<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard untuk Admin
     */
    public function admin()
    {
        $user = Auth::user();

        $data = [
            'user' => $user,
            'totalGuru' => User::where('role', 'guru')->count(),
            'totalSiswa' => Siswa::count(),
            'totalKelas' => 0,
            'siswaLulusanTahunIni' => 0,
        ];

        return view('dashboard_admin', $data);
    }

    /**
     * Dashboard untuk Guru
     */
    public function guru()
    {
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            abort(403, 'Data guru tidak ditemukan. Silakan hubungi administrator.');
        }

        $data = [
            'user' => $user,
            'guru' => $guru
        ];

        return view('dashboard.guru', $data);
    }
}