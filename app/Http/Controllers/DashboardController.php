<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
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
            'totalGuru' => Guru::count(),
            'totalSiswa' => 0, // TODO: Tambahkan ketika model Siswa sudah ada
            'totalKelas' => 0, // TODO: Tambahkan ketika model Kelas sudah ada
            'siswaLulusanTahunIni' => 0, // TODO: Query siswa lulusan tahun ini
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
            'guru' => $guru,
            'guruType' => $guru->status,
        ];

        // Data untuk Wali Kelas
        if (in_array($guru->status, ['wali_kelas', 'keduanya'])) {
            $data['kelasYangDiampu'] = '-'; // TODO: Ambil dari tabel kelas
            $data['jumlahSiswaKelas'] = 0; // TODO: Hitung jumlah siswa
        }

        // Data untuk Guru Mapel
        if (in_array($guru->status, ['guru_mapel', 'keduanya'])) {
            $data['mataPelajaran'] = []; // TODO: Ambil dari tabel mata_pelajaran
            $data['jadwalMengajar'] = []; // TODO: Ambil dari tabel jadwal
        }

        return view('dashboard.guru', $data);
    }
}