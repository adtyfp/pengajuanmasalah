<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengaduan Sarana Sekolah</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #2c5282; margin-bottom: 5px; }
        .header p { color: #666; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #2c5282; color: white; padding: 10px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .status-baru { background-color: #bee3f8; color: #2c5282; padding: 3px 8px; border-radius: 10px; }
        .status-diproses { background-color: #fefcbf; color: #744210; }
        .status-selesai { background-color: #c6f6d5; color: #22543d; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENGADUAN SARANA SEKOLAH</h1>
        <p>Periode: {{ date('d F Y') }}</p>
        <hr>
    </div>

    <div class="info">
        <p><strong>Total Pengaduan:</strong> {{ $pengaduan->count() }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Siswa</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Prioritas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->tanggal_pengaduan->format('d/m/Y') }}</td>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->siswa->nama }} ({{ $item->siswa->kelas }})</td>
                <td>{{ $item->kategori->nama_kategori }}</td>
                <td>
                    <span class="status-{{ $item->status }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td>{{ ucfirst($item->prioritas) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 40px; text-align: right;">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>Administrator Sekolah</strong></p>
    </div>
</body>
</html>