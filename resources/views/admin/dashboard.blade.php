<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="simpeg-eyebrow mb-2">WORKSPACE OVERVIEW</p>
                <h2>Selamat datang, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }} <span aria-hidden="true">👋</span></h2>
                <p class="mt-1.5 text-sm text-slate-500">Berikut ringkasan operasional kepegawaian hari ini.</p>
            </div>
            <div class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-600">
                <svg class="h-4 w-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4M17 3v4M3 10h18"/></svg>
                {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            </div>
        </div>
    </x-slot>

    <div class="space-y-7">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="simpeg-stat-card">
                <div class="flex justify-between"><span class="simpeg-stat-label">Total pegawai</span><span class="simpeg-stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3"/><path d="M3 20v-2a6 6 0 0 1 12 0v2M17 5a3 3 0 0 1 0 6m1 3a5 5 0 0 1 3 4.5V20"/></svg></span></div>
                <div class="simpeg-stat-value">{{ number_format($totalPegawai) }}</div>
                <p class="mt-3 text-xs text-slate-500">Terdaftar di dalam sistem</p>
                <div class="absolute bottom-0 left-0 h-1 w-full bg-sky-500"></div>
            </div>
            <div class="simpeg-stat-card">
                <div class="flex justify-between"><span class="simpeg-stat-label">Pegawai aktif</span><span class="simpeg-stat-icon !bg-emerald-50 !text-emerald-600"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/></svg></span></div>
                <div class="simpeg-stat-value">{{ number_format($pegawaiAktif) }}</div>
                <p class="mt-3 text-xs font-semibold text-emerald-700">{{ $totalPegawai ? round($pegawaiAktif / $totalPegawai * 100) : 0 }}% dari total pegawai</p>
                <div class="absolute bottom-0 left-0 h-1 w-full bg-emerald-500"></div>
            </div>
            <div class="simpeg-stat-card">
                <div class="flex justify-between"><span class="simpeg-stat-label">Menunggu persetujuan</span><span class="simpeg-stat-icon !bg-amber-50 !text-amber-600"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span></div>
                <div class="simpeg-stat-value">{{ number_format($cutiPending) }}</div>
                <p class="mt-3 text-xs text-slate-500">Permohonan cuti pending</p>
                <div class="absolute bottom-0 left-0 h-1 w-full bg-amber-400"></div>
            </div>
            <div class="simpeg-stat-card">
                <div class="flex justify-between"><span class="simpeg-stat-label">Hadir hari ini</span><span class="simpeg-stat-icon !bg-violet-50 !text-violet-600"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="17" rx="2"/><path d="M8 2v4m8-4v4M4 10h16m-12 5 2 2 4-4"/></svg></span></div>
                <div class="simpeg-stat-value">{{ number_format($hadirHariIni) }}</div>
                <p class="mt-3 text-xs text-slate-500">Kehadiran tercatat hari ini</p>
                <div class="absolute bottom-0 left-0 h-1 w-full bg-violet-500"></div>
            </div>
        </div>

        <div class="grid gap-5 xl:grid-cols-5">
            <section class="simpeg-card xl:col-span-3">
                <div class="simpeg-card-heading">
                    <div><h3 class="text-base font-extrabold text-slate-900">Distribusi pegawai</h3><p class="mt-1 text-xs text-slate-500">Komposisi berdasarkan status kepegawaian</p></div>
                    <a href="{{ route('admin.pegawai.index') }}" class="text-xs font-bold text-sky-600 hover:text-sky-700">Lihat pegawai &rarr;</a>
                </div>
                <div class="grid items-center gap-7 p-6 sm:grid-cols-[180px,1fr] sm:p-8">
                    @php
                        $totalStatus = max(1, $pegawaiAktif + $pegawaiKontrak + $pegawaiNonAktif);
                        $activePct = round($pegawaiAktif / $totalStatus * 100, 2);
                        $contractPct = round($pegawaiKontrak / $totalStatus * 100, 2);
                    @endphp
                    <div class="mx-auto flex h-44 w-44 items-center justify-center rounded-full" style="background: conic-gradient(#0ea5e9 0% {{ $activePct }}%, #f59e0b {{ $activePct }}% {{ $activePct + $contractPct }}%, #cbd5e1 {{ $activePct + $contractPct }}% 100%);" role="img" aria-label="Aktif {{ $pegawaiAktif }}, kontrak {{ $pegawaiKontrak }}, nonaktif {{ $pegawaiNonAktif }}">
                        <div class="flex h-[132px] w-[132px] flex-col items-center justify-center rounded-full bg-white"><span class="text-[30px] font-extrabold text-slate-900">{{ number_format($totalPegawai) }}</span><span class="text-[11px] font-semibold text-slate-400">Total pegawai</span></div>
                    </div>
                    <div class="space-y-5">
                        @foreach([['label' => 'Aktif', 'count' => $pegawaiAktif, 'color' => 'bg-sky-500'], ['label' => 'Kontrak', 'count' => $pegawaiKontrak, 'color' => 'bg-amber-400'], ['label' => 'Nonaktif', 'count' => $pegawaiNonAktif, 'color' => 'bg-slate-300']] as $status)
                            <div>
                                <div class="mb-2 flex items-center justify-between text-xs"><span class="flex items-center gap-2 font-semibold text-slate-600"><span class="h-2.5 w-2.5 rounded-full {{ $status['color'] }}"></span>{{ $status['label'] }}</span><span class="font-extrabold text-slate-900">{{ $status['count'] }}</span></div>
                                <div class="simpeg-progress-track"><div class="h-full rounded-full {{ $status['color'] }}" style="width: {{ $totalPegawai ? round($status['count'] / $totalPegawai * 100) : 0 }}%"></div></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <section class="simpeg-card xl:col-span-2">
                <div class="simpeg-card-heading"><div><h3 class="text-base font-extrabold text-slate-900">Status cuti</h3><p class="mt-1 text-xs text-slate-500">Ringkasan semua permohonan</p></div><span class="simpeg-tag simpeg-tag-warning">{{ $cutiPending }} pending</span></div>
                <div class="space-y-4 p-6">
                    @foreach([['label' => 'Menunggu persetujuan', 'count' => $cutiPending, 'bg' => 'bg-amber-50', 'ink' => 'text-amber-700', 'symbol' => '◷'], ['label' => 'Disetujui', 'count' => $cutiDisetujui, 'bg' => 'bg-emerald-50', 'ink' => 'text-emerald-700', 'symbol' => '✓'], ['label' => 'Ditolak', 'count' => $cutiDitolak, 'bg' => 'bg-rose-50', 'ink' => 'text-rose-700', 'symbol' => '×']] as $stat)
                        <div class="flex items-center gap-3 rounded-xl border border-slate-100 p-3.5"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-lg font-bold {{ $stat['bg'] }} {{ $stat['ink'] }}">{{ $stat['symbol'] }}</span><span class="flex-1 text-xs font-semibold text-slate-600">{{ $stat['label'] }}</span><span class="text-xl font-extrabold text-slate-900">{{ $stat['count'] }}</span></div>
                    @endforeach
                    <a class="simpeg-action-link-secondary mt-2 w-full" href="{{ route('admin.cuti.index') }}">Kelola pengajuan <span aria-hidden="true">&rarr;</span></a>
                </div>
            </section>
        </div>

        <div class="grid gap-5 xl:grid-cols-5">
            <section class="simpeg-card xl:col-span-3">
                <div class="simpeg-card-heading"><div><h3 class="text-base font-extrabold text-slate-900">Pegawai per departemen</h3><p class="mt-1 text-xs text-slate-500">Lima departemen dengan pegawai terbanyak</p></div></div>
                <div class="space-y-5 p-6">
                    @forelse($pegawaiPerDepartemen as $departemen)
                        <div><div class="mb-2 flex justify-between gap-3 text-xs"><span class="font-semibold text-slate-600">{{ $departemen->departemen }}</span><span class="font-extrabold text-slate-900">{{ $departemen->total }} orang</span></div><div class="simpeg-progress-track"><div class="simpeg-progress-fill" style="width: {{ $totalPegawai ? round($departemen->total / $totalPegawai * 100) : 0 }}%"></div></div></div>
                    @empty
                        <div class="py-12 text-center text-sm text-slate-500">Belum ada data departemen. Tambahkan pegawai untuk melihat distribusi.</div>
                    @endforelse
                </div>
            </section>
            <section class="simpeg-card xl:col-span-2">
                <div class="simpeg-card-heading"><div><h3 class="text-base font-extrabold text-slate-900">Kehadiran hari ini</h3><p class="mt-1 text-xs text-slate-500">Status yang tercatat untuk {{ now()->format('d/m/Y') }}</p></div></div>
                <div class="grid grid-cols-2 gap-3 p-6">
                    @foreach([['name' => 'Hadir', 'count' => $hadirHariIni, 'color' => 'text-emerald-700', 'bg' => 'bg-emerald-50'], ['name' => 'Izin', 'count' => $izinHariIni, 'color' => 'text-sky-700', 'bg' => 'bg-sky-50'], ['name' => 'Sakit', 'count' => $sakitHariIni, 'color' => 'text-amber-700', 'bg' => 'bg-amber-50'], ['name' => 'Alpa', 'count' => $alphaHariIni, 'color' => 'text-rose-700', 'bg' => 'bg-rose-50']] as $stat)
                        <div class="rounded-xl p-4 {{ $stat['bg'] }}"><div class="text-2xl font-extrabold {{ $stat['color'] }}">{{ $stat['count'] }}</div><div class="mt-1 text-xs font-semibold text-slate-600">{{ $stat['name'] }}</div></div>
                    @endforeach
                </div>
            </section>
        </div>

        <section>
            <div class="mb-4 flex items-center justify-between"><div><h3 class="text-base font-extrabold text-slate-900">Akses cepat</h3><p class="mt-1 text-xs text-slate-500">Mulai pekerjaan yang paling sering dilakukan.</p></div></div>
            <div class="grid gap-4 md:grid-cols-3">
                <a class="simpeg-quick-action" href="{{ route('admin.pegawai.create') }}"><span class="simpeg-quick-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="10" cy="8" r="3.5"/><path d="M3 20v-1a7 7 0 0 1 14 0v1M19 8v8m-4-4h8"/></svg></span><span class="flex-1"><span class="block text-sm font-bold text-slate-900">Tambah pegawai</span><span class="mt-1 block text-xs text-slate-500">Daftarkan pegawai baru</span></span><span class="text-sky-500">→</span></a>
                <a class="simpeg-quick-action" href="{{ route('admin.kehadiran.create') }}"><span class="simpeg-quick-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 2v4m8-4v4M3 10h18m-13 5 2 2 4-4"/></svg></span><span class="flex-1"><span class="block text-sm font-bold text-slate-900">Input kehadiran</span><span class="mt-1 block text-xs text-slate-500">Catat absensi pegawai</span></span><span class="text-sky-500">→</span></a>
                <a class="simpeg-quick-action" href="{{ route('admin.laporan.pegawai') }}"><span class="simpeg-quick-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M5 20V5a2 2 0 0 1 2-2h7l5 5v12a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1Zm9-17v6h5M9 13h6m-6 4h6"/></svg></span><span class="flex-1"><span class="block text-sm font-bold text-slate-900">Lihat laporan</span><span class="mt-1 block text-xs text-slate-500">Rekap data kepegawaian</span></span><span class="text-sky-500">→</span></a>
            </div>
        </section>
    </div>
</x-app-layout>
