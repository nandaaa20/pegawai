<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('user')->paginate(10);
        return view('admin.pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'              => 'required|string|max:50|unique:pegawai,nip|unique:users,nip',
            'nama_lengkap'     => 'required|string|max:150',
            'jabatan'          => 'nullable|string|max:100',
            'departemen'       => 'nullable|string|max:100',
            'jenis_kelamin'    => 'nullable|in:L,P',
            'tanggal_lahir'    => 'nullable|date',
            'no_telepon'       => 'nullable|string|max:20',
            'alamat'           => 'nullable|string',
            'tanggal_masuk'    => 'nullable|date',
            'status_kepegawaian'=> 'nullable|in:aktif,nonaktif,kontrak',
        ]);

        // Password awal (kebijakan: sama untuk semua pegawai baru)
        $passwordAwal = 'pegawai123';

        // 1. Buat akun user (login)
        $user = User::create([
            'nip'      => $request->nip,
            'name'     => $request->nama_lengkap,
            'email'    => null,
            'password' => Hash::make($passwordAwal),
            'role'     => 'pegawai',
        ]);

        // 2. Buat data pegawai
        Pegawai::create([
            'user_id'          => $user->id,
            'nip'              => $request->nip,
            'nama_lengkap'     => $request->nama_lengkap,
            'jabatan'          => $request->jabatan,
            'departemen'       => $request->departemen,
            'jenis_kelamin'    => $request->jenis_kelamin,
            'tanggal_lahir'    => $request->tanggal_lahir,
            'no_telepon'       => $request->no_telepon,
            'alamat'           => $request->alamat,
            'tanggal_masuk'    => $request->tanggal_masuk,
            'status_kepegawaian'=> $request->status_kepegawaian ?? 'aktif',
        ]);

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai dan akun login berhasil dibuat. Password awal: ' . $passwordAwal);
    }

    public function show(Pegawai $pegawai)
    {
        $pegawai->load('user');
        return view('admin.pegawai.show', compact('pegawai'));
    }

    public function edit(Pegawai $pegawai)
    {
        $pegawai->load('user');
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nip'              => 'required|string|max:50|unique:pegawai,nip,' . $pegawai->id . '|unique:users,nip,' . $pegawai->user_id,
            'nama_lengkap'     => 'required|string|max:150',
            'jabatan'          => 'nullable|string|max:100',
            'departemen'       => 'nullable|string|max:100',
            'jenis_kelamin'    => 'nullable|in:L,P',
            'tanggal_lahir'    => 'nullable|date',
            'no_telepon'       => 'nullable|string|max:20',
            'alamat'           => 'nullable|string',
            'tanggal_masuk'    => 'nullable|date',
            'status_kepegawaian'=> 'nullable|in:aktif,nonaktif,kontrak',
        ]);

        // Update user
        if ($pegawai->user) {
            $pegawai->user->update([
                'nip'  => $request->nip,
                'name' => $request->nama_lengkap,
            ]);
        }

        // Update pegawai
        $pegawai->update([
            'nip'              => $request->nip,
            'nama_lengkap'     => $request->nama_lengkap,
            'jabatan'          => $request->jabatan,
            'departemen'       => $request->departemen,
            'jenis_kelamin'    => $request->jenis_kelamin,
            'tanggal_lahir'    => $request->tanggal_lahir,
            'no_telepon'       => $request->no_telepon,
            'alamat'           => $request->alamat,
            'tanggal_masuk'    => $request->tanggal_masuk,
            'status_kepegawaian'=> $request->status_kepegawaian ?? $pegawai->status_kepegawaian,
        ]);

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        // Hapus user, data pegawai akan otomatis terhapus (onDelete cascade)
        if ($pegawai->user) {
            $pegawai->user->delete();
        } else {
            $pegawai->delete();
        }

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai dan akun login berhasil dihapus.');
    }
}
