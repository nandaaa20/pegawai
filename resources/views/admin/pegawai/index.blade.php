<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Pegawai
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.pegawai.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded">
                Tambah Pegawai
            </a>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-4">
            <table class="min-w-full text-sm">
                <thead>
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">NIP</th>
                        <th class="border px-3 py-2">Nama</th>
                        <th class="border px-3 py-2">Jabatan</th>
                        <th class="border px-3 py-2">Departemen</th>
                        <th class="border px-3 py-2">Status</th>
                        <th class="border px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pegawai as $p)
                        <tr>
                            <td class="border px-3 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-3 py-2">{{ $p->nip }}</td>
                            <td class="border px-3 py-2">{{ $p->nama_lengkap }}</td>
                            <td class="border px-3 py-2">{{ $p->jabatan }}</td>
                            <td class="border px-3 py-2">{{ $p->departemen }}</td>
                            <td class="border px-3 py-2">{{ ucfirst($p->status_kepegawaian) }}</td>
                            <td class="border px-3 py-2 space-x-2">
                                <a href="{{ route('admin.pegawai.show', $p) }}" class="text-blue-600">Detail</a>
                                <a href="{{ route('admin.pegawai.edit', $p) }}" class="text-yellow-600">Edit</a>
                                <form action="{{ route('admin.pegawai.destroy', $p) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="border px-3 py-2 text-center" colspan="7">
                                Belum ada data pegawai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $pegawai->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
