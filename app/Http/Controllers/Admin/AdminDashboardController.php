<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Cuti;
use App\Models\Kehadiran;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // SEGMENT PEGAWAI
        $totalPegawai    = Pegawai::count();
        $pegawaiAktif    = Pegawai::where('status_kepegawaian', 'aktif')->count();
        $pegawaiNonAktif = Pegawai::where('status_kepegawaian', 'nonaktif')->count();
        $pegawaiKontrak  = Pegawai::where('status_kepegawaian', 'kontrak')->count();

        // SEGMENT CUTI
        $totalCutiPending   = Cuti::where('status', 'pending')->count();
        $totalCutiDisetujui = Cuti::where('status', 'disetujui')->count();
        $totalCutiDitolak   = Cuti::where('status', 'ditolak')->count();

        // SEGMENT KEHADIRAN
        $hariIni     = now()->toDateString();
        $hadirHariIni = Kehadiran::where('tanggal', $hariIni)
            ->where('status', 'hadir')
            ->count();

        return view('admin.dashboard', compact(
            'totalPegawai',
            'pegawaiAktif',
            'pegawaiNonAktif',
            'pegawaiKontrak',
            'totalCutiPending',
            'totalCutiDisetujui',
            'totalCutiDitolak',
            'hadirHariIni',
        ));
    }
}
