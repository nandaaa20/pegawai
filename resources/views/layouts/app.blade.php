<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#111c34">
    <title>{{ config('app.name', 'SIMPEG') }} · Workspace</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="simpeg-app min-h-screen antialiased" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
    <a href="#main-content" class="skip-link">Lewati ke konten utama</a>
    <div class="simpeg-shell">
        <div x-cloak x-show="sidebarOpen" x-transition.opacity class="simpeg-sidebar-backdrop lg:hidden" @click="sidebarOpen = false" aria-hidden="true"></div>
        @include('layouts.navigation')

        <div class="simpeg-workspace">
            <header class="simpeg-topbar">
                <div class="flex min-w-0 items-center gap-3">
                    <button type="button" class="simpeg-icon-button lg:hidden" @click="sidebarOpen = true" aria-label="Buka menu navigasi" aria-controls="simpeg-sidebar" :aria-expanded="sidebarOpen.toString()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                    </button>
                    <div class="hidden sm:block min-w-0">
                        <div class="text-[11px] font-semibold tracking-[.16em] uppercase text-slate-400">Workspace / {{ auth()->user()?->role === 'admin' ? 'Administrator' : 'Pegawai' }}</div>
                        <div class="text-sm font-semibold text-slate-800 truncate">Sistem Informasi Manajemen Pegawai</div>
                    </div>
                    <span class="sm:hidden font-extrabold tracking-tight text-slate-900">SIMPEG</span>
                </div>
                <div class="flex items-center gap-2 sm:gap-4">
                    <span class="simpeg-live-badge"><span class="simpeg-live-dot"></span><span class="hidden sm:inline">Sistem aktif</span><span class="sm:hidden">Aktif</span></span>
                    <div class="hidden md:block h-7 w-px bg-slate-200"></div>
                    <a href="{{ route('profile.edit') }}" class="simpeg-top-profile" aria-label="Buka pengaturan profil">
                        <span class="simpeg-avatar simpeg-avatar-small">{{ strtoupper(mb_substr(auth()->user()?->name ?? 'U', 0, 2)) }}</span>
                        <span class="hidden md:block min-w-0 text-left"><span class="block truncate text-xs font-bold text-slate-800">{{ auth()->user()?->name }}</span><span class="block text-[11px] text-slate-500">{{ ucfirst(auth()->user()?->role ?? 'Pegawai') }}</span></span>
                        <svg class="hidden md:block w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="m7 10 5 5 5-5"/></svg>
                    </a>
                </div>
            </header>

            @isset($header)
                <section class="simpeg-page-heading">
                    <div class="simpeg-heading-inner">{{ $header }}</div>
                </section>
            @endisset

            <main id="main-content" class="simpeg-main" tabindex="-1">
                @if(session('success'))
                    <div role="status" class="simpeg-flash simpeg-flash-success">
                        <span aria-hidden="true">✓</span><span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div role="alert" class="simpeg-flash simpeg-flash-error">
                        <span aria-hidden="true">!</span><span>{{ session('error') }}</span>
                    </div>
                @endif
                {{ $slot }}
            </main>
            <footer class="simpeg-footer">
                <span>© {{ now()->year }} SIMPEG <span class="mx-2 text-slate-300">/</span> People operations, simplified.</span>
                <span class="hidden sm:inline">Made for better workdays</span>
            </footer>
        </div>
    </div>
</body>
</html>
