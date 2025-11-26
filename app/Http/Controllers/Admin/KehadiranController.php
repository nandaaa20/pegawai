<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        $kehadiran = Kehadiran::with('pegawai')
            ->where('tanggal', $tanggal)
            ->orderBy('pegawai_id')
            ->get();

        return view('admin.kehadiran.index', compact('kehadiran', 'tanggal'));
    }

    public function create()
    {
        $pegawai = Pegawai::orderBy('nama_lengkap')->get();
        $tanggalDefault = now()->toDateString();

        return view('admin.kehadiran.create', compact('pegawai', 'tanggalDefault'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'tanggal'    => 'required|date',
            'status'     => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string',
        ]);

        Kehadiran::updateOrCreate(
            [
                'pegawai_id' => $request->pegawai_id,
                'tanggal'    => $request->tanggal,
            ],
            [
                'status'     => $request->status,
                'keterangan' => $request->keterangan,
            ]
        );

        return redirect()
            ->route('admin.kehadiran.index', ['tanggal' => $request->tanggal])
            ->with('success', 'Data kehadiran berhasil disimpan.');
    }
}
