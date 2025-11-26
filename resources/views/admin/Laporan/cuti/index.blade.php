<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laporan Cuti Pegawai
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm rounded-lg p-6">

            {{-- Filter --}}
            <form method="GET" action="{{ route('admin.laporan.cuti') }}"
                  class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        Periode Mulai
                    </label>
                    <input type="date" name="tanggal_dari"
                           value="{{ $tanggalDari }}"
                           class="w-full border rounded px-2 py-1 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        Periode Selesai
                    </label>
                    <input type="date" name="tanggal_sampai"
                           value="{{ $tanggalSampai }}"
                           class="w-full border rounded px-2 py-1 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        Status Cuti
                    </label>
                    <select name="status" class="w-full border rounded px-2 py-1 text-sm">
                        <option value="">Semua</option>
                        <option value="pending"    @selected($status === 'pending')>Pending</option>
                        <option value="disetujui"  @selected($status === 'disetujui')>Disetujui</option>
                        <option value="ditolak"    @selected($status === 'ditolak')>Ditolak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        Jenis Cuti
                    </label>
                    <select name="jenis_cuti" class="w-full border rounded px-2 py-1 text-sm">
                        <option value="">Semua</option>
                        @foreach($listJenis as $j)
                            <option value="{{ $j }}" @selected($jenis === $j)>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        Departemen
                    </label>
                    <select name="departemen" class="w-full border rounded px-2 py-1 text-sm">
                        <option value="">Semua</option>
                        @foreach($listDepartemen as $d)
                            <option value="{{ $d }}" @selected($departemen === $d)>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-5 flex items-end gap-2">
                    <button type="submit"
                            class="px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.laporan.cuti') }}"
                       class="px-3 py-2 border text-sm rounded hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Info & Export --}}
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm text-gray-600">
                    Jumlah pengajuan: <span class="font-semibold">{{ $cuti->count() }}</span>
                </p>

                <a href="{{ route('admin.laporan.cuti.pdf', request()->query()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm rounded hover:bg-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 11V3m0 8l-3-3m3 3l3-3M6 17h12M6 21h12"/>
                    </svg>
                    Export PDF
                </a>
            </div>

            {{-- Tabel Laporan Cuti --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 py-2 border text-left">No</th>
                            <th class="px-2 py-2 border text-left">NIP</th>
                            <th class="px-2 py-2 border text-left">Nama Pegawai</th>
                            <th class="px-2 py-2 border text-left">Departemen</th>
                            <th class="px-2 py-2 border text-left">Jenis Cuti</th>
                            <th class="px-2 py-2 border text-left">Periode</th>
                            <th class="px-2 py-2 border text-left">Lama</th>
                            <th class="px-2 py-2 border text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuti as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-2 py-1 border">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-1 border font-mono">
                                    {{ $row->pegawai->nip ?? '-' }}
                                </td>
                                <td class="px-2 py-1 border">
                                    {{ $row->pegawai->nama_lengkap ?? '-' }}
                                </td>
                                <td class="px-2 py-1 border">
                                    {{ $row->pegawai->departemen ?? '-' }}
                                </td>
                                <td class="px-2 py-1 border">
                                    {{ $row->jenis_cuti ?? '-' }}
                                </td>
                                <td class="px-2 py-1 border">
                                    @php
                                        $mulai = $row->tanggal_mulai ? \Carbon\Carbon::parse($row->tanggal_mulai)->format('d-m-Y') : '-';
                                        $selesai = $row->tanggal_selesai ? \Carbon\Carbon::parse($row->tanggal_selesai)->format('d-m-Y') : '-';
                                    @endphp
                                    {{ $mulai }} s/d {{ $selesai }}
                                </td>
                                <td class="px-2 py-1 border">
                                    @if($row->tanggal_mulai && $row->tanggal_selesai)
                                        {{ \Carbon\Carbon::parse($row->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($row->tanggal_selesai)) + 1 }} hari
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-2 py-1 border">
                                    {{ ucfirst($row->status ?? 'pending') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-2 py-3 text-center text-gray-500">
                                    Tidak ada data cuti untuk filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
