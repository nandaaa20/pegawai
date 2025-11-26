{{-- admin/pegawai/form.blade.php --}}
<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    {{-- Section: Identitas Pegawai --}}
    <div>
        <h4 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
            </svg>
            Identitas Pegawai
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- NIP --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    NIP <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nip"
                       value="{{ old('nip', $pegawai->nip ?? '') }}"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('nip') border-red-500 @enderror"
                       placeholder="Masukkan NIP"
                       required>
                @error('nip')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Lengkap --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama_lengkap"
                       value="{{ old('nama_lengkap', $pegawai->nama_lengkap ?? '') }}"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('nama_lengkap') border-red-500 @enderror"
                       placeholder="Masukkan nama lengkap"
                       required>
                @error('nama_lengkap')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Jenis Kelamin <span class="text-red-500">*</span>
                </label>
                <select name="jenis_kelamin" 
                        class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('jenis_kelamin') border-red-500 @enderror"
                        required>
                    <option value="">- Pilih Jenis Kelamin -</option>
                    <option value="L" @selected(old('jenis_kelamin', $pegawai->jenis_kelamin ?? '')=='L')>Laki-laki</option>
                    <option value="P" @selected(old('jenis_kelamin', $pegawai->jenis_kelamin ?? '')=='P')>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Tanggal Lahir
                </label>
                <input type="date" 
                       name="tanggal_lahir"
                       value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ?? '') }}"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('tanggal_lahir') border-red-500 @enderror">
                @error('tanggal_lahir')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Divider --}}
    <div class="border-t border-gray-200"></div>

    {{-- Section: Informasi Jabatan --}}
    <div>
        <h4 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Informasi Jabatan
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Jabatan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Jabatan
                </label>
                <select name="jabatan" 
                        class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('jabatan') border-red-500 @enderror">
                    <option value="">- Pilih Jabatan -</option>
                    @foreach($listJabatan as $jab)
                        <option value="{{ $jab }}"
                            @selected(old('jabatan', $pegawai->jabatan ?? '') == $jab)>
                            {{ $jab }}
                        </option>
                    @endforeach
                </select>
                @error('jabatan')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Departemen --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Departemen
                </label>
                <select name="departemen" 
                        class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('departemen') border-red-500 @enderror">
                    <option value="">- Pilih Departemen -</option>
                    @foreach($listDepartemen as $dep)
                        <option value="{{ $dep }}"
                            @selected(old('departemen', $pegawai->departemen ?? '') == $dep)>
                            {{ $dep }}
                        </option>
                    @endforeach
                </select>
                @error('departemen')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status Kepegawaian --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Status Kepegawaian <span class="text-red-500">*</span>
                </label>
                <select name="status_kepegawaian" 
                        class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('status_kepegawaian') border-red-500 @enderror"
                        required>
                    <option value="aktif" @selected(old('status_kepegawaian', $pegawai->status_kepegawaian ?? 'aktif')=='aktif')>Aktif</option>
                    <option value="nonaktif" @selected(old('status_kepegawaian', $pegawai->status_kepegawaian ?? '')=='nonaktif')>Nonaktif</option>
                    <option value="kontrak" @selected(old('status_kepegawaian', $pegawai->status_kepegawaian ?? '')=='kontrak')>Kontrak</option>
                </select>
                @error('status_kepegawaian')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Masuk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Tanggal Masuk
                </label>
                <input type="date" 
                       name="tanggal_masuk"
                       value="{{ old('tanggal_masuk', $pegawai->tanggal_masuk ?? '') }}"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('tanggal_masuk') border-red-500 @enderror">
                @error('tanggal_masuk')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Divider --}}
    <div class="border-t border-gray-200"></div>

    {{-- Section: Informasi Kontak --}}
    <div>
        <h4 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            Informasi Kontak
        </h4>

        <div class="grid grid-cols-1 gap-4">
            {{-- No. Telepon --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    No. Telepon
                </label>
                <input type="text" 
                       name="no_telepon"
                       value="{{ old('no_telepon', $pegawai->no_telepon ?? '') }}"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('no_telepon') border-red-500 @enderror"
                       placeholder="Contoh: 081234567890">
                @error('no_telepon')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Alamat
                </label>
                <textarea name="alamat"
                          rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none @error('alamat') border-red-500 @enderror"
                          placeholder="Masukkan alamat lengkap">{{ old('alamat', $pegawai->alamat ?? '') }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
        <a href="{{ route('admin.pegawai.index') }}" 
           class="px-5 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Batal
        </a>
        <button type="submit" 
                class="px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ $buttonLabel }}
        </button>
    </div>
</form>
