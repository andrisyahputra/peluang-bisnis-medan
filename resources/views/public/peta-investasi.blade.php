@extends('layouts.public')

@section('title', 'Peta Investasi')
@section('description',
    'Peta investasi interaktif untuk melihat sebaran peluang bisnis dan potensi investasi di setiap
    wilayah.')

    @push('styles')
        <style>
            .kecamatan-polygon {
                transition: fill-opacity 0.2s ease;
            }

            .kecamatan-polygon:hover {
                fill-opacity: 0.6 !important;
            }

            .legend-item {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.25rem 0;
            }

            .legend-color {
                width: 20px;
                height: 20px;
                border-radius: 4px;
                border: 1px solid rgba(0, 0, 0, 0.2);
            }
        </style>
    @endpush

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Peta Investasi</h1>

        <div class="flex flex-col lg:flex-row gap-6">
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div id="investment-map" style="height: 550px;"></div>
                </div>
            </div>
            <div class="lg:w-80">
                <!-- Filter Sektor -->
                <div class="bg-white rounded-xl shadow-sm p-4 sticky top-20 mb-4">
                    <h3 class="font-bold text-lg mb-4">Filter Sektor</h3>
                    <div class="space-y-2">
                        @foreach ($sektors as $sektor)
                            <label class="flex items-center p-2 rounded hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" class="sector-filter w-4 h-4 rounded" value="{{ $sektor->id }}"
                                    checked style="accent-color: {{ $sektor->warna }}">
                                <span class="ml-3 text-lg">{{ $sektor->nama_sektor }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Legend Kecamatan -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <h3 class="font-bold text-lg mb-4">Legenda Kecamatan</h3>
                    <div class="space-y-1 max-h-64 overflow-y-auto" id="kecamatan-legend">
                        <p class="text-gray-500 text-lg">Memuat data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('investment-map').setView([3.5952, 98.6722], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let markers = [];
            let kecamatanLayers = [];

            // Load Kecamatan polygons
            async function loadKecamatanPolygons() {
                try {
                    const response = await fetch('/api/peta/kecamatan');
                    const data = await response.json();

                    if (data.success) {
                        const legendContainer = document.getElementById('kecamatan-legend');
                        legendContainer.innerHTML = '';

                        data.data.forEach(kecamatan => {
                            if (kecamatan.geojson_data) {
                                const geojson = kecamatan.geojson_data;
                                const warna = geojson.properties?.warna || '#3388ff';

                                const layer = L.geoJSON(geojson, {
                                    style: {
                                        color: warna,
                                        fillColor: warna,
                                        fillOpacity: 0.3,
                                        weight: 2
                                    },
                                    className: 'kecamatan-polygon',
                                    onEachFeature: function(feature, layer) {
                                        const popupContent = `
                                            <div class="p-2">
                                                <h4 class="font-bold text-lg">${kecamatan.nama_kecamatan}</h4>
                                                <p class="text-gray-600">Kode: ${kecamatan.kode_kecamatan}</p>
                                                <p class="text-blue-600 font-medium">${kecamatan.peluang_bisnis_count || 0} Peluang Bisnis</p>
                                            </div>
                                        `;
                                        layer.bindPopup(popupContent);
                                        layer.on('mouseover', function() {
                                            this.setStyle({
                                                fillOpacity: 0.6
                                            });
                                        });
                                        layer.on('mouseout', function() {
                                            this.setStyle({
                                                fillOpacity: 0.3
                                            });
                                        });
                                    }
                                }).addTo(map);

                                kecamatanLayers.push(layer);

                                // Add to legend
                                const legendItem = document.createElement('div');
                                legendItem.className = 'legend-item';
                                legendItem.innerHTML = `
                                    <div class="legend-color" style="background-color: ${warna}"></div>
                                    <span class="text-lg">${kecamatan.nama_kecamatan}</span>
                                `;
                                legendContainer.appendChild(legendItem);
                            }
                        });

                        if (kecamatanLayers.length === 0) {
                            legendContainer.innerHTML =
                                '<p class="text-gray-500 text-lg">Belum ada polygon kecamatan</p>';
                        }
                    }
                } catch (error) {
                    console.error('Error loading kecamatan:', error);
                }
            }

            async function loadMarkers() {
                const checkedSectors = Array.from(document.querySelectorAll('.sector-filter:checked')).map(cb =>
                    cb.value);
                // Clear existing markers
                markers.forEach(m => map.removeLayer(m));
                markers = [];

                try {
                    const response = await fetch('/api/peta/peluang-bisnis');
                    const data = await response.json();

                    if (data.success) {
                        data.data.forEach(item => {
                            if (checkedSectors.includes(String(item.sektor_id))) {
                                const icon = L.divIcon({
                                    html: `<div style="background-color: ${item.sektor.warna}; width: 24px; height: 24px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
                                    className: 'custom-marker',
                                    iconSize: [24, 24],
                                    iconAnchor: [12, 12]
                                });

                                const marker = L.marker([item.latitude, item.longitude], {
                                        icon
                                    })
                                    .bindPopup(
                                        `<div class="p-2">
                                            <strong class="text-lg">${item.nama_usaha}</strong>
                                            <br><span class="text-gray-600">${item.sektor.nama_sektor}</span>
                                            ${item.kecamatan ? `<br><span class="text-gray-500">${item.kecamatan.nama_kecamatan}</span>` : ''}
                                        </div>`
                                    )
                                    .addTo(map);

                                markers.push(marker);
                            }
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            document.querySelectorAll('.sector-filter').forEach(cb => {
                cb.addEventListener('change', loadMarkers);
            });

            // Load polygons first, then markers
            loadKecamatanPolygons();
            loadMarkers();
        });
    </script>
@endpush
