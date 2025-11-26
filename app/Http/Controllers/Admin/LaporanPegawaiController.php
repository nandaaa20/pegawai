<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPegawaiController extends Controller
{
    /**
     * Halaman laporan pegawai (HTML biasa).
     */
    public function index(Request $request)
    {
        $status     = $request->get('status');      // aktif / nonaktif / kontrak / null
        $jabatan    = $request->get('jabatan');     // optional
        $departemen = $request->get('departemen');  // optional

        $query = Pegawai::query();

        if ($status) {
            $query->where('status_kepegawaian', $status);
        }

        if ($jabatan) {
            $query->where('jabatan', $jabatan);
        }

        if ($departemen) {
            $query->where('departemen', $departemen);
        }

        $pegawai = $query->orderBy('nama_lengkap')->get();

        // Untuk isi dropdown filter
        $listJabatan = Pegawai::select('jabatan')
            ->whereNotNull('jabatan')
            ->distinct()
            ->orderBy('jabatan')
            ->pluck('jabatan');

        $listDepartemen = Pegawai::select('departemen')
            ->whereNotNull('departemen')
            ->distinct()
            ->orderBy('departemen')
            ->pluck('departemen');

        return view('admin.laporan.pegawai.index', compact(
            'pegawai',
            'status',
            'jabatan',
            'departemen',
            'listJabatan',
            'listDepartemen'
        ));
    }

    /**
     * Export laporan pegawai ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $status     = $request->get('status');
        $jabatan    = $request->get('jabatan');
        $departemen = $request->get('departemen');

        $query = Pegawai::query();

        if ($status) {
            $query->where('status_kepegawaian', $status);
        }

        if ($jabatan) {
            $query->where('jabatan', $jabatan);
        }

        if ($departemen) {
            $query->where('departemen', $departemen);
        }

        $pegawai = $query->orderBy('nama_lengkap')->get();

        $pdf = Pdf::loadView('admin.laporan.pegawai.pdf', [
            'pegawai'    => $pegawai,
            'status'     => $status,
            'jabatan'    => $jabatan,
            'departemen' => $departemen,
            'printed_at' => now(),
        ])->setPaper('A4', 'portrait');

        $filename = 'laporan_pegawai_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
        // atau kalau mau langsung tampil di browser:
        // return $pdf->stream($filename);
    }
}
