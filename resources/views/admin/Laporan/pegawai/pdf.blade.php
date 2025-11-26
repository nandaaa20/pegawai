<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Pegawai</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h2 { margin-bottom: 0; }
        .subtitle { font-size: 10px; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Laporan Data Pegawai</h2>
    <div class="subtitle">
        Dicetak: {{ $printed_at->format('d-m-Y H:i') }}
    </div>

    @if($status || $jabatan || $departemen)
        <div class="subtitle">
            Filter:
            @if($status) Status = {{ ucfirst($status) }}; @endif
            @if($jabatan) Jabatan = {{ $jabatan }}; @endif
            @if($departemen) Departemen = {{ $departemen }}; @endif
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Departemen</th>
                <th>Status</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawai as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->nip }}</td>
                    <td>{{ $row->nama_lengkap }}</td>
                    <td>{{ $row->jabatan ?? '-' }}</td>
                    <td>{{ $row->departemen ?? '-' }}</td>
                    <td>{{ ucfirst($row->status_kepegawaian ?? 'aktif') }}</td>
                    <td>{{ $row->tanggal_masuk ? \Carbon\Carbon::parse($row->tanggal_masuk)->format('d-m-Y') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
