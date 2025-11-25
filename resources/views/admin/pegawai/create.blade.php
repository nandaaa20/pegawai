<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pegawai
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 rounded">
                <ul class="list-disc pl-5 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            <form action="{{ route('admin.pegawai.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip') }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Departemen</label>
                        <input type="text" name="departemen" value="{{ old('departemen') }}" class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full border rounded px-3 py-2">
                            <option value="">- Pilih -</option>
                            <option value="L" @selected(old('jenis_kelamin')=='L')>Laki-laki</option>
                            <option value="P" @selected(old('jenis_kelamin')=='P')>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Alamat</label>
                    <textarea name="alamat" class="w-full border rounded px-3 py-2">{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Status Kepegawaian</label>
                    <select name="status_kepegawaian" class="w-full border rounded px-3 py-2">
                        <option value="aktif" @selected(old('status_kepegawaian')=='aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status_kepegawaian')=='nonaktif')>Nonaktif</option>
                        <option value="kontrak" @selected(old('status_kepegawaian')=='kontrak')>Kontrak</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.pegawai.index') }}" class="px-4 py-2 border rounded">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
