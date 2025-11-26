<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Pengajuan Cuti
            </h2>
            <span class="text-sm text-gray-500">
                Total: {{ $cuti->count() }} pengajuan
            </span>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Daftar Pengajuan Cuti</h3>
                    <p class="text-xs text-gray-500">Kelola pengajuan cuti pegawai dan lacak status setiap permohonan.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pegawai</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($cuti as $c)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2 align-top whitespace-nowrap">
                                    <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">
                                        {{ \Carbon\Carbon::parse($c->tanggal_mulai)->format('d M Y') }}
                                    </span>
                                    <span class="mx-1 text-gray-400">—</span>
                                    <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">
                                        {{ \Carbon\Carbon::parse($c->tanggal_selesai)->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 align-top">
                                    <div class="font-semibold text-gray-800">
                                        {{ $c->pegawai->nama_lengkap ?? '-' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        NIP: {{ $c->pegawai->nip ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-2 align-top">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-800 text-xs font-medium">
                                        {{ $c->jenis_cuti ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 align-top">
                                    @php
                                        $st = strtolower($c->status);
                                        $statusClass = match($st) {
                                            'pending' => 'bg-amber-100 text-amber-900',
                                            'disetujui' => 'bg-green-100 text-green-900',
                                            'ditolak' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusClass }}">
                                        {{ ucfirst($c->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 align-top text-center">
                                    <a href="{{ route('admin.cuti.show', $c) }}"
                                       class="inline-flex items-center text-blue-600 hover:underline font-medium transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <h4 class="text-base font-medium mb-1">Belum ada pengajuan cuti</h4>
                                        <p class="text-xs">Data pengajuan cuti belum tersedia.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
