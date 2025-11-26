<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg mb-4">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Masuk ke SIMPEG</h2>
        <p class="mt-2 text-sm text-gray-600">Sistem Informasi Manajemen Pegawai</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- NIP -->
        <div>
            <x-input-label for="nip" value="NIP" class="mb-2 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <x-text-input 
                    id="nip" 
                    class="block w-full pl-10" 
                    type="text" 
                    name="nip" 
                    :value="old('nip')" 
                    placeholder="Masukkan NIP Anda"
                    required 
                    autofocus 
                />
            </div>
            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Password" class="mb-2 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <x-text-input 
                    id="password" 
                    class="block w-full pl-10"
                    type="password"
                    name="password"
                    placeholder="Masukkan password Anda"
                    required 
                    autocomplete="current-password" 
                />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 cursor-pointer" 
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-600 select-none">Ingat saya</span>
            </label>
            
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full justify-center py-3 text-base">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Masuk
            </x-primary-button>
        </div>
    </form>

    <!-- Info Box -->
    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-medium text-blue-800">Butuh bantuan?</p>
                <p class="mt-1 text-xs text-blue-700">
                    Hubungi admin kepegawaian jika mengalami kesulitan login atau lupa NIP/password.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-6 text-center text-xs text-gray-500">
        <p>© {{ date('Y') }} SIMPEG. All rights reserved.</p>
    </div>
</x-guest-layout>
