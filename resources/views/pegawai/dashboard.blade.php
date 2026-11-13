<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div><p class="simpeg-eyebrow mb-2">MY WORKSPACE</p><h2>Halo, {{ Str::before($user->name, ' ') }} <span aria-hidden="true">👋</span></h2><p class="mt-1.5 text-sm text-slate-500">Pantau kehadiran, cuti, dan aktivitas kepegawaianmu di sini.</p></div>
            <div class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-600">
                <svg class="h-4 w-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4M17 3v4M3 10h18"/></svg>{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            </div>
        </div>
    </x-slot>

    <div class="space-y-7">
        <div class="relative overflow-hidden rounded-[22px] bg-[#162541] px-6 py-7 text-white shadow-[0_18px_40px_rgba(17,28,52,.14)] sm:px-9 sm:py-9">
            <div class="pointer-events-none absolute -right-20 -top-28 h-72 w-72 rounded-full border-[45px] border-white/[.04]"></div>
            <div class="pointer-events-none absolute bottom-[-120px] right-[16%] h-56 w-56 rounded-full bg-sky-400/[.07] blur-xl"></div>
            <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div><p class="text-xs font-semibold uppercase tracking-[.17em] text-sky-300">Employee dashboard</p><h3 class="mt-2 text-[25px] font-extrabold tracking-tight sm:text-[30px]">Semua aktivitas kerja,<br> dalam satu tempat.</h3><p class="mt-3 max-w-md text-sm leading-relaxed text-slate-300">Ajukan cuti dan lihat status persetujuannya dengan mudah, kapan saja.</p></div>
                <a href="{{ route('pegawai.cuti.create') }}" class="simpeg-action-link !bg-sky-400 !text-[#112340] hover:!bg-sky-300">+ Ajukan cuti baru <span aria-hidden="true">→</span></a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="simpeg-stat-card"><div class="flex justify-between"><span class="simpeg-stat-label">Sisa cuti</span><span class="simpeg-stat-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 2v4m8-4v4M3 10h18m6 5h6"/></svg></span></div><div class="simpeg-stat-value">{{ $pegawai?->sisa_cuti ?? 0 }} <span class="text-base font-semibold text-slate-400">hari</span></div><p class="mt-3 text-xs text-slate-500">Dari kuota {{ $pegawai?->kuota_cuti ?? 0 }} hari</p><div class="absolute bottom-0 left-0 h-1 w-full bg-sky-500"></div></div>
            <div class="simpeg-stat-card"><div class="flex justify-between"><span class="simpeg-stat-label">Cuti disetujui</span><span class="simpeg-stat-icon !bg-emerald-50 !text-emerald-600"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/></svg></span></div><div class="simpeg-stat-value">{{ $totalCutiDisetujui }}</div><p class="mt-3 text-xs text-emerald-700">Pengajuan telah disetujui</p><div class="absolute bottom-0 left-0 h-1 w-full bg-emerald-500"></div></div>
            <div class="simpeg-stat-card"><div class="flex justify-between"><span class="simpeg-stat-label">Menunggu persetujuan</span><span class="simpeg-stat-icon !bg-amber-50 !text-amber-600"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span></div><div class="simpeg-stat-value">{{ $totalCutiPending }}</div><p class="mt-3 text-xs text-slate-500">Pengajuan sedang diproses</p><div class="absolute bottom-0 left-0 h-1 w-full bg-amber-400"></div></div>
            <div class="simpeg-stat-card"><div class="flex justify-between"><span class="simpeg-stat-label">Hadir bulan ini</span><span class="simpeg-stat-icon !bg-violet-50 !text-violet-600"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 2v4m8-4v4M4 10h16m5 5 2 2 4-4"/></svg></span></div><div class="simpeg-stat-value">{{ $totalHadirBulanIni }} <span class="text-base font-semibold text-slate-400">hari</span></div><p class="mt-3 text-xs text-slate-500">Kehadiran tercatat bulan ini</p><div class="absolute bottom-0 left-0 h-1 w-full bg-violet-500"></div></div>
        </div>

        <div class="grid gap-5 lg:grid-cols-5">
            <section class="simpeg-card lg:col-span-3"><div class="simpeg-card-heading"><div><h3 class="text-base font-extrabold text-slate-900">Informasi kepegawaian</h3><p class="mt-1 text-xs text-slate-500">Profil dan data yang tercatat di sistem</p></div><span class="simpeg-tag simpeg-tag-success">Akun aktif</span></div>
                <div class="divide-y divide-slate-100 px-6">
                    @foreach([['label' => 'Nama lengkap', 'value' => $pegawai?->nama_lengkap ?? $user->name], ['label' => 'NIP', 'value' => $user->nip ?? '-'], ['label' => 'Jabatan', 'value' => $pegawai?->jabatan ?? '-'], ['label' => 'Departemen', 'value' => $pegawai?->departemen ?? '-'], ['label' => 'Status', 'value' => ucfirst($pegawai?->status_kepegawaian ?? '-')]] as $item)
                        <div class="flex items-center justify-between gap-4 py-4 text-sm"><span class="text-slate-500">{{ $item['label'] }}</span><span class="max-w-[60%] text-right font-bold text-slate-900">{{ $item['value'] }}</span></div>
                    @endforeach
                </div>
            </section>
            <section class="simpeg-card lg:col-span-2"><div class="simpeg-card-heading"><div><h3 class="text-base font-extrabold text-slate-900">Kuota cuti tahunan</h3><p class="mt-1 text-xs text-slate-500">Ringkasan jatah cuti tersedia</p></div></div>
                <div class="p-6"><div class="flex items-baseline gap-2"><span class="text-[44px] font-extrabold leading-none tracking-tight text-sky-600">{{ $pegawai?->sisa_cuti ?? 0 }}</span><span class="text-sm font-semibold text-slate-400">/ {{ $pegawai?->kuota_cuti ?? 0 }} hari</span></div><div class="mt-6 simpeg-progress-track !h-3"><div class="simpeg-progress-fill" style="width: {{ ($pegawai?->kuota_cuti ?? 0) > 0 ? min(100, max(0, round(($pegawai->sisa_cuti / $pegawai->kuota_cuti) * 100))) : 0 }}%"></div></div><p class="mt-3 text-xs leading-relaxed text-slate-500">Sisa kuota diperbarui setelah permohonan cuti mendapat persetujuan.</p><a href="{{ route('pegawai.cuti.index') }}" class="simpeg-action-link-secondary mt-6 w-full">Lihat riwayat cuti <span aria-hidden="true">→</span></a></div>
            </section>
        </div>

        <section><div class="mb-4"><h3 class="text-base font-extrabold text-slate-900">Aksi cepat</h3><p class="mt-1 text-xs text-slate-500">Semua yang kamu butuhkan dalam satu klik.</p></div>
            <div class="grid gap-4 md:grid-cols-3">
                <a href="{{ route('pegawai.cuti.create') }}" class="simpeg-quick-action"><span class="simpeg-quick-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M12 5v14M5 12h14"/></svg></span><span class="flex-1"><span class="block text-sm font-bold text-slate-900">Ajukan cuti</span><span class="mt-1 block text-xs text-slate-500">Buat permohonan baru</span></span><span class="text-sky-500">→</span></a>
                <a href="{{ route('pegawai.cuti.index') }}" class="simpeg-quick-action"><span class="simpeg-quick-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><rect x="4" y="4" width="16" height="17" rx="2"/><path d="M8 2v4m8-4v4M4 10h16m-12 5h8"/></svg></span><span class="flex-1"><span class="block text-sm font-bold text-slate-900">Riwayat cuti</span><span class="mt-1 block text-xs text-slate-500">Cek status permohonan</span></span><span class="text-sky-500">→</span></a>
                <a href="{{ route('profile.edit') }}" class="simpeg-quick-action"><span class="simpeg-quick-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/></svg></span><span class="flex-1"><span class="block text-sm font-bold text-slate-900">Pengaturan akun</span><span class="mt-1 block text-xs text-slate-500">Kelola email dan password</span></span><span class="text-sky-500">→</span></a>
            </div>
        </section>
    </div>
</x-app-layout>
