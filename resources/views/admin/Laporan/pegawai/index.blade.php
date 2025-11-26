<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laporan Data Pegawai
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm rounded-lg p-6">

            {{-- Filter --}}
            <form method="GET" action="{{ route('admin.laporan.pegawai') }}"
                  class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        Status Kepegawaian
                    </label>
                    <select name="status" class="w-full border rounded px-2 py-1 text-sm">
                        <option value="">Semua</option>
                        <option value="aktif"    @selected($status === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected($status === 'nonaktif')>Nonaktif</option>
                        <option value="kontrak"  @selected($status === 'kontrak')>Kontrak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        Jabatan
                    </label>
                    <select name="jabatan" class="w-full border rounded px-2 py-1 text-sm">
                        <option value="">Semua</option>
                        @foreach($listJabatan as $j)
                            <option value="{{ $j }}" @selected($jabatan === $j)>{{ $j }}</option>
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
                    <a href="{{ route('admin.laporan.pegawai') }}"
                       class="px-3 py-2 border text-sm rounded hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Info & Tombol Export --}}
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm text-gray-600">
                    Jumlah pegawai: <span class="font-semibold">{{ $pegawai->count() }}</span>
                </p>

                <a href="{{ route('admin.laporan.pegawai.pdf', request()->query()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm rounded hover:bg-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 11V3m0 8l-3-3m3 3l3-3M6 17h12M6 21h12"/>
                    </svg>
                    Export PDF
                </a>
            </div>

            {{-- Tabel Laporan --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 py-2 border text-left">No</th>
                            <th class="px-2 py-2 border text-left">NIP</th>
                            <th class="px-2 py-2 border text-left">Nama</th>
                            <th class="px-2 py-2 border text-left">Jabatan</th>
                            <th class="px-2 py-2 border text-left">Departemen</th>
                            <th class="px-2 py-2 border text-left">Status</th>
                            <th class="px-2 py-2 border text-left">Tanggal Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pegawai as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-2 py-1 border">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-1 border font-mono">
                                    {{ $row->nip }}
                                </td>
                                <td class="px-2 py-1 border">
                                    {{ $row->nama_lengkap }}
                                </td>
                                <td class="px-2 py-1 border">
                                    {{ $row->jabatan ?? '-' }}
                                </td>
                                <td class="px-2 py-1 border">
                                    {{ $row->departemen ?? '-' }}
                                </td>
                                <td class="px-2 py-1 border">
                                    {{ ucfirst($row->status_kepegawaian ?? 'aktif') }}
                                </td>
                                <td class="px-2 py-1 border">
                                    {{ $row->tanggal_masuk
                                        ? \Carbon\Carbon::parse($row->tanggal_masuk)->format('d-m-Y')
                                        : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-2 py-3 text-center text-gray-500">
                                    Tidak ada data pegawai untuk filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
