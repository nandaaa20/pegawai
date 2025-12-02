<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 tracking-tight">Dashboard Pegawai</h2>
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
        
        {{-- Welcome Banner --}}
        <div class="mb-8 bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl border border-gray-200 p-8">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        Selamat Datang, {{ $user->name }}
                    </h3>
                    <p class="text-sm text-gray-600 max-w-2xl mb-6">
                        Pantau status kepegawaian, pengajuan cuti, dan kehadiran Anda secara real-time melalui sistem informasi ini.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('pegawai.cuti.create') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-semibold text-sm rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Ajukan Cuti
                        </a>
                        <a href="{{ route('pegawai.cuti.index') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-gray-300 text-gray-700 font-semibold text-sm rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Riwayat Cuti
                        </a>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-3">
                    <div class="w-16 h-16 bg-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                        <span class="text-white font-bold text-xl">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="mb-8">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Ringkasan Status</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Status Cuti Disetujui --}}
                <div class="bg-white rounded-xl shadow-sm border border-emerald-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Cuti Disetujui</p>
                        <p class="text-3xl font-bold text-emerald-700">{{ $totalCutiDisetujui }}</p>
                        <p class="text-xs text-emerald-600 font-semibold mt-2">Total cuti dikabulkan</p>
                    </div>
                    <div class="h-1 bg-emerald-600"></div>
                </div>

                {{-- Status Cuti Pending --}}
                <div class="bg-white rounded-xl shadow-sm border border-amber-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Cuti Pending</p>
                        <p class="text-3xl font-bold text-amber-700">{{ $totalCutiPending }}</p>
                        <p class="text-xs text-amber-600 font-semibold mt-2">Menunggu persetujuan</p>
                    </div>
                    <div class="h-1 bg-amber-500"></div>
                </div>

                {{-- Kehadiran Bulan Ini --}}
                <div class="bg-white rounded-xl shadow-sm border border-indigo-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Kehadiran</p>
                        <p class="text-3xl font-bold text-indigo-700">{{ $totalHadirBulanIni }}</p>
                        <p class="text-xs text-indigo-600 font-semibold mt-2">Hari kerja bulan ini</p>
                    </div>
                    <div class="h-1 bg-indigo-600"></div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div>
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Menu Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <a href="{{ route('pegawai.cuti.create') }}"
                   class="flex items-center justify-between p-6 bg-white rounded-xl shadow-sm border border-emerald-200 hover:border-emerald-300 hover:shadow transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Ajukan Cuti</p>
                            <p class="text-xs text-gray-600">Buat permohonan baru</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-emerald-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a href="{{ route('pegawai.cuti.index') }}"
                   class="flex items-center justify-between p-6 bg-white rounded-xl shadow-sm border border-indigo-200 hover:border-indigo-300 hover:shadow transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Riwayat Cuti</p>
                            <p class="text-xs text-gray-600">Lihat status pengajuan</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-indigo-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center justify-between p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:border-gray-300 hover:shadow transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Pengaturan</p>
                            <p class="text-xs text-gray-600">Profil & password</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
