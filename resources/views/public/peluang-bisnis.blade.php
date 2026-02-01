@extends('layouts.public')

@section('title', 'Peluang Bisnis')
@section('description', 'Jelajahi peta peluang bisnis interaktif untuk menemukan potensi investasi berdasarkan sektor
dan lokasi kecamatan.')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar Filter -->
        <aside class="lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm p-4 sticky top-20">
                <h2 class="font-bold text-xl text-gray-800 mb-4 pb-2 border-b">SEKTOR UNGGULAN</h2>
                <div class="space-y-1">
                    <button data-filter="unggulan"
                        class="sidebar-item w-full text-left px-4 py-3 rounded-lg text-lg font-medium flex justify-between items-center">
                        <span><i class="fas fa-star text-yellow-500 mr-2"></i>Unggulan</span>
                        <span class="text-lg">({{ $totalUnggulan }})</span>
                    </button>
                    <button data-filter="all"
                        class="sidebar-item active w-full text-left px-4 py-3 rounded-lg text-lg font-medium flex justify-between items-center">
                        <span>Semua</span>
                        <span class="text-lg">({{ $totalSemua }})</span>
                    </button>
                    @foreach ($sektors as $sektor)
                    <button data-filter="sektor" data-sektor-id="{{ $sektor->id }}"
                        class="sidebar-item w-full text-left px-4 py-3 rounded-lg text-lg flex justify-between items-center hover:bg-gray-100">
                        <span class="flex items-center">
                            <span class="w-4 h-4 rounded-full mr-2"
                                style="background-color: {{ $sektor->warna }}"></span>
                            {{ $sektor->nama_sektor }}
                        </span>
                        <span class="text-lg text-gray-500">({{ $sektor->peluang_bisnis_count }})</span>
                    </button>
                    @endforeach
                </div>
            </div>
        </aside>

        <!-- Map Area -->
        <div class="flex-1">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                    <h1 class="text-xl font-bold text-white text-center">PETA PELUANG BISNIS KOTA MEDAN</h1>
                </div>
                <div class="relative">
                    <div id="map"></div>
                    <!-- Legend -->
                    <div class="absolute bottom-4 left-4 bg-white rounded-lg shadow-lg p-4 z-[1000] max-w-xs">
                        <h4 class="font-bold text-lg mb-2">Keterangan</h4>
                        <div id="legend-container">
                            @foreach ($sektors as $sektor)
                            <div class="legend-item">
                                <div class="legend-color text-white" style="background-color: {{ $sektor->warna }}">
                                    <i class="fas {{ $sektor->ikon ?? 'fa-circle' }} text-xs"></i>
                                </div>
                                <span>{{ $sektor->nama_sektor }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6" id="info-cards">
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-blue-500 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-800" id="total-display">{{ $totalSemua }}</div>
                            <div class="text-gray-500 text-lg">Total Peluang</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                            <i class="fas fa-star text-yellow-500 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-800">{{ $totalUnggulan }}</div>
                            <div class="text-gray-500 text-lg">Unggulan</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-building text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-800">{{ $kecamatans->count() }}</div>
                            <div class="text-gray-500 text-lg">Kecamatan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map centered on Medan
        const map = L.map('map').setView([3.5952, 98.6722], 12);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let markerClusterGroup = L.markerClusterGroup();
        map.addLayer(markerClusterGroup);

        let markers = [];
        let polygons = [];
        let currentFilter = 'all';
        let currentSektorId = null;

        // Fetch and display data
        async function loadData() {
            try {
                const [kecamatansRes, peluangRes] = await Promise.all([
                    fetch('/api/peta/kecamatans'),
                    fetch('/api/peta/peluang-bisnis')
                ]);

                const kecamatans = await kecamatansRes.json();
                const peluang = await peluangRes.json();

                // Draw kecamatan polygons
                if (kecamatans.success) {
                    kecamatans.data.forEach(kec => {
                        if (kec.geojson_data) {
                            const polygon = L.geoJSON(kec.geojson_data, {
                                style: {
                                    fillColor: kec.warna || '#3388ff',
                                    fillOpacity: 0.2,
                                    color: kec.warna || '#3388ff',
                                    weight: 2
                                },
                                onEachFeature: (feature, layer) => {
                                    layer.bindPopup(`
                                    <div class="text-center">
                                        <strong class="text-lg">Kec. ${kec.nama_kecamatan}</strong><br>
                                        <span class="text-lg">${kec.peluang_bisnis_count} peluang bisnis</span>
                                    </div>
                                `);
                                    layer.on('mouseover', function() {
                                        this.setStyle({
                                            fillOpacity: 0.5
                                        });
                                    });
                                    layer.on('mouseout', function() {
                                        this.setStyle({
                                            fillOpacity: 0.2
                                        });
                                    });
                                }
                            }).addTo(map);
                            polygons.push(polygon);
                        }
                    });
                }

                // Add markers for peluang bisnis
                if (peluang.success) {
                    displayMarkers(peluang.data);
                }
            } catch (error) {
                console.error('Error loading data:', error);
            }
        }

        function displayMarkers(data) {
            // Clear existing markers
            markerClusterGroup.clearLayers();
            markers = [];

            data.forEach(item => {
                const icon = L.divIcon({
                    html: `<div style="background-color: ${item.sektor.warna}; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; border: 2px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                    <i class="fas ${item.sektor.ikon || 'fa-briefcase'}"></i>
                </div>`,
                    className: 'custom-marker',
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                });

                const marker = L.marker([item.latitude, item.longitude], {
                        icon
                    })
                    .bindPopup(`
                    <div class="min-w-[200px] max-w-[300px]">
                        ${item.gambar ? `
                            <div class="mb-3 relative h-40 w-full overflow-hidden rounded-lg">
                                <img src="/storage/${item.gambar}" alt="${item.nama_usaha}" class="absolute inset-0 w-full h-full object-cover">
                            </div>
                        ` : ''}
                        <h3 class="font-bold text-lg mb-2 leading-tight">${item.nama_usaha}</h3>
                        <p class="text-sm text-gray-600 mb-1 flex items-center">
                            <span class="inline-block w-6 text-center mr-1"><i class="fas fa-tag"></i></span>
                            ${item.sektor.nama_sektor}
                        </p>
                        <p class="text-sm text-gray-600 mb-1 flex items-center">
                            <span class="inline-block w-6 text-center mr-1"><i class="fas fa-map-marker-alt"></i></span>
                            ${item.kecamatan.nama_kecamatan}
                        </p>
                        ${item.status_unggulan ? `
                            <div class="mt-2 mb-2">
                                <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-medium">
                                    <i class="fas fa-star mr-1"></i>Unggulan
                                </span>
                            </div>` : ''}
                        ${item.deskripsi ? `<p class="text-sm text-gray-500 mt-2 line-clamp-3">${item.deskripsi}</p>` : ''}
                        
                        <div class="mt-3 pt-3 border-t border-gray-100 text-right">
                            <a href="#" class="text-primary-600 hover:text-primary-700 text-sm font-medium inline-flex items-center">
                                Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                `);

                markerClusterGroup.addLayer(marker);
                markers.push(marker);
            });

            document.getElementById('total-display').textContent = data.length;
        }

        async function filterData(type, sektorId = null) {
            let url = '/api/peta/peluang-bisnis?';
            if (type === 'unggulan') {
                url += 'unggulan=true';
            } else if (type === 'sektor' && sektorId) {
                url += `sektor_id=${sektorId}`;
            }

            try {
                const response = await fetch(url);
                const data = await response.json();
                if (data.success) {
                    displayMarkers(data.data);
                }
            } catch (error) {
                console.error('Error filtering data:', error);
            }
        }

        // Filter buttons
        document.querySelectorAll('.sidebar-item').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-item').forEach(b => b.classList.remove(
                    'active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                const sektorId = this.dataset.sektorId;

                filterData(filter, sektorId);
            });
        });

        // Load initial data
        loadData();
    });
</script>
@endpush