{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- SEGMENT: Salam --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">
                Selamat datang, {{ auth()->user()->name }} (Admin)
            </h3>
            <p class="text-sm text-gray-600">
                Ringkasan Sistem Informasi Kepegawaian berdasarkan data pegawai, cuti, dan kehadiran.
            </p>
        </div>

        {{-- SEGMENT 1: Ringkasan Pegawai --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h4 class="text-md font-semibold mb-4">Ringkasan Pegawai</h4>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Total Pegawai</p>
                    <p class="text-2xl font-bold mt-1">{{ $totalPegawai }}</p>
                </div>
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Pegawai Aktif</p>
                    <p class="text-2xl font-bold mt-1">{{ $pegawaiAktif }}</p>
                </div>
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Pegawai Nonaktif</p>
                    <p class="text-2xl font-bold mt-1">{{ $pegawaiNonAktif }}</p>
                </div>
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Pegawai Kontrak</p>
                    <p class="text-2xl font-bold mt-1">{{ $pegawaiKontrak }}</p>
                </div>
            </div>
        </div>

        {{-- SEGMENT 2: Ringkasan Cuti --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h4 class="text-md font-semibold mb-4">Ringkasan Cuti</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Pengajuan Pending</p>
                    <p class="text-2xl font-bold mt-1">{{ $totalCutiPending }}</p>
                </div>
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Cuti Disetujui</p>
                    <p class="text-2xl font-bold mt-1">{{ $totalCutiDisetujui }}</p>
                </div>
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Fitur Cuti</p>
                    <p class="mt-1 text-sm text-gray-600">
                        Data cuti akan ditampilkan setelah modul cuti diimplementasikan.
                    </p>
                </div>
            </div>
        </div>

        {{-- SEGMENT 3: Ringkasan Kehadiran --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h4 class="text-md font-semibold mb-4">Ringkasan Kehadiran</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Pegawai Hadir Hari Ini</p>
                    <p class="text-2xl font-bold mt-1">{{ $hadirHariIni }}</p>
                </div>
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Status Lain</p>
                    <p class="mt-1 text-sm text-gray-600">
                        Rekap izin / sakit akan ditambahkan pada modul kehadiran.
                    </p>
                </div>
                <div class="border rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase">Informasi</p>
                    <p class="mt-1 text-sm text-gray-600">
                        Segment ini menjadi dasar penyusunan laporan kehadiran pada Sprint berikutnya.
                    </p>
                </div>
            </div>
        </div>

        {{-- SEGMENT 4: Menu Cepat --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h4 class="text-md font-semibold mb-4">Menu Cepat</h4>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.pegawai.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                    Kelola Data Pegawai
                </a>
                <a href="#"
                   class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700">
                    Kelola Cuti (Sprint 3)
                </a>
                <a href="#"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                    Kelola Kehadiran (Sprint 3)
                </a>
                <a href="#"
                   class="inline-flex items-center px-4 py-2 bg-gray-700 text-white text-sm rounded-lg hover:bg-gray-800">
                    Laporan (Sprint 4)
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
