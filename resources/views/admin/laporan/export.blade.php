<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengaduan Sarana Sekolah</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #2c5282;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #2c5282;
            margin: 0 0 5px 0;
            font-size: 22px;
            font-weight: bold;
        }
        .header p {
            color: #666;
            margin: 3px 0;
            font-size: 12px;
        }
        .header .subtitle {
            color: #2c5282;
            font-weight: bold;
            margin-top: 5px;
        }
        .info-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 4px;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10px;
        }
        th {
            background-color: #2c5282;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #2c5282;
        }
        td {
            padding: 6px 8px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        tr:hover {
            background-color: #f1f5f9;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
            text-align: center;
            min-width: 60px;
        }
        .status-baru {
            background-color: #bee3f8;
            color: #2c5282;
        }
        .status-diproses {
            background-color: #fefcbf;
            color: #744210;
        }
        .status-selesai {
            background-color: #c6f6d5;
            color: #22543d;
        }
        .priority-badge {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
            text-align: center;
            min-width: 50px;
        }
        .priority-rendah {
            background-color: #c6f6d5;
            color: #22543d;
        }
        .priority-sedang {
            background-color: #fefcbf;
            color: #744210;
        }
        .priority-tinggi {
            background-color: #fed7d7;
            color: #c53030;
        }
        .summary-stats {
            display: flex;
            justify-content: space-around;
            margin: 15px 0;
            text-align: center;
            background: linear-gradient(to right, #f7fafc, #edf2f7, #f7fafc);
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e2e8f0;
        }
        .stat-item {
            flex: 1;
            padding: 5px;
        }
        .stat-item .number {
            font-size: 18px;
            font-weight: bold;
            display: block;
            margin-bottom: 3px;
        }
        .stat-item .label {
            font-size: 10px;
            color: #666;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            color: #666;
        }
        .signature {
            margin-top: 40px;
            float: right;
            text-align: center;
            width: 250px;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #333;
            margin: 30px auto 5px;
            text-align: center;
            padding-top: 5px;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo {
            display: inline-block;
            width: 80px;
            height: 80px;
            background-color: #2c5282;
            color: white;
            border-radius: 50%;
            line-height: 80px;
            font-size: 30px;
            margin-bottom: 10px;
        }
        .page-number {
            position: fixed;
            bottom: 10px;
            right: 20px;
            font-size: 10px;
            color: #666;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .font-bold {
            font-weight: bold;
        }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        .mb-3 { margin-bottom: 15px; }
        .mt-1 { margin-top: 5px; }
        .mt-2 { margin-top: 10px; }
        .mt-3 { margin-top: 15px; }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Logo dan Kop Sekolah -->
    <div class="logo-container">
        <div class="logo">
            <i class="fas fa-school"></i>
        </div>
        <div>
            <h2 style="margin: 0; color: #2c5282; font-size: 14px;">SEKOLAH MENENGAH ATAS NEGERI 1</h2>
            <p style="margin: 0; color: #666; font-size: 11px;">Jl. Pendidikan No. 123, Kota Pelajar</p>
            <p style="margin: 0; color: #666; font-size: 11px;">Telp: (021) 123456 | Email: sekolah@sman1.sch.id</p>
        </div>
    </div>

    <!-- Header Laporan -->
    <div class="header">
        <h1>LAPORAN PENGADUAN SARANA SEKOLAH</h1>
        <p class="subtitle">SISTEM INFORMASI PENGADUAN SARANA DAN PRASARANA</p>
        <p>Periode: {{ request('start_date') ? date('d F Y', strtotime(request('start_date'))) : 'Semua Waktu' }} 
           s/d {{ request('end_date') ? date('d F Y', strtotime(request('end_date'))) : date('d F Y') }}</p>
    </div>

    <!-- Informasi Filter -->
    <div class="info-box">
        <div class="info-row">
            <span class="font-bold">Tanggal Cetak:</span>
            <span>{{ date('d/m/Y H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span class="font-bold">Status Filter:</span>
            <span>
                @if(request('status') && request('status') != 'all')
                    {{ ucfirst(request('status')) }}
                @else
                    Semua Status
                @endif
            </span>
        </div>
        <div class="info-row">
            <span class="font-bold">Kategori Filter:</span>
            <span>
                @if(request('kategori') && request('kategori') != 'all')
                    @php
                        $kategori = \App\Models\KategoriSarana::find(request('kategori'));
                    @endphp
                    {{ $kategori ? $kategori->nama_kategori : 'Semua Kategori' }}
                @else
                    Semua Kategori
                @endif
            </span>
        </div>
        <div class="info-row">
            <span class="font-bold">Dibuat Oleh:</span>
            <span>{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
        </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="summary-stats">
        <div class="stat-item">
            <span class="number" style="color: #2c5282;">{{ $total }}</span>
            <span class="label">Total Pengaduan</span>
        </div>
        <div class="stat-item">
            <span class="number" style="color: #22543d;">{{ $selesai }}</span>
            <span class="label">Selesai</span>
        </div>
        <div class="stat-item">
            <span class="number" style="color: #744210;">{{ $diproses }}</span>
            <span class="label">Diproses</span>
        </div>
        <div class="stat-item">
            <span class="number" style="color: #c53030;">{{ $baru }}</span>
            <span class="label">Baru</span>
        </div>
        <div class="stat-item">
            <span class="number" style="color: #4c51bf;">
                {{ number_format($selesai > 0 ? ($selesai / $total * 100) : 0, 1) }}%
            </span>
            <span class="label">Tingkat Penyelesaian</span>
        </div>
    </div>

    <!-- Tabel Data Pengaduan -->
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Tanggal</th>
                <th width="120">Siswa</th>
                <th width="150">Judul Pengaduan</th>
                <th width="100">Kategori</th>
                <th width="80">Status</th>
                <th width="70">Prioritas</th>
                <th width="100">Lokasi</th>
                <th width="80">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengaduan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->tanggal_pengaduan->format('d/m/Y') }}</td>
                <td>
                    <div class="font-bold">{{ $item->siswa->nama }}</div>
                    <div style="font-size: 9px; color: #666;">{{ $item->siswa->kelas }} | NIS: {{ $item->siswa->nis }}</div>
                </td>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->kategori->nama_kategori }}</td>
                <td class="text-center">
                    <span class="status-badge status-{{ $item->status }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td class="text-center">
                    <span class="priority-badge priority-{{ $item->prioritas }}">
                        {{ ucfirst($item->prioritas) }}
                    </span>
                </td>
                <td>{{ $item->lokasi }}</td>
                <td>
                    @if($item->feedback->count() > 0)
                    <span style="color: #22543d; font-size: 9px;">
                        <i class="fas fa-comment"></i> Ada feedback
                    </span>
                    @else
                    <span style="color: #666; font-size: 9px;">-</span>
                    @endif
                </td>
            </tr>
            
            @if($item->feedback->count() > 0 && $item->status == 'selesai')
            <tr style="background-color: #f0fff4;">
                <td colspan="9" style="padding: 5px 8px; font-size: 9px;">
                    <strong>Feedback Admin:</strong> 
                    {{ $item->feedback->last()->isi_feedback }}
                    <span style="float: right; color: #666;">
                        {{ $item->feedback->last()->admin->nama }} - 
                        {{ $item->feedback->last()->created_at->format('d/m/Y') }}
                    </span>
                </td>
            </tr>
            @endif
            
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 20px; color: #666;">
                    <i>Tidak ada data pengaduan pada periode ini.</i>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Grafik Ringkasan (Text-based) -->
    @if($pengaduan->count() > 0)
    <div style="margin-top: 25px; padding: 15px; background-color: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0;">
        <h3 style="margin: 0 0 10px 0; color: #2c5282; font-size: 12px;">ANALISIS DATA</h3>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <div style="flex: 1; padding: 5px;">
                <div style="font-size: 10px; color: #666; margin-bottom: 3px;">Kategori Terbanyak</div>
                <div style="font-size: 11px; font-weight: bold;">
                    @php
                        $kategoriCounts = [];
                        foreach($pengaduan as $item) {
                            $kategoriName = $item->kategori->nama_kategori;
                            $kategoriCounts[$kategoriName] = isset($kategoriCounts[$kategoriName]) ? 
                                $kategoriCounts[$kategoriName] + 1 : 1;
                        }
                        arsort($kategoriCounts);
                        $topKategori = key($kategoriCounts);
                    @endphp
                    {{ $topKategori }} ({{ $kategoriCounts[$topKategori] ?? 0 }} laporan)
                </div>
            </div>
            
            <div style="flex: 1; padding: 5px;">
                <div style="font-size: 10px; color: #666; margin-bottom: 3px;">Waktu Respons Rata-rata</div>
                <div style="font-size: 11px; font-weight: bold;">
                    @php
                        $totalDays = 0;
                        $count = 0;
                        foreach($pengaduan->where('status', 'selesai') as $item) {
                            if($item->historiStatus->count() > 0) {
                                $created = $item->created_at;
                                $completed = $item->historiStatus->where('status_sesudah', 'selesai')->first();
                                if($completed) {
                                    $diff = $created->diffInDays($completed->created_at);
                                    $totalDays += $diff;
                                    $count++;
                                }
                            }
                        }
                        $avgDays = $count > 0 ? round($totalDays / $count, 1) : 0;
                    @endphp
                    {{ $avgDays }} hari
                </div>
            </div>
            
            <div style="flex: 1; padding: 5px;">
                <div style="font-size: 10px; color: #666; margin-bottom: 3px;">Tingkat Kepuasan</div>
                <div style="font-size: 11px; font-weight: bold;">
                    @php
                        $withFeedback = $pengaduan->where('feedback_count', '>', 0)->count();
                        $feedbackRate = $total > 0 ? round(($withFeedback / $total) * 100, 1) : 0;
                    @endphp
                    {{ $feedbackRate }}% ({{ $withFeedback }}/{{ $total }})
                </div>
            </div>
        </div>
        
        <!-- Progress Bar untuk Status -->
        <div style="margin-top: 10px;">
            <div style="font-size: 10px; color: #666; margin-bottom: 5px;">Distribusi Status:</div>
            <div style="display: flex; height: 20px; border-radius: 10px; overflow: hidden; margin-bottom: 5px;">
                @if($total > 0)
                <div style="width: {{ ($baru/$total)*100 }}%; background-color: #bee3f8;" title="Baru: {{ $baru }}"></div>
                <div style="width: {{ ($diproses/$total)*100 }}%; background-color: #fefcbf;" title="Diproses: {{ $diproses }}"></div>
                <div style="width: {{ ($selesai/$total)*100 }}%; background-color: #c6f6d5;" title="Selesai: {{ $selesai }}"></div>
                @endif
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 9px;">
                <span>Baru: {{ $baru }} ({{ $total > 0 ? round(($baru/$total)*100, 1) : 0 }}%)</span>
                <span>Diproses: {{ $diproses }} ({{ $total > 0 ? round(($diproses/$total)*100, 1) : 0 }}%)</span>
                <span>Selesai: {{ $selesai }} ({{ $total > 0 ? round(($selesai/$total)*100, 1) : 0 }}%)</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Footer dan Tanda Tangan -->
    <div style="clear: both; margin-top: 30px;"></div>
    
    <div class="footer">
        <div style="float: left; width: 60%; text-align: left; font-size: 10px; color: #666;">
            <p><strong>Catatan:</strong></p>
            <p>1. Laporan ini dihasilkan otomatis oleh Sistem Pengaduan Sarana Sekolah</p>
            <p>2. Data bersifat dinamis dan dapat berubah setiap saat</p>
            <p>3. Untuk informasi lebih lanjut, hubungi administrator sistem</p>
        </div>
        
        <div class="signature">
            <p style="margin-bottom: 40px;">Kota Pelajar, {{ date('d F Y') }}</p>
            <div class="signature-line"></div>
            <p style="margin-top: 5px; font-weight: bold;">{{ auth()->user()->name }}</p>
            <p style="font-size: 10px; margin: 0;">Administrator Sistem</p>
            <p style="font-size: 10px; margin: 0;">SMA Negeri 1 Kota Pelajar</p>
        </div>
    </div>

    <!-- Nomor Halaman -->
    <div class="page-number">
        Halaman <span class="page"></span>
    </div>

    <!-- Script untuk nomor halaman -->
    <script type="text/javascript">
        var totalPages = Math.ceil({{ $pengaduan->count() }} / 20); // 20 per halaman
        for(var i = 1; i <= totalPages; i++) {
            var div = document.createElement("div");
            div.className = "page-break";
            div.innerHTML = "<div class='page-number'>Halaman " + i + " dari " + totalPages + "</div>";
            document.body.appendChild(div);
        }
        
        // Update nomor halaman
        var pages = document.getElementsByClassName('page');
        for(var i = 0; i < pages.length; i++) {
            pages[i].innerHTML = (i + 1) + " dari " + totalPages;
        }
    </script>
</body>
</html>