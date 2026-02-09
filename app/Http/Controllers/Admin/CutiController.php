<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = Cuti::with('pegawai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.cuti.index', compact('cuti'));
    }

    public function show(Cuti $cuti)
    {
        $cuti->load('pegawai');
        return view('admin.cuti.show', compact('cuti'));
    }

    public function updateStatus(Request $request, Cuti $cuti)
    {
        // Jika status sudah pernah diputuskan, jangan boleh diubah lagi
        if ($cuti->status !== 'pending') {
            return redirect()
                ->route('admin.cuti.show', $cuti)
                ->with('error', 'Keputusan cuti sudah ditetapkan dan tidak dapat diubah lagi.');
        }

        $request->validate([
            'status'        => 'required|in:disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $cuti->load('pegawai');

        $jumlahHari = $cuti->jumlah_hari;
        if (!$jumlahHari || $jumlahHari <= 0) {
            $start = Carbon::parse($cuti->tanggal_mulai);
            $end = Carbon::parse($cuti->tanggal_selesai);
            $jumlahHari = 0;
            $currentDate = $start->copy();

            while ($currentDate->lte($end)) {
                if (!$currentDate->isWeekend()) {
                    $jumlahHari++;
                }
                $currentDate->addDay();
            }
        }

        if ($request->status === 'disetujui' && $cuti->pegawai) {
            $sisaCuti = $cuti->pegawai->sisa_cuti ?? 0;
            if ($sisaCuti < $jumlahHari) {
                return redirect()
                    ->route('admin.cuti.show', $cuti)
                    ->with('error', 'Sisa cuti pegawai tidak mencukupi untuk menyetujui pengajuan ini.');
            }
        }

        DB::transaction(function () use ($request, $cuti, $jumlahHari) {
            if ($request->status === 'disetujui' && $cuti->pegawai) {
                $sisaCuti = $cuti->pegawai->sisa_cuti ?? 0;
                $cuti->pegawai->update([
                    'sisa_cuti' => $sisaCuti - $jumlahHari,
                ]);
            }

            $cuti->update([
                'status'        => $request->status,
                'catatan_admin' => $request->catatan_admin,
            ]);
        });

        return redirect()
            ->route('admin.cuti.show', $cuti)
            ->with('success', 'Status pengajuan cuti berhasil diperbarui.');
    }

}
