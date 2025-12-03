<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();

        // Role detection sesuai model (tanpa relasi role)
        $isAdmin = $user?->hasRole('admin') ?? false;
        $isGuru  = $user?->hasRole('guru') ?? false;

        // Flag sementara (ganti dengan query nyata saat siap)
        $guruTeachesMapel = $isGuru;   // asumsi guru mengajar mapel
        $isWaliKelas      = $isGuru;   // asumsi guru bisa jadi wali

        // Data dummy ringkasan (ganti dengan query nyata)
        $stat = [
            'siswa'             => 320,
            'kelas'             => 12,
            'mapel'             => 15,
            'nilaiBelumLengkap' => 28,
            'absensiHariIni'    => 96,
        ];

        return view('dashboard', compact(
            'isAdmin',
            'isGuru',
            'guruTeachesMapel',
            'isWaliKelas',
            'stat'
        ));
    }
}