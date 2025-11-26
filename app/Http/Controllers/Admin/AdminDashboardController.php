<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Cuti;
use App\Models\Kehadiran;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // SEGMENT PEGAWAI - Cache 5 menit
        $totalPegawai = Cache::remember('dashboard.total_pegawai', 300, function() {
            return Pegawai::count();
        });
        
        $pegawaiAktif = Cache::remember('dashboard.pegawai_aktif', 300, function() {
            return Pegawai::where('status_kepegawaian', 'aktif')->count();
        });
        
        $pegawaiNonAktif = Cache::remember('dashboard.pegawai_nonaktif', 300, function() {
            return Pegawai::where('status_kepegawaian', 'nonaktif')->count();
        });
        
        $pegawaiKontrak = Cache::remember('dashboard.pegawai_kontrak', 300, function() {
            return Pegawai::where('status_kepegawaian', 'kontrak')->count();
        });

        // SEGMENT CUTI - Cache 1 menit
        $cutiPending = Cache::remember('dashboard.cuti_pending', 60, function() {
            return Cuti::where('status', 'pending')->count();
        });
        
        $cutiDisetujui = Cache::remember('dashboard.cuti_disetujui', 300, function() {
            return Cuti::where('status', 'disetujui')->count();
        });
        
        $cutiDitolak = Cache::remember('dashboard.cuti_ditolak', 300, function() {
            return Cuti::where('status', 'ditolak')->count();
        });
        
        $cutiBulanIni = Cache::remember('dashboard.cuti_bulan_ini', 300, function() {
            return Cuti::whereYear('tanggal_mulai', now()->year)
                ->whereMonth('tanggal_mulai', now()->month)
                ->count();
        });

        // SEGMENT KEHADIRAN - Cache 30 detik
        $hariIni = now()->toDateString();
        
        $hadirHariIni = Cache::remember('dashboard.hadir_' . $hariIni, 30, function() use ($hariIni) {
            return Kehadiran::where('tanggal', $hariIni)
                ->where('status', 'hadir')
                ->count();
        });
        
        $izinHariIni = Cache::remember('dashboard.izin_' . $hariIni, 30, function() use ($hariIni) {
            return Kehadiran::where('tanggal', $hariIni)
                ->where('status', 'izin')
                ->count();
        });
        
        $sakitHariIni = Cache::remember('dashboard.sakit_' . $hariIni, 30, function() use ($hariIni) {
            return Kehadiran::where('tanggal', $hariIni)
                ->where('status', 'sakit')
                ->count();
        });
        
        $alphaHariIni = Cache::remember('dashboard.alpha_' . $hariIni, 30, function() use ($hariIni) {
            return Kehadiran::where('tanggal', $hariIni)
                ->where('status', 'alpha')
                ->count();
        });

        // SEGMENT PEGAWAI PER DEPARTEMEN - Cache 5 menit
        $pegawaiPerDepartemen = Cache::remember('dashboard.pegawai_departemen', 300, function() {
            return Pegawai::select('departemen', DB::raw('COUNT(*) as total'))
                ->whereNotNull('departemen')
                ->groupBy('departemen')
                ->orderByDesc('total')
                ->limit(5)
                ->get();
        });

        return view('admin.dashboard', compact(
            'totalPegawai',
            'pegawaiAktif',
            'pegawaiNonAktif',
            'pegawaiKontrak',
            'cutiPending',
            'cutiDisetujui',
            'cutiDitolak',
            'cutiBulanIni',
            'hadirHariIni',
            'izinHariIni',
            'sakitHariIni',
            'alphaHariIni',
            'pegawaiPerDepartemen'
        ));
    }
}
