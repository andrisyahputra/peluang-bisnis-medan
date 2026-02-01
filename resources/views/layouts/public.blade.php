<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Peta Peluang Bisnis') </title>
    <meta name="description" content="@yield('description', 'Eksplorasi peta peluang bisnis interaktif untuk menemukan potensi investasi dan sektor unggulan di kota kami.')">
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
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#1e3a5f',
                            600: '#163050',
                            700: '#0f2640',
                            800: '#0a1c30',
                            900: '#051220',
                        },
                        accent: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .nav-link {
            position: relative;
            transition: color 0.3s;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #f59e0b;
            transition: width 0.3s;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .sidebar-item {
            transition: all 0.2s;
        }

        .sidebar-item:hover,
        .sidebar-item.active {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
            color: white;
        }

        #map {
            height: 600px;
            width: 100%;
            border-radius: 0.5rem;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 8px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-primary-500 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('beranda') }}" class="flex items-center space-x-3">
                    <div class="bg-white rounded-lg p-2">
                        <i class="fas fa-map-marked-alt text-primary-500 text-xl"></i>
                    </div>
                    <div>
                        <span class="font-bold text-lg">PETA PELUANG</span>
                        <span class="text-accent-400 font-bold text-lg">BISNIS</span>
                    </div>
                </a>
                <!-- Navigation -->
                <nav class="hidden lg:flex items-center space-x-6">
                    <a href="{{ route('beranda') }}"
                        class="nav-link text-lg {{ request()->routeIs('beranda') ? 'active text-accent-400' : 'hover:text-accent-400' }}">Beranda</a>
                    <!-- <a href="{{ route('profil-kota') }}"
                        class="nav-link text-lg {{ request()->routeIs('profil-kota') ? 'active text-accent-400' : 'hover:text-accent-400' }}">Profil
                        Kota</a>
                    <a href="{{ route('potensi-investasi') }}"
                        class="nav-link text-lg {{ request()->routeIs('potensi-investasi') ? 'active text-accent-400' : 'hover:text-accent-400' }}">Potensi
                        Investasi</a> -->
                    <a href="{{ route('peluang-bisnis') }}"
                        class="nav-link text-lg {{ request()->routeIs('peluang-bisnis') ? 'active text-accent-400' : 'hover:text-accent-400' }}">Peluang
                        Bisnis</a>
                    <!-- <div class="relative group">
                        <a href="{{ route('insentif') }}"
                            class="nav-link text-lg flex items-center {{ request()->routeIs('insentif') ? 'active text-accent-400' : 'hover:text-accent-400' }}">
                            Insentif
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </a>
                    </div>
                    <a href="{{ route('rdtr-interaktif') }}"
                        class="nav-link text-lg {{ request()->routeIs('rdtr-interaktif') ? 'active text-accent-400' : 'hover:text-accent-400' }}">RDTR
                        Interaktif</a>
                    <a href="{{ route('peta-investasi') }}"
                        class="nav-link text-lg {{ request()->routeIs('peta-investasi') ? 'active text-accent-400' : 'hover:text-accent-400' }}">Peta
                        Investasi</a> -->
                </nav>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="lg:hidden text-white">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden hidden bg-primary-600">
            <div class="container mx-auto px-4 py-4 space-y-3">
                <!-- <a href="{{ route('beranda') }}"
                    class="block text-lg py-2 {{ request()->routeIs('beranda') ? 'text-accent-400' : '' }}">Beranda</a>
                <a href="{{ route('profil-kota') }}"
                    class="block text-lg py-2 {{ request()->routeIs('profil-kota') ? 'text-accent-400' : '' }}">Profil
                    Kota</a> -->
                <!-- <a href="{{ route('potensi-investasi') }}"
                    class="block text-lg py-2 {{ request()->routeIs('potensi-investasi') ? 'text-accent-400' : '' }}">Potensi
                    Investasi</a> -->
                <a href="{{ route('peluang-bisnis') }}"
                    class="block text-lg py-2 {{ request()->routeIs('peluang-bisnis') ? 'text-accent-400' : '' }}">Peluang
                    Bisnis</a>
                <!-- <a href="{{ route('insentif') }}"
                    class="block text-lg py-2 {{ request()->routeIs('insentif') ? 'text-accent-400' : '' }}">Insentif</a> -->
                <!-- <a href="{{ route('rdtr-interaktif') }}"
                    class="block text-lg py-2 {{ request()->routeIs('rdtr-interaktif') ? 'text-accent-400' : '' }}">RDTR
                    Interaktif</a> -->
                <!-- <a href="{{ route('peta-investasi') }}"
                    class="block text-lg py-2 {{ request()->routeIs('peta-investasi') ? 'text-accent-400' : '' }}">Peta
                    Investasi</a> -->
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <!-- <footer class="bg-primary-700 text-white mt-auto">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="font-bold text-xl mb-4">Peta Peluang Bisnis</h3>
                    <p class="text-gray-300 text-lg">Platform informasi potensi investasi dan peluang bisnis untuk
                        mendukung pertumbuhan ekonomi daerah.</p>
                </div>
                <div>
                    <h3 class="font-bold text-xl mb-4">Menu Cepat</h3>
                    <ul class="space-y-2 text-lg">
                        <li><a href="{{ route('peluang-bisnis') }}" class="text-gray-300 hover:text-accent-400">Peluang
                                Bisnis</a></li>
                        <li><a href="{{ route('potensi-investasi') }}"
                                class="text-gray-300 hover:text-accent-400">Potensi Investasi</a></li>
                        <li><a href="{{ route('peta-investasi') }}" class="text-gray-300 hover:text-accent-400">Peta
                                Investasi</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-xl mb-4">Kontak</h3>
                    <ul class="space-y-2 text-gray-300 text-lg">
                        <li><i class="fas fa-envelope mr-2"></i> info@pemkot.go.id</li>
                        <li><i class="fas fa-phone mr-2"></i> (061) 123-4567</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Jl. Kapten Maulana Lubis No. 2</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer> -->

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>

</html>
