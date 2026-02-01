<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Panel</title>
    <meta name="description" content="Panel administrasi untuk mengelola data peta peluang bisnis.">
    <!-- Favicon -->
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#1e3a5f',
                            600: '#163050',
                            700: '#0f2640',
                        },
                        accent: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .sidebar-link {
            transition: all 0.2s;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: rgba(245, 158, 11, 0.1);
            border-left: 3px solid #f59e0b;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-primary-700 text-white fixed h-full overflow-y-auto">
            <div class="p-4 border-b border-primary-600">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    <div class="bg-white rounded-lg p-2">
                        <i class="fas fa-map-marked-alt text-primary-500"></i>
                    </div>
                    <span class="font-bold text-lg">Admin Panel</span>
                </a>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link flex items-center px-4 py-3 text-lg {{ request()->routeIs('admin.dashboard') ? 'active bg-primary-600' : '' }}">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span>Dashboard</span>
                </a>
                <div class="px-4 py-2 text-xs uppercase text-gray-400 mt-4">Data Master</div>
                <a href="{{ route('admin.sektor.index') }}"
                    class="sidebar-link flex items-center px-4 py-3 text-lg {{ request()->routeIs('admin.sektor.*') ? 'active bg-primary-600' : '' }}">
                    <i class="fas fa-layer-group w-6"></i>
                    <span>Sektor</span>
                </a>
                <a href="{{ route('admin.kecamatan.index') }}"
                    class="sidebar-link flex items-center px-4 py-3 text-lg {{ request()->routeIs('admin.kecamatan.*') ? 'active bg-primary-600' : '' }}">
                    <i class="fas fa-map w-6"></i>
                    <span>Kecamatan</span>
                </a>
                <a href="{{ route('admin.peluang-bisnis.index') }}"
                    class="sidebar-link flex items-center px-4 py-3 text-lg {{ request()->routeIs('admin.peluang-bisnis.*') ? 'active bg-primary-600' : '' }}">
                    <i class="fas fa-briefcase w-6"></i>
                    <span>Peluang Bisnis</span>
                </a>
                <div class="px-4 py-2 text-xs uppercase text-gray-400 mt-4">Lainnya</div>
                <a href="{{ route('beranda') }}" class="sidebar-link flex items-center px-4 py-3 text-lg"
                    target="_blank">
                    <i class="fas fa-external-link-alt w-6"></i>
                    <span>Lihat Situs</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="sidebar-link flex items-center px-4 py-3 w-full text-left text-lg text-red-400 hover:text-red-300">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="flex items-center justify-between px-6 py-4">
                    <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-lg text-gray-600">{{ auth()->user()->nama }}</span>
                        <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white">
                            {{ substr(auth()->user()->nama, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded text-lg"
                        role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded text-lg"
                        role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
