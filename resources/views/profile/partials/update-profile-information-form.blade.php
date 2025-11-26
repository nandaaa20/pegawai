<section>
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900">
            Informasi Profil
        </h2>

        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
            Perbarui alamat email akun Anda. Nama dan NIP dikelola oleh admin kepegawaian.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        {{-- Nama (Hanya tampilan, tidak bisa diubah dari sini) --}}
        <div>
            <x-input-label for="name_display" value="Nama Lengkap" class="mb-2 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <input
                    id="name_display"
                    type="text"
                    class="block w-full pl-10 border-gray-300 bg-gray-50 text-gray-700 rounded-lg shadow-sm cursor-not-allowed"
                    value="{{ $user->name }}"
                    disabled
                    readonly
                />
            </div>
            <p class="mt-2 text-xs text-gray-500">
                Perubahan nama hanya dapat dilakukan oleh admin kepegawaian.
            </p>
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Alamat Email" class="mb-2 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <x-text-input
                    id="email"
                    name="email"
                    type="email"
                    class="block w-full pl-10"
                    :value="old('email', $user->email)"
                    placeholder="nama@email.com"
                    required
                    autocomplete="username"
                />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- Email Verification Alert --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-amber-800">
                                Email Anda belum diverifikasi.
                            </p>
                            <button
                                form="send-verification"
                                class="mt-2 inline-flex items-center gap-2 px-3 py-1.5 bg-amber-600 text-white text-xs font-medium rounded-lg hover:bg-amber-700 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Kirim Ulang Email Verifikasi
                            </button>
                        </div>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-3 flex items-center gap-2 text-sm text-green-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Link verifikasi baru telah dikirim ke email Anda.
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- Role Display (Read Only) --}}
        <div>
            <x-input-label for="role" value="Role Pengguna" class="mb-2 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <input
                    type="text"
                    value="{{ ucfirst($user->role) }}"
                    class="block w-full pl-10 border-gray-300 bg-gray-50 text-gray-600 rounded-lg shadow-sm cursor-not-allowed"
                    disabled
                    readonly
                />
            </div>
            <p class="mt-2 text-xs text-gray-500">
                Role tidak dapat diubah sendiri. Hubungi admin jika diperlukan perubahan.
            </p>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <div class="flex items-center gap-4">
                <x-primary-button class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </x-primary-button>

                @if (session('status') === 'profile-updated')
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 3000)"
                        class="flex items-center gap-2 text-sm font-medium text-green-600"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Profil berhasil diperbarui!
                    </div>
                @endif
            </div>
        </div>
    </form>
</section>
