<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan form profil user.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user'    => $request->user(),
            'pegawai' => $request->user()->pegawai ?? null, // kalau mau ditampilkan
        ]);
    }

    /**
     * Update informasi profil user.
     *
     * Catatan:
     * - Di sistem kepegawaian, nama & NIP TIDAK boleh diubah oleh pegawai sendiri.
     * - Hanya email (jika digunakan) yang boleh diubah dari halaman profil.
     * - Nama & NIP dikelola oleh admin melalui modul pegawai.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Ambil data tervalidasi
        $data = $request->validated();

        // Hanya izinkan update email
        if (array_key_exists('email', $data)) {
            // Jika email berubah, reset verifikasi
            if ($data['email'] !== $user->email) {
                $user->email = $data['email'];
                $user->email_verified_at = null;
            }
        }

        // Jangan sentuh name, nip, role, dll dari sini
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun user.
     *
     * Opsional: untuk sistem kepegawaian biasanya AKUN TIDAK BOLEH dihapus sendiri.
     * Kalau mau dinonaktifkan, bisa langsung return redirect.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Kalau tidak ingin mengizinkan pegawai menghapus akun sendiri:
        // return Redirect::route('profile.edit')->with('error', 'Penghapusan akun tidak diizinkan.');

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
