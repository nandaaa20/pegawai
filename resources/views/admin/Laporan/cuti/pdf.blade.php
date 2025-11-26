<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Cuti Pegawai</title>
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
    <h2>Laporan Cuti Pegawai</h2>
    <div class="subtitle">
        Dicetak: {{ $printed_at->format('d-m-Y H:i') }}
    </div>

    @if($tanggalDari || $tanggalSampai || $status || $jenis || $departemen)
        <div class="subtitle">
            Filter:
            @if($tanggalDari) Periode dari {{ \Carbon\Carbon::parse($tanggalDari)->format('d-m-Y') }} @endif
            @if($tanggalSampai) s/d {{ \Carbon\Carbon::parse($tanggalSampai)->format('d-m-Y') }}; @endif
            @if($status) Status = {{ ucfirst($status) }}; @endif
            @if($jenis) Jenis = {{ $jenis }}; @endif
            @if($departemen) Departemen = {{ $departemen }}; @endif
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Departemen</th>
                <th>Jenis Cuti</th>
                <th>Periode</th>
                <th>Lama</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuti as $row)
                @php
                    $mulai = $row->tanggal_mulai ? \Carbon\Carbon::parse($row->tanggal_mulai)->format('d-m-Y') : '-';
                    $selesai = $row->tanggal_selesai ? \Carbon\Carbon::parse($row->tanggal_selesai)->format('d-m-Y') : '-';
                    $hari = ($row->tanggal_mulai && $row->tanggal_selesai)
                        ? \Carbon\Carbon::parse($row->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($row->tanggal_selesai)) + 1
                        : null;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->pegawai->nip ?? '-' }}</td>
                    <td>{{ $row->pegawai->nama_lengkap ?? '-' }}</td>
                    <td>{{ $row->pegawai->departemen ?? '-' }}</td>
                    <td>{{ $row->jenis_cuti ?? '-' }}</td>
                    <td>{{ $mulai }} s/d {{ $selesai }}</td>
                    <td>{{ $hari ? $hari . ' hari' : '-' }}</td>
                    <td>{{ ucfirst($row->status ?? 'pending') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
