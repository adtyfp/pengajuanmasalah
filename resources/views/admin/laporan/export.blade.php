<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengaduan Sarana Sekolah</title>
    <style>
        @page { margin: 20px; }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2c5282;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10px;
        }
        th {
            background-color: #2c5282;
            color: #fff;
            padding: 6px;
            border: 1px solid #2c5282;
        }
        td {
            padding: 5px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }
        tr:nth-child(even) { background-color: #f8fafc; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .footer {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 10px;
        }
        .page-number {
            position: fixed;
            bottom: 10px;
            right: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>LAPORAN PENGADUAN SARANA SEKOLAH</h2>
    <p>
        Periode:
        {{ request('start_date') ? date('d F Y', strtotime(request('start_date'))) : 'Semua Waktu' }}
        s/d
        {{ request('end_date') ? date('d F Y', strtotime(request('end_date'))) : date('d F Y') }}
    </p>
</div>

<table>
    <thead>
        <tr>
            <th width="30">No</th>
            <th width="80">Tanggal</th>
            <th width="120">Siswa</th>
            <th width="150">Judul</th>
            <th width="100">Kategori</th>
            <th width="70">Status</th>
            <th width="70">Prioritas</th>
            <th width="100">Lokasi</th>
            <th width="80">Feedback</th>
        </tr>
    </thead>
    <tbody>

    @forelse($pengaduan as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>

            <td>
                {{ optional($item->tanggal_pengaduan)->format('d/m/Y') ?? '-' }}
            </td>

            <td>
                <div class="font-bold">
                    {{ optional($item->siswa)->nama ?? 'Siswa Dihapus' }}
                </div>
                <div>
                    {{ optional($item->siswa)->kelas ?? '-' }}
                    | NIS: {{ optional($item->siswa)->nis ?? '-' }}
                </div>
            </td>

            <td>{{ $item->judul }}</td>

            <td>
                {{ optional($item->kategori)->nama_kategori ?? '-' }}
            </td>

            <td class="text-center">
                {{ ucfirst($item->status) }}
            </td>

            <td class="text-center">
                {{ ucfirst($item->prioritas) }}
            </td>

            <td>{{ $item->lokasi }}</td>

            <td class="text-center">
                @if(!empty($item->feedback) && $item->feedback->isNotEmpty())
                    Ada
                @else
                    -
                @endif
            </td>
        </tr>

        @if(!empty($item->feedback) && $item->feedback->isNotEmpty() && $item->status == 'selesai')
        @php $lastFeedback = $item->feedback->last(); @endphp
        <tr>
            <td colspan="9" style="font-size:9px;background:#f0fff4;">
                <strong>Feedback:</strong>
                {{ $lastFeedback->isi_feedback ?? '-' }}
                —
                {{ optional($lastFeedback->admin)->nama ?? 'Admin' }}
                ({{ optional($lastFeedback->created_at)->format('d/m/Y') ?? '-' }})
            </td>
        </tr>
        @endif

    @empty
        <tr>
            <td colspan="9" class="text-center">
                Tidak ada data pengaduan.
            </td>
        </tr>
    @endforelse

    </tbody>
</table>

{{-- ANALISIS DATA --}}
@if($total > 0)

@php
$withFeedback = $pengaduan->filter(function($item){
    return !empty($item->feedback) && $item->feedback->isNotEmpty();
})->count();

$feedbackRate = $total > 0 ? round(($withFeedback / $total) * 100, 1) : 0;

$totalDays = 0;
$countSelesai = 0;

foreach($pengaduan->where('status','selesai') as $item){
    if(!empty($item->historiStatus) && $item->historiStatus->isNotEmpty()){
        $completed = $item->historiStatus
            ->where('status_sesudah','selesai')
            ->first();
        if($completed){
            $totalDays += $item->created_at->diffInDays($completed->created_at);
            $countSelesai++;
        }
    }
}

$avgDays = $countSelesai > 0 ? round($totalDays / $countSelesai,1) : 0;
@endphp

<div style="margin-top:20px;font-size:11px;">
    <p><strong>Total:</strong> {{ $total }}</p>
    <p><strong>Selesai:</strong> {{ $selesai }}</p>
    <p><strong>Diproses:</strong> {{ $diproses }}</p>
    <p><strong>Baru:</strong> {{ $baru }}</p>
    <p><strong>Tingkat Feedback:</strong> {{ $feedbackRate }}%</p>
    <p><strong>Rata-rata Waktu Penyelesaian:</strong> {{ $avgDays }} hari</p>
</div>

@endif

<div class="footer">
    Dicetak pada {{ date('d/m/Y H:i:s') }} oleh {{ auth()->user()->name }}
</div>

<div class="page-number">
    Halaman {PAGE_NUM} dari {PAGE_COUNT}
</div>

</body>
</html>