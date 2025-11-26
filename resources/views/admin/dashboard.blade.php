<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard Admin
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>
            <div class="hidden md:flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        {{-- Welcome Banner --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg overflow-hidden">
            <div class="p-8">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-white mb-2">
                            Selamat datang, {{ auth()->user()->name }}! 👋
                        </h3>
                        <p class="text-blue-100 text-sm max-w-2xl">
                            Anda masuk sebagai administrator Sistem Informasi Kepegawaian. Dashboard ini menampilkan ringkasan data pegawai, pengajuan cuti, dan kehadiran dalam satu tampilan yang mudah dipahami.
                        </p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('admin.pegawai.index') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-white text-blue-700 font-medium text-sm rounded-lg hover:bg-blue-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Kelola Pegawai
                            </a>
                            <a href="{{ route('admin.cuti.index') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 text-white font-medium text-sm rounded-lg hover:bg-blue-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Kelola Cuti
                            </a>
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <svg class="w-32 h-32 text-blue-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Ringkasan Pegawai
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Total Pegawai</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalPegawai }}</p>
                    <div class="mt-3 flex items-center text-xs text-gray-600">
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
                            </svg>
                            Semua status
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pegawai Aktif</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $pegawaiAktif }}</p>
                    <div class="mt-3 flex items-center text-xs text-green-600 font-medium">
                        <span>{{ $totalPegawai > 0 ? round(($pegawaiAktif / $totalPegawai) * 100, 1) : 0 }}% dari total</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-amber-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pegawai Kontrak</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $pegawaiKontrak }}</p>
                    <div class="mt-3 flex items-center text-xs text-amber-600 font-medium">
                        <span>{{ $totalPegawai > 0 ? round(($pegawaiKontrak / $totalPegawai) * 100, 1) : 0 }}% dari total</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-gray-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pegawai Nonaktif</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $pegawaiNonAktif }}</p>
                    <div class="mt-3 flex items-center text-xs text-gray-600 font-medium">
                        <span>{{ $totalPegawai > 0 ? round(($pegawaiNonAktif / $totalPegawai) * 100, 1) : 0 }}% dari total</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Two Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Ringkasan Cuti --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Ringkasan Cuti
                </h4>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-600">Pending</p>
                                <p class="text-sm text-gray-500">Menunggu persetujuan</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCutiPending }}</p>
                            <p class="text-xs text-gray-500">pengajuan</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-600">Disetujui</p>
                                <p class="text-sm text-gray-500">Cuti telah disetujui</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCutiDisetujui }}</p>
                            <p class="text-xs text-gray-500">cuti</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-600">Ditolak</p>
                                <p class="text-sm text-gray-500">Dengan pertimbangan</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCutiDitolak }}</p>
                            <p class="text-xs text-gray-500">pengajuan</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.cuti.index') }}"
                       class="inline-flex items-center gap-2 text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                        Lihat semua pengajuan cuti
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Ringkasan Kehadiran --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Ringkasan Kehadiran
                </h4>

                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-lg p-6 mb-4">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Pegawai Hadir Hari Ini</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMM Y') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <p class="text-4xl font-bold text-gray-900">{{ $hadirHariIni }}</p>
                        <p class="text-sm text-gray-600">/ {{ $pegawaiAktif }} pegawai aktif</p>
                    </div>
                    <div class="mt-3 bg-white rounded-lg p-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Tingkat kehadiran</span>
                            <span class="font-semibold text-indigo-600">
                                {{ $pegawaiAktif > 0 ? round(($hadirHariIni / $pegawaiAktif) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $pegawaiAktif > 0 ? ($hadirHariIni / $pegawaiAktif) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-semibold text-blue-900 mb-1">Informasi</p>
                                <p class="text-xs text-blue-800">
                                    Rekap izin, sakit, dan ketidakhadiran dapat dilihat lebih rinci pada menu kehadiran.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-semibold text-gray-900 mb-1">Catatan</p>
                                <p class="text-xs text-gray-700">
                                    Data kehadiran digunakan sebagai dasar evaluasi disiplin pegawai dan bahan laporan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.kehadiran.index') }}"
                       class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        Lihat data kehadiran lengkap
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Aksi Cepat
            </h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('admin.pegawai.index') }}"
                   class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all group">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-blue-200 transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900 text-center">Data Pegawai</p>
                </a>

                <a href="{{ route('admin.cuti.index') }}"
                   class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:border-emerald-500 hover:bg-emerald-50 transition-all group">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-emerald-200 transition-colors">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900 text-center">Pengajuan Cuti</p>
                </a>

                <a href="{{ route('admin.kehadiran.index') }}"
                   class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900 text-center">Kehadiran</p>
                </a>

                <button disabled
                        class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed opacity-60">
                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500 text-center">Laporan</p>
                    <p class="text-xs text-gray-400 mt-1">Sprint 4</p>
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
