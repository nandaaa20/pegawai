<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pengaturan Profil
            </h2>
            <div class="text-sm text-gray-500">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Profile Header Card --}}
            <div class="bg-gradient-to-br from-emerald-600 to-teal-600 rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center gap-4">
                        @php
                            $displayName = $pegawai->nama_lengkap ?? $user->name;
                            $initials = strtoupper(mb_substr($displayName, 0, 2));
                        @endphp

                        <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white/30">
                            <span class="text-3xl font-bold text-white">
                                {{ $initials }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">
                                {{ $displayName }}
                            </h3>

                            {{-- Email hanya sebagai info, boleh diubah lewat form di bawah --}}
                            <p class="text-emerald-50 text-sm">
                                {{ $user->email ?? '-' }}
                            </p>

                            <div class="mt-2 flex flex-wrap gap-2 text-xs text-emerald-50">
                                <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-white/20 backdrop-blur-sm">
                                    {{ ucfirst($user->role) }}
                                </span>

                                @if($pegawai)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm">
                                        NIP: {{ $pegawai->nip }}
                                    </span>
                                    @if($pegawai->jabatan)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm">
                                            {{ $pegawai->jabatan }} @if($pegawai->departemen) • {{ $pegawai->departemen }} @endif
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Profil (Nama & NIP hanya tampilan, tidak bisa diubah di sini) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Profil</h3>
                            <p class="text-sm text-gray-500">
                                Nama dan NIP dikelola oleh admin kepegawaian. Anda hanya dapat memperbarui alamat email.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Info identitas (read-only) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Lengkap</label>
                            <input type="text"
                                   value="{{ $pegawai->nama_lengkap ?? $user->name }}"
                                   class="w-full border rounded-lg px-3 py-2 bg-gray-50 text-gray-700"
                                   disabled>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">NIP</label>
                            <input type="text"
                                   value="{{ $pegawai->nip ?? $user->nip ?? '-' }}"
                                   class="w-full border rounded-lg px-3 py-2 bg-gray-50 text-gray-700"
                                   disabled>
                        </div>
                    </div>

                    {{-- Form update email (partial Breeze, tapi sebaiknya hanya email yang editable) --}}
                    <div class="mt-4 pt-4 border-t border-dashed border-gray-200">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Ubah Password --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Ubah Password</h3>
                            <p class="text-sm text-gray-500">
                                Pastikan akun Anda menggunakan password yang kuat dan aman.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Back Button --}}
            <div class="flex justify-center">
                <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('pegawai.dashboard') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
