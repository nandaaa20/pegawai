<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Status Pengajuan Cuti</title>
</head>
<body>
    <h2>Status Pengajuan Cuti</h2>
    <p>Halo {{ $cuti->pegawai->nama_lengkap ?? 'Pegawai' }},</p>
    <p>Berikut pembaruan status pengajuan cuti Anda:</p>
    <ul>
        <li>Periode: {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d M Y') }}
            s/d {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d M Y') }}</li>
        <li>Jumlah Hari: {{ $cuti->jumlah_hari }}</li>
        <li>Jenis Cuti: {{ $cuti->jenis_cuti ?? '-' }}</li>
        <li>Status: {{ ucfirst($cuti->status) }}</li>
        @if($cuti->catatan_admin)
            <li>Catatan Admin: {{ $cuti->catatan_admin }}</li>
        @endif
    </ul>
    <p>Terima kasih.</p>
</body>
</html>
