{{-- resources/views/pegawai/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Pegawai
        </h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- SEGMENT 1: Salam --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">
                Selamat datang, {{ $user->name }}
            </h3>
            <p class="text-sm text-gray-600">
                Anda masuk sebagai pegawai pada Sistem Informasi Kepegawaian.
                Gunakan dashboard ini untuk melihat informasi pribadi, cuti, dan kehadiran Anda.
            </p>
        </div>

        {{-- SEGMENT 2: Informasi Pegawai --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h4 class="text-md font-semibold mb-4">Informasi Pegawai</h4>

            @if($pegawai)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p><span class="font-semibold">NIP:</span> {{ $pegawai->nip }}</p>
                        <p><span class="font-semibold">Nama:</span> {{ $pegawai->nama_lengkap }}</p>
                        <p><span class="font-semibold">Jabatan:</span> {{ $pegawai->jabatan ?? '-' }}</p>
                        <p><span class="font-semibold">Departemen:</span> {{ $pegawai->departemen ?? '-' }}</p>
                    </div>
                    <div>
                        <p>
                            <span class="font-semibold">Status Kepegawaian:</span>
                            {{ ucfirst($pegawai->status_kepegawaian ?? 'aktif') }}
                        </p>
                        <p><span class="font-semibold">Tanggal Masuk:</span> {{ $pegawai->tanggal_masuk ?? '-' }}</p>
                        <p><span class="font-semibold">No. Telepon:</span> {{ $pegawai->no_telepon ?? '-' }}</p>
                        <p><span class="font-semibold">Alamat:</span> {{ $pegawai->alamat ?? '-' }}</p>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-600">
                    Data pegawai Anda belum terdaftar. Silakan hubungi admin kepegawaian.
                </p>
            @endif
        </div>

        {{-- SEGMENT 3: Ringkasan Cuti --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h4 class="text-md font-semibold mb-4">Ringkasan Cuti</h4>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Cuti Disetujui</p>
                    <p class="text-2xl font-bold mt-1">{{ $totalCutiDisetujui }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total cuti yang telah disetujui.</p>
                </div>
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Cuti Pending</p>
                    <p class="text-2xl font-bold mt-1">{{ $totalCutiPending }}</p>
                    <p class="text-xs text-gray-500 mt-1">Pengajuan cuti yang masih menunggu persetujuan.</p>
                </div>
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Informasi</p>
                    <p class="text-sm text-gray-600 mt-1">
                        Detail pengajuan dan riwayat cuti akan tersedia setelah modul cuti diimplementasikan
                        pada sprint berikutnya.
                    </p>
                </div>
            </div>
        </div>

        {{-- SEGMENT 4: Ringkasan Kehadiran --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h4 class="text-md font-semibold mb-4">Ringkasan Kehadiran</h4>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Hadir Bulan Ini</p>
                    <p class="text-2xl font-bold mt-1">{{ $totalHadirBulanIni }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        Jumlah hari hadir pada bulan berjalan.
                    </p>
                </div>
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Status Lain</p>
                    <p class="text-sm text-gray-600 mt-1">
                        Rekap izin, sakit, dan ketidakhadiran akan ditampilkan setelah modul kehadiran selesai.
                    </p>
                </div>
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Catatan</p>
                    <p class="text-sm text-gray-600 mt-1">
                        Segment ini mendukung evaluasi disiplin kehadiran dan akan terhubung ke laporan pada Sprint 4.
                    </p>
                </div>
            </div>
        </div>

        {{-- SEGMENT 5: Menu Cepat Pegawai --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h4 class="text-md font-semibold mb-4">Menu Pegawai</h4>
            <div class="flex flex-wrap gap-3">
                {{-- Route di bawah ini placeholder, nanti diganti setelah modul Sprint 3 siap --}}
                <a href="#"
                   class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700">
                    Ajukan Cuti
                </a>

                <a href="#"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                    Lihat Riwayat Cuti
                </a>

                <a href="#"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                    Lihat Kehadiran
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-700 text-white text-sm rounded-lg hover:bg-gray-800">
                    Ubah Profil / Password
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
