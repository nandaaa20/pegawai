<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard Pegawai
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>
            <div class="hidden md:flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        {{-- Welcome Banner --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 to-teal-600 rounded-xl shadow-lg">
            <div class="absolute inset-0 bg-black/5"></div>
            <div class="relative p-8">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-white mb-2">
                            Selamat datang, {{ $user->name }}!
                        </h3>
                        <p class="text-emerald-50 text-sm max-w-2xl">
                            Pantau status kepegawaian, pengajuan cuti, dan kehadiran Anda.
                        </p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('pegawai.cuti.create') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-emerald-700 font-medium text-sm rounded-lg hover:bg-emerald-50 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Ajukan Cuti
                            </a>
                            <a href="{{ route('pegawai.cuti.index') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-white/30 text-white font-medium text-sm rounded-lg hover:bg-white/10 transition-colors backdrop-blur-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Riwayat Cuti
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Profile Card --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Informasi Pegawai</h4>
                </div>

                @if($pegawai)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</label>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ $pegawai->nip }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ $pegawai->nama_lengkap }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pegawai->jabatan ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Departemen</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pegawai->departemen ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</label>
                                <p class="mt-1">
                                    @php
                                        $status = strtolower($pegawai->status_kepegawaian ?? 'aktif');
                                        $statusClass = match($status) {
                                            'aktif' => 'bg-green-100 text-green-700',
                                            'nonaktif' => 'bg-gray-100 text-gray-700',
                                            'kontrak' => 'bg-amber-100 text-amber-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold {{ $statusClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $pegawai->tanggal_masuk ? \Carbon\Carbon::parse($pegawai->tanggal_masuk)->format('d M Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pegawai->no_telepon ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pegawai->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-yellow-800">Data Pegawai Belum Terdaftar</p>
                                <p class="mt-1 text-xs text-yellow-700">
                                    Silakan hubungi admin kepegawaian.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="lg:col-span-1 space-y-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900">Aksi Cepat</h4>
                    </div>
                    
                    <div class="space-y-2">
                        <a href="{{ route('pegawai.cuti.create') }}"
                           class="flex items-center gap-3 p-3 rounded-lg border-2 border-gray-100 hover:border-emerald-200 hover:bg-emerald-50 transition-all group">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Ajukan Cuti</p>
                                <p class="text-xs text-gray-500">Buat pengajuan baru</p>
                            </div>
                        </a>

                        <a href="{{ route('pegawai.cuti.index') }}"
                           class="flex items-center gap-3 p-3 rounded-lg border-2 border-gray-100 hover:border-indigo-200 hover:bg-indigo-50 transition-all group">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Riwayat Cuti</p>
                                <p class="text-xs text-gray-500">Lihat pengajuan</p>
                            </div>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-3 p-3 rounded-lg border-2 border-gray-100 hover:border-gray-200 hover:bg-gray-50 transition-all group">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-200">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Pengaturan</p>
                                <p class="text-xs text-gray-500">Profil & password</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Cuti Stats --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Status Cuti</h4>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-600">Disetujui</p>
                                <p class="text-sm text-gray-500">Total approved</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCutiDisetujui }}</p>
                            <p class="text-xs text-gray-500">pengajuan</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-amber-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-600">Pending</p>
                                <p class="text-sm text-gray-500">Menunggu review</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCutiPending }}</p>
                            <p class="text-xs text-gray-500">pengajuan</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Attendance Stats --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Kehadiran</h4>
                </div>

                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100/50 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Hadir Bulan Ini</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <p class="text-4xl font-bold text-gray-900 mb-2">{{ $totalHadirBulanIni }}</p>
                    <p class="text-sm text-gray-600">hari kerja</p>
                </div>

                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-blue-800">
                        Data kehadiran dicatat real-time oleh sistem.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
