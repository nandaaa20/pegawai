<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = Cuti::with('pegawai')->latest()->get();

        return view('admin.cuti.index', compact('cuti'));
    }

    public function show(Cuti $cuti)
    {
        $cuti->load('pegawai');

        return view('admin.cuti.show', compact('cuti'));
    }

    public function updateStatus(Request $request, Cuti $cuti)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_admin' => 'nullable|string|max:5000',
        ]);

        try {
            DB::transaction(function () use ($cuti, $validated) {
                // Lock the request first, then the employee, in a consistent order.
                $lockedCuti = Cuti::query()->lockForUpdate()->findOrFail($cuti->id);

                if ($lockedCuti->status !== 'pending') {
                    throw ValidationException::withMessages([
                        'status' => 'Keputusan cuti sudah ditetapkan dan tidak dapat diubah lagi.',
                    ]);
                }

                if ($validated['status'] === 'disetujui') {
                    $pegawai = Pegawai::query()->lockForUpdate()->find($lockedCuti->pegawai_id);

                    if (! $pegawai) {
                        throw ValidationException::withMessages([
                            'status' => 'Data pegawai tidak ditemukan.',
                        ]);
                    }

                    $jumlahHari = (int) $lockedCuti->jumlah_hari;
                    if ($jumlahHari <= 0) {
                        $start = Carbon::parse($lockedCuti->tanggal_mulai);
                        $end = Carbon::parse($lockedCuti->tanggal_selesai);

                        if ($end->lt($start)) {
                            throw ValidationException::withMessages([
                                'status' => 'Rentang tanggal cuti tidak valid.',
                            ]);
                        }

                        $jumlahHari = 0;
                        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                            if (! $date->isWeekend()) {
                                $jumlahHari++;
                            }
                        }
                    }

                    if ($jumlahHari <= 0 || (int) $pegawai->sisa_cuti < $jumlahHari) {
                        throw ValidationException::withMessages([
                            'status' => 'Sisa cuti pegawai tidak mencukupi atau durasi cuti tidak valid.',
                        ]);
                    }

                    $pegawai->decrement('sisa_cuti', $jumlahHari);
                    $lockedCuti->jumlah_hari = $jumlahHari;
                }

                $lockedCuti->status = $validated['status'];
                $lockedCuti->catatan_admin = $validated['catatan_admin'] ?? null;
                $lockedCuti->save();
            }, 3);
        } catch (ValidationException $exception) {
            return redirect()->route('admin.cuti.show', $cuti)
                ->with('error', collect($exception->errors())->flatten()->first());
        }

        return redirect()->route('admin.cuti.show', $cuti)
            ->with('success', 'Status pengajuan cuti berhasil diperbarui.');
    }
}
