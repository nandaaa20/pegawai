<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $pegawai = $user->pegawai; // relasi dari User ke Pegawai (hasOne)

        // Placeholder untuk statistik cuti & kehadiran (nanti diisi setelah Sprint 3)
        $totalCutiDisetujui = 0;    // contoh: Cuti::where('pegawai_id', $pegawai->id)->where('status','disetujui')->count();
        $totalCutiPending   = 0;    // ...
        $totalHadirBulanIni = 0;    // contoh: Kehadiran::...

        return view('pegawai.dashboard', compact(
            'user',
            'pegawai',
            'totalCutiDisetujui',
            'totalCutiPending',
            'totalHadirBulanIni',
        ));
    }
}
