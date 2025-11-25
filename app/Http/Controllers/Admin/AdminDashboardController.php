<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
// use App\Models\Cuti;
// use App\Models\Kehadiran;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Segment Pegawai
        $totalPegawai       = Pegawai::count();
        $pegawaiAktif       = Pegawai::where('status_kepegawaian', 'aktif')->count();
        $pegawaiNonAktif    = Pegawai::where('status_kepegawaian', 'nonaktif')->count();
        $pegawaiKontrak     = Pegawai::where('status_kepegawaian', 'kontrak')->count();

        // Segment Cuti (nanti diisi setelah ada tabel cuti)
        $totalCutiPending   = 0; // Cuti::where('status', 'pending')->count();
        $totalCutiDisetujui = 0; // Cuti::where('status', 'disetujui')->count();

        // Segment Kehadiran (nanti diisi setelah ada tabel kehadiran)
        $hadirHariIni       = 0; // Kehadiran::where('tanggal', today())->where('status', 'hadir')->count();

        return view('admin.dashboard', compact(
            'totalPegawai',
            'pegawaiAktif',
            'pegawaiNonAktif',
            'pegawaiKontrak',
            'totalCutiPending',
            'totalCutiDisetujui',
            'hadirHariIni',
        ));
    }
}
