<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanKehadiranController extends Controller
{
    /**
     * Halaman laporan kehadiran (HTML).
     */
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('m'));   // 01-12
        $tahun = $request->get('tahun', now()->format('Y'));   // 2025
        $departemen = $request->get('departemen');             // opsional

        $query = Kehadiran::with('pegawai')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan);

        if ($departemen) {
            $query->whereHas('pegawai', function ($q) use ($departemen) {
                $q->where('departemen', $departemen);
            });
        }

        $kehadiran = $query->orderBy('tanggal')->get();

        // Rekap status
        $rekap = [
            'hadir' => (clone $query)->where('status', 'hadir')->count(),
            'izin'  => (clone $query)->where('status', 'izin')->count(),
            'sakit' => (clone $query)->where('status', 'sakit')->count(),
            'alpha' => (clone $query)->where('status', 'alpha')->count(),
        ];

        // List tahun yang tersedia (ambil dari data kehadiran)
        $listTahun = Kehadiran::selectRaw('DISTINCT YEAR(tanggal) as tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // List departemen dari relasi pegawai
        $listDepartemen = Kehadiran::with('pegawai')
            ->whereHas('pegawai', function ($q) {
                $q->whereNotNull('departemen');
            })
            ->get()
            ->pluck('pegawai.departemen')
            ->filter()
            ->unique()
            ->values();

        return view('admin.laporan.kehadiran.index', compact(
            'kehadiran',
            'bulan',
            'tahun',
            'departemen',
            'listTahun',
            'listDepartemen',
            'rekap'
        ));
    }

    /**
     * Export laporan kehadiran ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('m'));
        $tahun = $request->get('tahun', now()->format('Y'));
        $departemen = $request->get('departemen');

        $query = Kehadiran::with('pegawai')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan);

        if ($departemen) {
            $query->whereHas('pegawai', function ($q) use ($departemen) {
                $q->where('departemen', $departemen);
            });
        }

        $kehadiran = $query->orderBy('tanggal')->get();

        $rekap = [
            'hadir' => (clone $query)->where('status', 'hadir')->count(),
            'izin'  => (clone $query)->where('status', 'izin')->count(),
            'sakit' => (clone $query)->where('status', 'sakit')->count(),
            'alpha' => (clone $query)->where('status', 'alpha')->count(),
        ];

        $printedAt = now();

        $pdf = Pdf::loadView('admin.laporan.kehadiran.pdf', [
            'kehadiran'   => $kehadiran,
            'bulan'       => $bulan,
            'tahun'       => $tahun,
            'departemen'  => $departemen,
            'rekap'       => $rekap,
            'printed_at'  => $printedAt,
        ])->setPaper('A4', 'landscape');

        $filename = 'laporan_kehadiran_' . $printedAt->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
        // return $pdf->stream($filename); // kalau mau tampil langsung
    }
}
