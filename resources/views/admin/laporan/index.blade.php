@extends('layouts.admin')

@section('title', 'Export Laporan')
@section('header', 'Export Laporan Pengaduan')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Export Laporan Pengaduan</h2>
        <p class="text-gray-600 mt-2">Ekspor data pengaduan dalam format PDF untuk keperluan dokumentasi dan analisis</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6">
                <form action="{{ route('admin.laporan.export') }}" method="GET" target="_blank">
                    <div class="space-y-6">
                        <!-- Periode Waktu -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-700 mb-4">
                                <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                Periode Waktu
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Mulai
                                    </label>
                                    <input type="date" name="start_date" 
                                           value="{{ request('start_date', date('Y-m-d', strtotime('-1 month'))) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Selesai
                                    </label>
                                    <input type="date" name="end_date" 
                                           value="{{ request('end_date', date('Y-m-d')) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div class="mt-3 flex items-center space-x-4">
                                <button type="button" onclick="setDateRange('today')" 
                                        class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                    Hari Ini
                                </button>
                                <button type="button" onclick="setDateRange('week')" 
                                        class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                    7 Hari Terakhir
                                </button>
                                <button type="button" onclick="setDateRange('month')" 
                                        class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                    30 Hari Terakhir
                                </button>
                                <button type="button" onclick="setDateRange('all')" 
                                        class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                    Semua
                                </button>
                            </div>
                        </div>

                        <!-- Filter Status -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-700 mb-4">
                                <i class="fas fa-filter mr-2 text-blue-500"></i>
                                Filter Status
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50
                                    {{ request('status') == 'all' || !request('status') ? 'border-blue-500 bg-blue-50' : '' }}">
                                    <input type="radio" name="status" value="all" 
                                           {{ !request('status') || request('status') == 'all' ? 'checked' : '' }}
                                           class="mr-3 text-blue-600 focus:ring-blue-500">
                                    <div>
                                        <div class="font-medium">Semua Status</div>
                                        <div class="text-sm text-gray-500">Tampilkan semua pengaduan</div>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50
                                    {{ request('status') == 'selesai' ? 'border-green-500 bg-green-50' : '' }}">
                                    <input type="radio" name="status" value="selesai" 
                                           {{ request('status') == 'selesai' ? 'checked' : '' }}
                                           class="mr-3 text-green-600 focus:ring-green-500">
                                    <div>
                                        <div class="font-medium">Selesai</div>
                                        <div class="text-sm text-gray-500">Pengaduan yang sudah ditangani</div>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50
                                    {{ request('status') == 'diproses' ? 'border-yellow-500 bg-yellow-50' : '' }}">
                                    <input type="radio" name="status" value="diproses" 
                                           {{ request('status') == 'diproses' ? 'checked' : '' }}
                                           class="mr-3 text-yellow-600 focus:ring-yellow-500">
                                    <div>
                                        <div class="font-medium">Diproses</div>
                                        <div class="text-sm text-gray-500">Sedang dalam penanganan</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Filter Kategori -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-700 mb-4">
                                <i class="fas fa-tags mr-2 text-blue-500"></i>
                                Filter Kategori
                            </h3>
                            <select name="kategori" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="all">Semua Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" 
                                            {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Options -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-700 mb-4">
                                <i class="fas fa-cog mr-2 text-blue-500"></i>
                                Opsi Laporan
                            </h3>
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_feedback" value="1" 
                                           {{ request('include_feedback', true) ? 'checked' : '' }}
                                           class="mr-3 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">Sertakan feedback dari admin</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_photos" value="1" 
                                           {{ request('include_photos', false) ? 'checked' : '' }}
                                           class="mr-3 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">Sertakan daftar foto pendukung</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_history" value="1" 
                                           {{ request('include_history', true) ? 'checked' : '' }}
                                           class="mr-3 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">Sertakan riwayat perubahan status</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_stats" value="1" 
                                           {{ request('include_stats', true) ? 'checked' : '' }}
                                           class="mr-3 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">Sertakan analisis statistik</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6 border-t">
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition flex items-center justify-center">
                                <i class="fas fa-file-pdf mr-2"></i> Generate PDF Report
                            </button>
                            <p class="text-sm text-gray-500 text-center mt-3">
                                Laporan akan di-generate dalam format PDF dan dapat diunduh
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column: Preview & Stats -->
        <div class="space-y-6">
            <!-- Preview Card -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">
                    <i class="fas fa-eye mr-2 text-blue-500"></i>
                    Preview Laporan
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Jumlah Data:</span>
                        <span class="font-medium">{{ $totalData }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Periode:</span>
                        <span class="font-medium text-sm">
                            {{ request('start_date', date('Y-m-d', strtotime('-1 month'))) }} 
                            s/d 
                            {{ request('end_date', date('Y-m-d')) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Format:</span>
                        <span class="font-medium">PDF (Portable Document Format)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Estimasi Halaman:</span>
                        <span class="font-medium">{{ ceil($totalData / 20) }} halaman</span>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h4 class="font-medium text-gray-700 mb-2">Informasi Laporan</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Format profesional</li>
                        <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Dilengkapi kop sekolah</li>
                        <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Tanda tangan digital</li>
                        <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Analisis statistik</li>
                    </ul>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">
                    <i class="fas fa-chart-bar mr-2 text-blue-500"></i>
                    Statistik Cepat
                </h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Selesai</span>
                            <span class="text-sm font-medium text-gray-700">
                                {{ $selesaiCount }} ({{ $totalData > 0 ? round(($selesaiCount/$totalData)*100, 1) : 0 }}%)
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" 
                                 style="width: {{ $totalData > 0 ? ($selesaiCount/$totalData)*100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Diproses</span>
                            <span class="text-sm font-medium text-gray-700">
                                {{ $diprosesCount }} ({{ $totalData > 0 ? round(($diprosesCount/$totalData)*100, 1) : 0 }}%)
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" 
                                 style="width: {{ $totalData > 0 ? ($diprosesCount/$totalData)*100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Baru</span>
                            <span class="text-sm font-medium text-gray-700">
                                {{ $baruCount }} ({{ $totalData > 0 ? round(($baruCount/$totalData)*100, 1) : 0 }}%)
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" 
                                 style="width: {{ $totalData > 0 ? ($baruCount/$totalData)*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-4 border-t">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $totalData }}</div>
                        <div class="text-sm text-gray-600">Total Pengaduan</div>
                    </div>
                </div>
            </div>

            <!-- Recent Reports -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">
                    <i class="fas fa-history mr-2 text-blue-500"></i>
                    Laporan Terakhir
                </h3>
                <div class="space-y-3">
                    @forelse($recentReports as $report)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <div class="font-medium text-gray-900 text-sm">{{ $report->name }}</div>
                            <div class="text-xs text-gray-500">{{ $report->date->format('d/m/Y H:i') }}</div>
                        </div>
                        <a href="{{ $report->url }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-4">
                        <i class="fas fa-file-pdf text-2xl mb-2"></i>
                        <p class="text-sm">Belum ada laporan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Information Card -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 text-xl mt-1 mr-3"></i>
            <div>
                <h4 class="font-medium text-blue-800 mb-2">Panduan Export Laporan</h4>
                <ul class="text-blue-700 text-sm space-y-1">
                    <li><i class="fas fa-check-circle mr-2"></i> Pilih periode waktu yang diinginkan</li>
                    <li><i class="fas fa-check-circle mr-2"></i> Filter berdasarkan status dan kategori jika diperlukan</li>
                    <li><i class="fas fa-check-circle mr-2"></i> Pilih opsi tambahan yang ingin disertakan</li>
                    <li><i class="fas fa-check-circle mr-2"></i> Klik "Generate PDF Report" untuk membuat laporan</li>
                    <li><i class="fas fa-check-circle mr-2"></i> Laporan akan terbuka di tab baru dan dapat diunduh</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function setDateRange(range) {
        const today = new Date();
        const startDate = document.querySelector('input[name="start_date"]');
        const endDate = document.querySelector('input[name="end_date"]');
        
        endDate.value = today.toISOString().split('T')[0];
        
        switch(range) {
            case 'today':
                startDate.value = today.toISOString().split('T')[0];
                break;
            case 'week':
                const lastWeek = new Date(today);
                lastWeek.setDate(today.getDate() - 7);
                startDate.value = lastWeek.toISOString().split('T')[0];
                break;
            case 'month':
                const lastMonth = new Date(today);
                lastMonth.setMonth(today.getMonth() - 1);
                startDate.value = lastMonth.toISOString().split('T')[0];
                break;
            case 'all':
                startDate.value = '2024-01-01'; // Atau tanggal awal data
                break;
        }
    }
    
    // Preview update ketika filter berubah
    document.querySelectorAll('input[name="status"], input[name="start_date"], input[name="end_date"]').forEach(input => {
        input.addEventListener('change', function() {
            // Di sini bisa ditambahkan AJAX untuk update preview stats
            // Untuk sekarang, cukup reload halaman
            this.closest('form').submit();
        });
    });
</script>
@endpush
@endsection