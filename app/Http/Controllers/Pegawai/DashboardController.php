<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\Kehadiran;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $pegawai = $user->pegawai;

        $totalCutiDisetujui = 0;
        $totalCutiPending   = 0;
        $totalHadirBulanIni = 0;

        if ($pegawai) {
            // Ringkasan cuti pegawai ini
            $totalCutiDisetujui = Cuti::where('pegawai_id', $pegawai->id)
                ->where('status', 'disetujui')
                ->count();

            $totalCutiPending = Cuti::where('pegawai_id', $pegawai->id)
                ->where('status', 'pending')
                ->count();

            // Ringkasan kehadiran (hadir) bulan ini
            $totalHadirBulanIni = Kehadiran::where('pegawai_id', $pegawai->id)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->where('status', 'hadir')
                ->count();
        }

        return view('pegawai.dashboard', compact(
            'user',
            'pegawai',
            'totalCutiDisetujui',
            'totalCutiPending',
            'totalHadirBulanIni',
        ));
    }
}
