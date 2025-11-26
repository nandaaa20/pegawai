<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Data Kehadiran Pegawai
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>
            <a href="{{ route('admin.kehadiran.create') }}"
               class="hidden md:inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Input Kehadiran
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Alert Success --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <button type="button" onclick="this.closest('.mb-6').remove()" class="ml-auto text-green-600 hover:text-green-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Stats Cards --}}
        @php
            $totalHadir = $kehadiran->where('status', 'hadir')->count();
            $totalIzin = $kehadiran->where('status', 'izin')->count();
            $totalSakit = $kehadiran->where('status', 'sakit')->count();
            $totalAlpha = $kehadiran->where('status', 'alpha')->count();
            $totalKehadiran = $kehadiran->count();
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalKehadiran }}</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalHadir }}</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Izin</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalIzin }}</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-amber-500">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Sakit</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalSakit }}</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Alpha</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalAlpha }}</p>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            {{-- Filter Section --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Kehadiran</h3>
                        <p class="text-sm text-gray-500 mt-0.5">
                            Menampilkan {{ $kehadiran->count() }} data kehadiran
                        </p>
                    </div>

                    <form method="GET" action="{{ route('admin.kehadiran.index') }}" 
                          class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <input type="date" 
                                   name="tanggal" 
                                   value="{{ $tanggal }}" 
                                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <button type="submit"
                                class="px-4 py-2 bg-gray-700 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Tampilkan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pegawai</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($kehadiran as $index => $k)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-semibold text-sm">
                                                {{ strtoupper(substr($k->pegawai->nama_lengkap ?? '-', 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">
                                                {{ $k->pegawai->nama_lengkap ?? '-' }}
                                            </div>
                                            <div class="text-xs text-gray-500 font-mono">
                                                {{ $k->pegawai->nip ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusConfig = match(strtolower($k->status)) {
                                            'hadir' => [
                                                'class' => 'bg-green-100 text-green-800',
                                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                                            ],
                                            'izin' => [
                                                'class' => 'bg-blue-100 text-blue-800',
                                                'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                                            ],
                                            'sakit' => [
                                                'class' => 'bg-amber-100 text-amber-800',
                                                'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'
                                            ],
                                            'alpha' => [
                                                'class' => 'bg-red-100 text-red-800',
                                                'icon' => 'M6 18L18 6M6 6l12 12'
                                            ],
                                            default => [
                                                'class' => 'bg-gray-100 text-gray-800',
                                                'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                                            ]
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $statusConfig['class'] }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusConfig['icon'] }}"/>
                                        </svg>
                                        {{ ucfirst($k->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-700">
                                        {{ $k->keterangan ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                        </svg>
                                        <h4 class="text-lg font-medium text-gray-900 mb-1">Belum ada data kehadiran</h4>
                                        <p class="text-sm mb-4">Data kehadiran untuk tanggal ini belum tersedia.</p>
                                        <a href="{{ route('admin.kehadiran.create') }}"
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Input Kehadiran
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile FAB --}}
        <a href="{{ route('admin.kehadiran.create') }}"
           class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-blue-600 text-white rounded-full shadow-lg flex items-center justify-center hover:bg-blue-700 transition-colors z-50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </a>
    </div>
</x-app-layout>
