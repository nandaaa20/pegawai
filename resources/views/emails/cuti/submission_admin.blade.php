<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pengajuan Cuti Baru</title>
</head>
<body>
    <h2>Pengajuan Cuti Baru</h2>
    <p>Berikut detail pengajuan cuti yang baru masuk:</p>
    <ul>
        <li>Nama Pegawai: {{ $cuti->pegawai->nama_lengkap ?? '-' }}</li>
        <li>NIP: {{ $cuti->pegawai->nip ?? '-' }}</li>
        <li>Periode: {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d M Y') }}
            s/d {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d M Y') }}</li>
        <li>Jumlah Hari: {{ $cuti->jumlah_hari }}</li>
        <li>Jenis Cuti: {{ $cuti->jenis_cuti ?? '-' }}</li>
        <li>Alasan: {{ $cuti->alasan ?? '-' }}</li>
        <li>Status: {{ ucfirst($cuti->status) }}</li>
    </ul>
    <p>Silakan tinjau pengajuan ini di dashboard admin.</p>
</body>
</html>
