<x-guest-layout>
    <div class="mb-8">
        <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-sky-50 px-3 py-1.5 text-[11px] font-bold text-sky-700"><span class="h-1.5 w-1.5 rounded-full bg-sky-500"></span> SELAMAT DATANG KEMBALI</div>
        <h1 class="text-[30px] font-extrabold tracking-tight text-slate-900 sm:text-[34px]">Masuk ke akunmu</h1>
        <p class="mt-2 text-sm leading-relaxed text-slate-500">Gunakan NIP dan password yang terdaftar untuk mengakses workspace.</p>
    </div>

    <div class="simpeg-auth-form">
        <x-auth-session-status class="mb-5" :status="session('status')" />
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <x-input-label for="nip" value="Nomor Induk Pegawai (NIP)" class="mb-2 !text-xs !font-bold !text-slate-700" />
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3.5 top-3.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 20v-1a7.5 7.5 0 0 1 15 0v1"/></svg>
                    <x-text-input id="nip" class="block w-full !pl-11" type="text" name="nip" :value="old('nip')" placeholder="Masukkan NIP Anda" required autofocus autocomplete="username" inputmode="numeric" />
                </div>
                <x-input-error :messages="$errors->get('nip')" class="mt-2" />
            </div>
            <div x-data="{ showPassword: false }">
                <div class="mb-2 flex items-center justify-between gap-3">
                    <x-input-label for="password" value="Password" class="!text-xs !font-bold !text-slate-700" />
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-sky-600 transition-colors hover:text-sky-700">Lupa password?</a>
                    @endif
                </div>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3.5 top-3.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"/></svg>
                    <x-text-input id="password" class="block w-full !pl-11 !pr-12" x-bind:type="showPassword ? 'text' : 'password'" name="password" placeholder="Masukkan password Anda" required autocomplete="current-password" />
                    <button type="button" class="absolute right-2 top-2 rounded-lg px-2 py-1.5 text-xs font-semibold text-slate-500 hover:bg-slate-100 hover:text-slate-800" @click="showPassword = !showPassword" x-bind:aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'" x-text="showPassword ? 'Tutup' : 'Lihat'"></button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2.5">
                <input id="remember_me" type="checkbox" name="remember">
                <span class="select-none text-xs font-medium text-slate-600">Tetap masuk di perangkat ini</span>
            </label>
            <button type="submit" class="simpeg-action-link !w-full !justify-center !py-3.5">Masuk ke workspace <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></button>
        </form>
    </div>
    <div class="mt-6 rounded-xl border border-slate-200 bg-white/80 p-4">
        <div class="flex gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sky-600"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/></svg></span><div><p class="text-xs font-bold text-slate-800">Butuh bantuan masuk?</p><p class="mt-1 text-xs leading-relaxed text-slate-500">Hubungi admin kepegawaian jika NIP atau akses akunmu bermasalah.</p></div></div>
    </div>
</x-guest-layout>
