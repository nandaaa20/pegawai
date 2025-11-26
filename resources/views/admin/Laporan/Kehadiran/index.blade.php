<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laporan Kehadiran Pegawai
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm rounded-lg p-6">

            {{-- Filter Bulan / Tahun / Departemen --}}
            <form method="GET" action="{{ route('admin.laporan.kehadiran') }}"
                  class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        Bulan
                    </label>
                    <select name="bulan" class="w-full border rounded px-2 py-1 text-sm">
                        @for($m = 1; $m <= 12; $m++)
                            @php
                                $val = str_pad($m, 2, '0', STR_PAD_LEFT);
                                $label = \Carbon\Carbon::create(null, $m, 1)->locale('id')->translatedFormat('F');
                            @endphp
                            <option value="{{ $val }}" @selected($bulan == $val)>{{ $label }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        Tahun
                    </label>
                    <select name="tahun" class="w-full border rounded px-2 py-1 text-sm">
                        @foreach($listTahun as $t)
                            <option value="{{ $t }}" @selected($tahun == $t)>{{ $t }}</option>
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

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.laporan.kehadiran') }}"
                       class="px-3 py-2 border text-sm rounded hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Rekap Singkat --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4 text-xs">
                <div class="p-3 rounded bg-green-50 border border-green-200">
                    <div class="text-[10px] text-green-700 font-semibold uppercase">Hadir</div>
                    <div class="text-lg font-bold text-green-800">{{ $rekap['hadir'] }}</div>
                </div>
                <div class="p-3 rounded bg-amber-50 border border-amber-200">
                    <div class="text-[10px] text-amber-700 font-semibold uppercase">Izin</div>
                    <div class="text-lg font-bold text-amber-800">{{ $rekap['izin'] }}</div>
                </div>
                <div class="p-3 rounded bg-sky-50 border border-sky-200">
                    <div class="text-[10px] text-sky-700 font-semibold uppercase">Sakit</div>
                    <div class="text-lg font-bold text-sky-800">{{ $rekap['sakit'] }}</div>
                </div>
                <div class="p-3 rounded bg-red-50 border border-red-200">
                    <div class="text-[10px] text-red-700 font-semibold uppercase">Alpha</div>
                    <div class="text-lg font-bold text-red-800">{{ $rekap['alpha'] }}</div>
                </div>
            </div>

            {{-- Info & Export --}}
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm text-gray-600">
                    Total baris kehadiran: <span class="font-semibold">{{ $kehadiran->count() }}</span>
                </p>

                <a href="{{ route('admin.laporan.kehadiran.pdf', request()->query()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm rounded hover:bg-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 11V3m0 8l-3-3m3 3l3-3M6 17h12M6 21h12"/>
                    </svg>
                    Export PDF
                </a>
            </div>

            {{-- Tabel Kehadiran --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 py-2 border text-left">No</th>
                            <th class="px-2 py-2 border text-left">Tanggal</th>
                            <th class="px-2 py-2 border text-left">NIP</th>
                            <th class="px-2 py-2 border text-left">Nama</th>
                            <th class="px-2 py-2 border text-left">Departemen</th>
                            <th class="px-2 py-2 border text-left">Status</th>
                            <th class="px-2 py-2 border text-left">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kehadiran as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-2 py-1 border">{{ $loop->iteration }}</td>
                                <td class="px-2 py-1 border">
                                    {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}
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
                                    {{ ucfirst($row->status ?? '-') }}
                                </td>
                                <td class="px-2 py-1 border">
                                    {{ $row->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-2 py-3 text-center text-gray-500">
                                    Tidak ada data kehadiran untuk bulan dan tahun yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
