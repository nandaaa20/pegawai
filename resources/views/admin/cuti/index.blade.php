<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div><p class="simpeg-eyebrow mb-2">EMPLOYEE MANAGEMENT</p><h2>Manajemen cuti</h2><p class="mt-1.5 text-sm text-slate-500">Kelola permohonan dan pantau status pengajuan cuti pegawai.</p></div>
            <span class="simpeg-tag simpeg-tag-warning self-start sm:self-auto">{{ $cuti->where('status', 'pending')->count() }} menunggu persetujuan</span>
        </div>
    </x-slot>

    <div class="space-y-5">
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="simpeg-stat-card"><div class="flex items-center justify-between"><span class="simpeg-stat-label">Total pengajuan</span><span class="simpeg-stat-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M6 3h9l4 4v13H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/><path d="M14 3v5h5M8 13h8m-8 4h5"/></svg></span></div><div class="simpeg-stat-value">{{ $cuti->count() }}</div><p class="mt-2 text-xs text-slate-500">Seluruh permohonan tercatat</p></div>
            <div class="simpeg-stat-card"><div class="flex items-center justify-between"><span class="simpeg-stat-label">Menunggu</span><span class="simpeg-stat-icon !bg-amber-50 !text-amber-600"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span></div><div class="simpeg-stat-value">{{ $cuti->where('status', 'pending')->count() }}</div><p class="mt-2 text-xs text-amber-700">Perlu ditinjau oleh admin</p></div>
            <div class="simpeg-stat-card"><div class="flex items-center justify-between"><span class="simpeg-stat-label">Disetujui</span><span class="simpeg-stat-icon !bg-emerald-50 !text-emerald-600"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/></svg></span></div><div class="simpeg-stat-value">{{ $cuti->where('status', 'disetujui')->count() }}</div><p class="mt-2 text-xs text-emerald-700">Permohonan yang telah disetujui</p></div>
        </div>

        <section class="simpeg-card overflow-hidden">
            <div class="simpeg-card-heading">
                <div><h3 class="text-base font-extrabold text-slate-900">Daftar pengajuan</h3><p class="mt-1 text-xs text-slate-500">Periksa detail permohonan sebelum memutuskan status.</p></div>
                <span class="text-xs font-semibold text-slate-400">{{ $cuti->count() }} pengajuan</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead><tr><th>Tanggal cuti</th><th>Nama pegawai</th><th>Jenis cuti</th><th>Status</th><th class="!text-right">Aksi</th></tr></thead>
                    <tbody>
                        @forelse($cuti as $pengajuan)
                            @php
                                $status = strtolower($pengajuan->status ?? '');
                                $badge = match ($status) {
                                    'pending' => 'simpeg-tag-warning',
                                    'disetujui' => 'simpeg-tag-success',
                                    'ditolak' => 'simpeg-tag-danger',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            @endphp
                            <tr>
                                <td class="whitespace-nowrap"><span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->format('d M Y') }}</span><span class="px-1.5 text-slate-400">–</span><span class="text-slate-600">{{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->format('d M Y') }}</span></td>
                                <td><span class="block font-bold text-slate-900">{{ $pengajuan->pegawai->nama_lengkap ?? '-' }}</span><span class="mt-1 block text-xs text-slate-500">NIP {{ $pengajuan->pegawai->nip ?? '-' }}</span></td>
                                <td><span class="text-xs font-semibold text-slate-600">{{ $pengajuan->jenis_cuti ?? '-' }}</span></td>
                                <td><span class="simpeg-tag {{ $badge }}">{{ ucfirst($pengajuan->status ?? '-') }}</span></td>
                                <td class="text-right"><a href="{{ route('admin.cuti.show', $pengajuan) }}" class="inline-flex items-center gap-1 font-bold text-sky-600 hover:text-sky-700">Lihat detail <span aria-hidden="true">→</span></a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="!px-6 !py-20 text-center"><div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-50 text-sky-500"><svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 9h6m-6 4h6"/></svg></div><p class="mt-4 text-sm font-bold text-slate-900">Belum ada pengajuan cuti</p><p class="mt-1 text-xs text-slate-500">Pengajuan pegawai akan ditampilkan di sini.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
