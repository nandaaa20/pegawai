<section>
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900">
            Ubah Password
        </h2>

        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
            Pastikan akun Anda menggunakan password yang kuat dan aman untuk melindungi data Anda.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <x-input-label for="update_password_current_password" value="Password Saat Ini" class="mb-2 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <x-text-input 
                    id="update_password_current_password" 
                    name="current_password" 
                    type="password" 
                    class="block w-full pl-10" 
                    placeholder="Masukkan password saat ini"
                    autocomplete="current-password" 
                />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- New Password --}}
        <div>
            <x-input-label for="update_password_password" value="Password Baru" class="mb-2 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <x-text-input 
                    id="update_password_password" 
                    name="password" 
                    type="password" 
                    class="block w-full pl-10" 
                    placeholder="Masukkan password baru"
                    autocomplete="new-password" 
                />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            <p class="mt-2 text-xs text-gray-500">Minimal 8 karakter dengan kombinasi huruf, angka, dan simbol</p>
        </div>

        {{-- Confirm Password --}}
        <div>
            <x-input-label for="update_password_password_confirmation" value="Konfirmasi Password Baru" class="mb-2 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <x-text-input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    class="block w-full pl-10" 
                    placeholder="Ketik ulang password baru"
                    autocomplete="new-password" 
                />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Info Box --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-800">Tips Password Aman</p>
                    <ul class="mt-2 text-xs text-blue-700 space-y-1">
                        <li>• Gunakan minimal 8 karakter</li>
                        <li>• Kombinasikan huruf besar, kecil, angka, dan simbol</li>
                        <li>• Hindari menggunakan informasi pribadi</li>
                        <li>• Jangan gunakan password yang sama untuk akun lain</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <div class="flex items-center gap-4">
                <x-primary-button class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Password
                </x-primary-button>

                @if (session('status') === 'password-updated')
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 3000)"
                        class="flex items-center gap-2 text-sm font-medium text-green-600"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Password berhasil diubah!
                    </div>
                @endif
            </div>
        </div>
    </form>
</section>
