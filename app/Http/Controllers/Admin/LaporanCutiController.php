<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanCutiController extends Controller
{
    /**
     * Halaman laporan cuti (HTML).
     */
    public function index(Request $request)
    {
        $status     = $request->get('status');         // pending / disetujui / ditolak / null
        $jenis      = $request->get('jenis_cuti');     // opsional
        $departemen = $request->get('departemen');     // dari relasi pegawai
        $tanggalDari  = $request->get('tanggal_dari'); // format Y-m-d
        $tanggalSampai= $request->get('tanggal_sampai');

        $query = Cuti::with('pegawai');

        if ($status) {
            $query->where('status', $status);
        }

        if ($jenis) {
            $query->where('jenis_cuti', $jenis);
        }

        if ($departemen) {
            $query->whereHas('pegawai', function ($q) use ($departemen) {
                $q->where('departemen', $departemen);
            });
        }

        if ($tanggalDari) {
            $query->whereDate('tanggal_mulai', '>=', $tanggalDari);
        }

        if ($tanggalSampai) {
            $query->whereDate('tanggal_selesai', '<=', $tanggalSampai);
        }

        $cuti = $query->orderBy('tanggal_mulai', 'desc')->get();

        // Dropdown jenis cuti
        $listJenis = Cuti::select('jenis_cuti')
            ->whereNotNull('jenis_cuti')
            ->distinct()
            ->orderBy('jenis_cuti')
            ->pluck('jenis_cuti');

        // Dropdown departemen dari relasi pegawai
        $listDepartemen = Cuti::with('pegawai')
            ->whereHas('pegawai', function ($q) {
                $q->whereNotNull('departemen');
            })
            ->get()
            ->pluck('pegawai.departemen')
            ->filter()
            ->unique()
            ->values();

        return view('admin.laporan.cuti.index', compact(
            'cuti',
            'status',
            'jenis',
            'departemen',
            'tanggalDari',
            'tanggalSampai',
            'listJenis',
            'listDepartemen'
        ));
    }

    /**
     * Export laporan cuti ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $status     = $request->get('status');
        $jenis      = $request->get('jenis_cuti');
        $departemen = $request->get('departemen');
        $tanggalDari  = $request->get('tanggal_dari');
        $tanggalSampai= $request->get('tanggal_sampai');

        $query = Cuti::with('pegawai');

        if ($status) {
            $query->where('status', $status);
        }

        if ($jenis) {
            $query->where('jenis_cuti', $jenis);
        }

        if ($departemen) {
            $query->whereHas('pegawai', function ($q) use ($departemen) {
                $q->where('departemen', $departemen);
            });
        }

        if ($tanggalDari) {
            $query->whereDate('tanggal_mulai', '>=', $tanggalDari);
        }

        if ($tanggalSampai) {
            $query->whereDate('tanggal_selesai', '<=', $tanggalSampai);
        }

        $cuti = $query->orderBy('tanggal_mulai', 'desc')->get();

        $printedAt = now();

        $pdf = Pdf::loadView('admin.laporan.cuti.pdf', [
            'cuti'         => $cuti,
            'status'       => $status,
            'jenis'        => $jenis,
            'departemen'   => $departemen,
            'tanggalDari'  => $tanggalDari,
            'tanggalSampai'=> $tanggalSampai,
            'printed_at'   => $printedAt,
        ])->setPaper('A4', 'landscape'); // landscape biar tabel panjang enak

        $filename = 'laporan_cuti_' . $printedAt->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
        // atau:
        // return $pdf->stream($filename);
    }
}
