<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Pengaduan Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
                <p class="text-blue-200 text-sm">Sistem Pengaduan Sekolah</p>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" 
                   class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : '' }}">
                   <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.pengaduan.index') }}" 
                   class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('admin.pengaduan.*') ? 'bg-blue-700' : '' }}">
                   <i class="fas fa-exclamation-circle mr-2"></i> Pengaduan
                </a>
                <a href="{{ route('admin.kategori.index') }}" 
                   class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-700' : '' }}">
                   <i class="fas fa-list-alt mr-2"></i> Kategori
                </a>
                <a href="{{ route('admin.laporan.export') }}" 
                   class="block py-3 px-4 hover:bg-blue-700">
                   <i class="fas fa-file-pdf mr-2"></i> Export Laporan
                </a>
            </nav>
            <div class="absolute bottom-0 w-64 p-4 border-t border-blue-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center text-red-300 hover:text-white">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-white shadow">
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800">@yield('header')</h2>
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-600">
                                <i class="fas fa-user mr-1"></i> {{ auth()->user()->name }}
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>