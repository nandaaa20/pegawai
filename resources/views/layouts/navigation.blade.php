<aside id="simpeg-sidebar" class="simpeg-sidebar" :class="sidebarOpen ? 'simpeg-sidebar-visible' : ''" aria-label="Navigasi utama">
    <div class="simpeg-sidebar-brand">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 min-w-0" @click="sidebarOpen = false">
            <span class="simpeg-brand-mark"><svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="6" width="17" height="14" rx="3"/><path stroke-linecap="round" d="M8.5 6V4.5A1.5 1.5 0 0 1 10 3h4a1.5 1.5 0 0 1 1.5 1.5V6M3.5 12h17M10 12v2h4v-2"/></svg></span>
            <span class="min-w-0"><span class="block font-extrabold text-xl leading-tight tracking-tight text-white">simpeg<span class="text-sky-400">.</span></span><span class="block text-[10px] tracking-[.17em] uppercase text-slate-400">People workspace</span></span>
        </a>
        <button type="button" class="lg:hidden text-slate-400 hover:text-white p-2 rounded-lg" aria-label="Tutup menu" @click="sidebarOpen = false"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" d="M5 5l14 14M19 5 5 19"/></svg></button>
    </div>

    <div class="simpeg-sidebar-scroll">
        <div class="simpeg-sidebar-label">MENU UTAMA</div>
        @if(auth()->user()?->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false" @class(['simpeg-nav-link','simpeg-nav-link-active' => request()->routeIs('admin.dashboard')]) @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg><span>Overview</span>
            </a>
            <a href="{{ route('admin.pegawai.index') }}" @click="sidebarOpen = false" @class(['simpeg-nav-link','simpeg-nav-link-active' => request()->routeIs('admin.pegawai.*')]) @if(request()->routeIs('admin.pegawai.*')) aria-current="page" @endif>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3.5"/><path stroke-linecap="round" d="M2.5 20v-1.5A5.5 5.5 0 0 1 8 13h2a5.5 5.5 0 0 1 5.5 5.5V20M16 5.5a3.5 3.5 0 0 1 0 7M18 14a5 5 0 0 1 3.5 4.8V20"/></svg><span>Data pegawai</span>
            </a>
            <a href="{{ route('admin.kehadiran.index') }}" @click="sidebarOpen = false" @class(['simpeg-nav-link','simpeg-nav-link-active' => request()->routeIs('admin.kehadiran.*')]) @if(request()->routeIs('admin.kehadiran.*')) aria-current="page" @endif>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="3" width="16" height="18" rx="2"/><path stroke-linecap="round" d="M8 2v4M16 2v4M4 9h16m-11 6 2 2 4-4"/></svg><span>Kehadiran</span>
            </a>
            <a href="{{ route('admin.cuti.index') }}" @click="sidebarOpen = false" @class(['simpeg-nav-link','simpeg-nav-link-active' => request()->routeIs('admin.cuti.*')]) @if(request()->routeIs('admin.cuti.*')) aria-current="page" @endif>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M8 3h8a2 2 0 0 1 2 2v15a1 1 0 0 1-1.5.87L12 18.25l-4.5 2.62A1 1 0 0 1 6 20V5a2 2 0 0 1 2-2Zm2 6h4m-4 4h4"/></svg><span>Manajemen cuti</span>
            </a>
            <div class="simpeg-sidebar-label mt-8">ANALISIS</div>
            <div x-data="{ expanded: {{ request()->routeIs('admin.laporan.*') ? 'true' : 'false' }} }">
                <button type="button" class="simpeg-nav-link w-full" @class(['simpeg-nav-link-active' => request()->routeIs('admin.laporan.*')]) @click="expanded = !expanded" :aria-expanded="expanded.toString()" aria-controls="simpeg-report-links">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M4 20V4m0 16h16M9 16v-5m5 5V7m5 9v-3"/></svg><span>Laporan</span><svg class="ml-auto !w-4 !h-4 transition-transform" :class="expanded && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="m6 9 6 6 6-6"/></svg>
                </button>
                <div id="simpeg-report-links" x-cloak x-show="expanded" x-transition class="simpeg-subnav">
                    <a href="{{ route('admin.laporan.pegawai') }}" @click="sidebarOpen = false" @class(['simpeg-subnav-link','simpeg-subnav-active' => request()->routeIs('admin.laporan.pegawai*')])>Laporan pegawai</a>
                    <a href="{{ route('admin.laporan.cuti') }}" @click="sidebarOpen = false" @class(['simpeg-subnav-link','simpeg-subnav-active' => request()->routeIs('admin.laporan.cuti*')])>Laporan cuti</a>
                    <a href="{{ route('admin.laporan.kehadiran') }}" @click="sidebarOpen = false" @class(['simpeg-subnav-link','simpeg-subnav-active' => request()->routeIs('admin.laporan.kehadiran*')])>Laporan kehadiran</a>
                </div>
            </div>
        @else
            <a href="{{ route('pegawai.dashboard') }}" @click="sidebarOpen = false" @class(['simpeg-nav-link','simpeg-nav-link-active' => request()->routeIs('pegawai.dashboard')]) @if(request()->routeIs('pegawai.dashboard')) aria-current="page" @endif>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg><span>Overview</span>
            </a>
            <a href="{{ route('pegawai.cuti.index') }}" @click="sidebarOpen = false" @class(['simpeg-nav-link','simpeg-nav-link-active' => request()->routeIs('pegawai.cuti.index')]) @if(request()->routeIs('pegawai.cuti.index')) aria-current="page" @endif>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="17" rx="2"/><path stroke-linecap="round" d="M8 2v4m8-4v4M4 10h16m-12 5h8"/></svg><span>Riwayat cuti</span>
            </a>
            <a href="{{ route('pegawai.cuti.create') }}" @click="sidebarOpen = false" @class(['simpeg-nav-link','simpeg-nav-link-active' => request()->routeIs('pegawai.cuti.create')]) @if(request()->routeIs('pegawai.cuti.create')) aria-current="page" @endif>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M12 5v14M5 12h14"/></svg><span>Ajukan cuti</span>
            </a>
        @endif
        <div class="simpeg-sidebar-label mt-8">AKUN</div>
        <a href="{{ route('profile.edit') }}" @click="sidebarOpen = false" @class(['simpeg-nav-link','simpeg-nav-link-active' => request()->routeIs('profile.*')]) @if(request()->routeIs('profile.*')) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" d="M19.5 13.8a1.9 1.9 0 0 0 0-3.6l-.8-.3a7 7 0 0 0-.7-1.6l.3-.8a1.9 1.9 0 0 0-2.5-2.5l-.8.3a7 7 0 0 0-1.6-.7l-.3-.8a1.9 1.9 0 0 0-3.6 0l-.3.8a7 7 0 0 0-1.6.7l-.8-.3a1.9 1.9 0 0 0-2.5 2.5l.3.8a7 7 0 0 0-.7 1.6l-.8.3a1.9 1.9 0 0 0 0 3.6l.8.3a7 7 0 0 0 .7 1.6l-.3.8a1.9 1.9 0 0 0 2.5 2.5l.8-.3a7 7 0 0 0 1.6.7l.3.8a1.9 1.9 0 0 0 3.6 0l.3-.8a7 7 0 0 0 1.6-.7l.8.3a1.9 1.9 0 0 0 2.5-2.5l-.3-.8a7 7 0 0 0 .7-1.6l.8-.3Z"/></svg><span>Pengaturan profil</span>
        </a>
    </div>

    <div class="simpeg-sidebar-bottom">
        <div class="simpeg-sidebar-user"><span class="simpeg-avatar">{{ strtoupper(mb_substr(auth()->user()?->name ?? 'U', 0, 2)) }}</span><span class="min-w-0 flex-1"><span class="block truncate text-sm font-semibold text-white">{{ auth()->user()?->name }}</span><span class="block text-xs text-slate-400">{{ ucfirst(auth()->user()?->role ?? 'Pegawai') }}</span></span></div>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="simpeg-logout"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4"><path stroke-linecap="round" d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4m7 4 5 5-5 5m5-5H9"/></svg>Keluar dari akun</button></form>
    </div>
</aside>