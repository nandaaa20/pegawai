<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kehadiran Pegawai</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h2 { margin-bottom: 0; }
        .subtitle { font-size: 10px; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background: #f0f0f0; }
        .rekap-box { border: 1px solid #000; padding: 4px 8px; margin-right: 6px; display: inline-block; font-size: 10px; }
        .rekap-label { font-weight: bold; }
    </style>
</head>
<body>
    <h2>Laporan Kehadiran Pegawai</h2>
    <div class="subtitle">
        Bulan: {{ \Carbon\Carbon::create($tahun, $bulan, 1)->locale('id')->translatedFormat('F Y') }}<br>
        Dicetak: {{ $printed_at->format('d-m-Y H:i') }}
    </div>

    @if($departemen)
        <div class="subtitle">
            Departemen: {{ $departemen }}
        </div>
    @endif

    <div style="margin-top: 8px;">
        <span class="rekap-box">
            <span class="rekap-label">Hadir:</span> {{ $rekap['hadir'] }}
        </span>
        <span class="rekap-box">
            <span class="rekap-label">Izin:</span> {{ $rekap['izin'] }}
        </span>
        <span class="rekap-box">
            <span class="rekap-label">Sakit:</span> {{ $rekap['sakit'] }}
        </span>
        <span class="rekap-box">
            <span class="rekap-label">Alpha:</span> {{ $rekap['alpha'] }}
        </span>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Departemen</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kehadiran as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $row->pegawai->nip ?? '-' }}</td>
                    <td>{{ $row->pegawai->nama_lengkap ?? '-' }}</td>
                    <td>{{ $row->pegawai->departemen ?? '-' }}</td>
                    <td>{{ ucfirst($row->status ?? '-') }}</td>
                    <td>{{ $row->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
