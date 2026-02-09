<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Illuminate\Http\Request;

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

        if ($request->status === 'disetujui' && $cuti->pegawai) {
            $sisaCuti = $cuti->pegawai->sisa_cuti ?? 0;
            if ($sisaCuti < $cuti->jumlah_hari) {
                return redirect()
                    ->route('admin.cuti.show', $cuti)
                    ->with('error', 'Sisa cuti pegawai tidak mencukupi untuk menyetujui pengajuan ini.');
            }

            $cuti->pegawai->update([
                'sisa_cuti' => $sisaCuti - $cuti->jumlah_hari,
            ]);
        }

        $cuti->update([
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()
            ->route('admin.cuti.show', $cuti)
            ->with('success', 'Status pengajuan cuti berhasil diperbarui.');
    }

}
