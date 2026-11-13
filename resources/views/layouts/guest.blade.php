<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#111c34">
    <title>{{ config('app.name', 'SIMPEG') }} · Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    {{-- Critical fallback: keep authentication usable if Vite dev assets cannot be reached. --}}
    <link rel="stylesheet" href="{{ asset('css/simpeg-auth-fallback.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="simpeg-auth-page">
        <aside class="simpeg-auth-hero" aria-label="Tentang SIMPEG">
            <div class="pointer-events-none absolute -right-32 -top-28 h-96 w-96 rounded-full border-[65px] border-white/[.035]"></div>
            <div class="pointer-events-none absolute -bottom-44 -left-24 h-[480px] w-[480px] rounded-full border-[90px] border-sky-400/[.07]"></div>
            <a href="{{ url('/') }}" class="relative flex w-fit items-center gap-3">
                <span class="simpeg-brand-mark !h-12 !w-12"><svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="6" width="17" height="14" rx="3"/><path stroke-linecap="round" d="M8.5 6V4.5A1.5 1.5 0 0 1 10 3h4a1.5 1.5 0 0 1 1.5 1.5V6M3.5 12h17M10 12v2h4v-2"/></svg></span>
                <span><span class="block text-2xl font-extrabold tracking-tight">simpeg<span class="text-sky-400">.</span></span><span class="block text-[11px] tracking-[.2em] uppercase text-slate-400">People workspace</span></span>
            </a>
            <div class="relative max-w-xl">
                <div class="mb-7 inline-flex items-center gap-2 rounded-full border border-sky-400/20 bg-sky-400/10 px-4 py-2 text-[11px] font-semibold tracking-wide text-sky-300"><span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span> SISTEM MANAJEMEN KEPEGAWAIAN</div>
                <h1 class="text-[42px] font-extrabold leading-[1.16] tracking-[-.05em] xl:text-[56px]">Kelola tim lebih mudah.<br><span class="text-sky-400">Kerja lebih terarah.</span></h1>
                <p class="mt-6 max-w-[480px] text-[15px] leading-8 text-slate-300">Satu ruang kerja untuk data pegawai, kehadiran, pengajuan cuti, dan laporan yang rapi serta mudah diakses.</p>
                <div class="mt-12 grid max-w-lg grid-cols-3 gap-4 border-t border-white/10 pt-8">
                    <div><div class="text-2xl font-extrabold text-white">01</div><div class="mt-1.5 text-xs text-slate-400">Data terpusat</div></div>
                    <div><div class="text-2xl font-extrabold text-white">02</div><div class="mt-1.5 text-xs text-slate-400">Alur lebih jelas</div></div>
                    <div><div class="text-2xl font-extrabold text-white">03</div><div class="mt-1.5 text-xs text-slate-400">Insight instan</div></div>
                </div>
            </div>
            <div class="relative text-xs text-slate-500">© {{ now()->year }} SIMPEG · Employee Management System</div>
        </aside>
        <main class="simpeg-auth-panel">
            <div class="simpeg-auth-card">
                <div class="mb-10 lg:hidden"><a href="{{ url('/') }}" class="flex w-fit items-center gap-3"><span class="simpeg-brand-mark">S</span><span class="text-2xl font-extrabold tracking-tight text-slate-900">simpeg<span class="text-sky-500">.</span></span></a></div>
                {{ $slot }}
                <p class="mt-8 text-center text-xs text-slate-400">© {{ now()->year }} SIMPEG · Sistem Informasi Manajemen Pegawai</p>
            </div>
        </main>
    </div>
</body>
</html>
