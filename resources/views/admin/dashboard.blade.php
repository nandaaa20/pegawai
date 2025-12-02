<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 tracking-tight">Dashboard Administrator</h2>
                <p class="text-sm text-gray-500 mt-1">Sistem Informasi Manajemen Pegawai</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">
                    {{ now()->locale('id')->isoFormat('dddd') }}
                </p>
                <p class="text-sm text-gray-700 font-bold">
                    {{ now()->locale('id')->isoFormat('D MMMM YYYY') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- KPI Cards --}}
        <div class="mb-8">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Indikator Kinerja Utama</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Total Pegawai --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Pegawai</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalPegawai }}</p>
                    </div>
                    <div class="h-1 bg-slate-700"></div>
                </div>

                {{-- Pegawai Aktif --}}
                <div class="bg-white rounded-xl shadow-sm border border-emerald-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pegawai Aktif</p>
                        <p class="text-3xl font-bold text-emerald-700">{{ $pegawaiAktif }}</p>
                        <p class="text-xs text-emerald-600 font-semibold mt-2">
                            {{ $totalPegawai > 0 ? round(($pegawaiAktif / $totalPegawai) * 100, 1) : 0 }}% dari total pegawai
                        </p>
                    </div>
                    <div class="h-1 bg-emerald-600"></div>
                </div>

                {{-- Pegawai Kontrak --}}
                <div class="bg-white rounded-xl shadow-sm border border-amber-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pegawai Kontrak</p>
                        <p class="text-3xl font-bold text-amber-700">{{ $pegawaiKontrak }}</p>
                        <p class="text-xs text-amber-600 font-semibold mt-2">
                            {{ $totalPegawai > 0 ? round(($pegawaiKontrak / $totalPegawai) * 100, 1) : 0 }}% dari total pegawai
                        </p>
                    </div>
                    <div class="h-1 bg-amber-500"></div>
                </div>

                {{-- Pegawai Nonaktif --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tidak Aktif</p>
                        <p class="text-3xl font-bold text-gray-700">{{ $pegawaiNonAktif }}</p>
                        <p class="text-xs text-gray-500 font-semibold mt-2">
                            {{ $totalPegawai > 0 ? round(($pegawaiNonAktif / $totalPegawai) * 100, 1) : 0 }}% dari total pegawai
                        </p>
                    </div>
                    <div class="h-1 bg-gray-400"></div>
                </div>
            </div>
        </div>

        {{-- Operational Reports --}}
        <div>
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Laporan Operasional</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Leave Management --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Manajemen Cuti</h4>
                                <p class="text-xs text-gray-600">Ringkasan status permohonan</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <div>
                                    <p class="text-xs font-semibold text-yellow-800 uppercase">Menunggu Persetujuan</p>
                                    <p class="text-xs text-yellow-700 mt-0.5">Menunggu disetujui</p>
                                </div>
                                <p class="text-2xl font-bold text-yellow-800">{{ $cutiPending }}</p>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200">
                                <div>
                                    <p class="text-xs font-semibold text-green-800 uppercase">Disetujui</p>
                                    <p class="text-xs text-green-700 mt-0.5">Permohonan dikabulkan</p>
                                </div>
                                <p class="text-2xl font-bold text-green-800">{{ $cutiDisetujui }}</p>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                                <div>
                                    <p class="text-xs font-semibold text-red-800 uppercase">Ditolak</p>
                                    <p class="text-xs text-red-700 mt-0.5">Permohonan ditolak</p>
                                </div>
                                <p class="text-2xl font-bold text-red-800">{{ $cutiDitolak }}</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 flex items-center justify-between">
                            <p class="text-xs text-gray-600"><strong>{{ $cutiBulanIni }}</strong> permohonan bulan ini</p>
                            <a href="{{ route('admin.laporan.cuti') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Lihat Laporan →</a>
                        </div>
                    </div>
                </div>

                {{-- Attendance Report --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Laporan Kehadiran</h4>
                                <p class="text-xs text-gray-600">Status pegawai hari ini</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-4 bg-green-50 rounded-lg border border-green-200 text-center">
                                <p class="text-xs font-bold text-green-700 uppercase mb-1">Hadir</p>
                                <p class="text-2xl font-bold text-green-800">{{ $hadirHariIni }}</p>
                            </div>
                            <div class="p-4 bg-amber-50 rounded-lg border border-amber-200 text-center">
                                <p class="text-xs font-bold text-amber-700 uppercase mb-1">Izin</p>
                                <p class="text-2xl font-bold text-amber-800">{{ $izinHariIni }}</p>
                            </div>
                            <div class="p-4 bg-sky-50 rounded-lg border border-sky-200 text-center">
                                <p class="text-xs font-bold text-sky-700 uppercase mb-1">Sakit</p>
                                <p class="text-2xl font-bold text-sky-800">{{ $sakitHariIni }}</p>
                            </div>
                            <div class="p-4 bg-red-50 rounded-lg border border-red-200 text-center">
                                <p class="text-xs font-bold text-red-700 uppercase mb-1">Alpha</p>
                                <p class="text-2xl font-bold text-red-800">{{ $alphaHariIni }}</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 text-center">
                            <a href="{{ route('admin.laporan.kehadiran') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Lihat Laporan Lengkap →</a>
                        </div>
                    </div>
                </div>

                {{-- Department Distribution --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10m-6 4h6"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Distribusi Departemen</h4>
                                <p class="text-xs text-gray-600">5 departemen teratas</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @forelse($pegawaiPerDepartemen as $row)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <span class="text-sm font-semibold text-gray-800 truncate">{{ $row->departemen }}</span>
                                    <span class="text-lg font-bold text-gray-900">{{ $row->total }}</span>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-sm text-gray-500">Belum ada data departemen</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 text-center">
                            <a href="{{ route('admin.laporan.pegawai') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Lihat Laporan Lengkap →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
