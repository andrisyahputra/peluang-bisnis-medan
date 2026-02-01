@extends('layouts.admin')

@section('title', 'Tambah Kecamatan')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <style>
        #polygon-map {
            height: 400px;
            border-radius: 0.5rem;
            z-index: 1;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Tambah Kecamatan Baru</h2>
            </div>

            <form action="{{ route('admin.kecamatan.store') }}" method="POST" class="p-6" noValidate>
                @csrf

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nama_kecamatan" class="block text-lg font-medium text-gray-700 mb-2">Nama Kecamatan
                            *</label>
                        <input type="text" id="nama_kecamatan" name="nama_kecamatan" value="{{ old('nama_kecamatan') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg @error('nama_kecamatan') border-red-500 @enderror">
                        @error('nama_kecamatan')
                            <p class="mt-1 text-lg text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kode_kecamatan" class="block text-lg font-medium text-gray-700 mb-2">Kode Kecamatan
                            *</label>
                        <input type="text" id="kode_kecamatan" name="kode_kecamatan" value="{{ old('kode_kecamatan') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg @error('kode_kecamatan') border-red-500 @enderror">
                        @error('kode_kecamatan')
                            <p class="mt-1 text-lg text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="luas_wilayah" class="block text-lg font-medium text-gray-700 mb-2">Luas Wilayah
                            (Ha)</label>
                        <input type="number" id="luas_wilayah" name="luas_wilayah" value="{{ old('luas_wilayah') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">
                    </div>

                    <div>
                        <label for="jumlah_penduduk" class="block text-lg font-medium text-gray-700 mb-2">Jumlah
                            Penduduk</label>
                        <input type="number" id="jumlah_penduduk" name="jumlah_penduduk"
                            value="{{ old('jumlah_penduduk') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-lg font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">{{ old('deskripsi') }}</textarea>
                </div>

                <!-- Polygon Drawing Map -->
                <div class="mb-4">
                    <label class="block text-lg font-medium text-gray-700 mb-2">
                        <i class="fas fa-draw-polygon mr-2"></i>Gambar Batas Wilayah (Polygon)
                    </label>
                    <p class="text-gray-500 text-lg mb-3">Gunakan tool gambar di peta untuk membuat polygon batas wilayah
                        kecamatan. Klik icon polygon di pojok kiri peta, lalu klik titik-titik untuk membentuk area.</p>
                    <div id="polygon-map" class="border border-gray-300 mb-4"></div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="latitude" class="block text-lg font-medium text-gray-700 mb-2">Latitude (Center)</label>
                            <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-lg cursor-not-allowed">
                        </div>
                        <div>
                            <label for="longitude" class="block text-lg font-medium text-gray-700 mb-2">Longitude (Center)</label>
                            <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-lg cursor-not-allowed">
                        </div>
                    </div>

                    <input type="hidden" name="geojson_data" id="geojson_data" value="{{ old('geojson_data') }}">
                    @error('geojson_data')
                        <p class="mt-1 text-lg text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="warna" class="block text-lg font-medium text-gray-700 mb-2">Warna Polygon</label>
                    <input type="color" id="warna" name="warna" value="{{ old('warna', '#3388ff') }}"
                        class="w-20 h-12 border border-gray-300 rounded-lg cursor-pointer">
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded">
                        <span class="ml-2 text-lg text-gray-700">Aktif</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.kecamatan.index') }}"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg text-lg hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map centered on Medan
            const map = L.map('polygon-map').setView([3.5952, 98.6722], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Feature group to store drawn items
            const drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

            // Get warna input
            const warnaInput = document.getElementById('warna');

            // Initialize draw control
            const drawControl = new L.Control.Draw({
                draw: {
                    polygon: {
                        allowIntersection: false,
                        showArea: true,
                        shapeOptions: {
                            color: warnaInput.value
                        }
                    },
                    polyline: false,
                    circle: false,
                    rectangle: false,
                    marker: false,
                    circlemarker: false
                },
                edit: {
                    featureGroup: drawnItems,
                    remove: true
                }
            });
            map.addControl(drawControl);

            // Update color when warna changes
            warnaInput.addEventListener('change', function() {
                drawnItems.eachLayer(function(layer) {
                    layer.setStyle({
                        color: warnaInput.value,
                        fillColor: warnaInput.value
                    });
                });
            });

            // Handle polygon creation
            map.on(L.Draw.Event.CREATED, function(event) {
                // Clear previous polygons (only one allowed)
                drawnItems.clearLayers();

                const layer = event.layer;
                layer.setStyle({
                    color: warnaInput.value,
                    fillColor: warnaInput.value
                });
                drawnItems.addLayer(layer);

                updateGeoJsonInput();
            });

            // Handle polygon edit
            map.on(L.Draw.Event.EDITED, function(event) {
                updateGeoJsonInput();
            });

            // Handle polygon delete
            map.on(L.Draw.Event.DELETED, function(event) {
                updateGeoJsonInput();
            });

            function updateGeoJsonInput() {
                const geojsonInput = document.getElementById('geojson_data');
                const latInput = document.getElementById('latitude');
                const lngInput = document.getElementById('longitude');

                if (drawnItems.getLayers().length > 0) {
                    const layer = drawnItems.getLayers()[0];
                    const geojson = layer.toGeoJSON();

                    // Add nama property
                    const namaKecamatan = document.getElementById('nama_kecamatan').value || 'Kecamatan';
                    geojson.properties = {
                        nama: namaKecamatan
                    };

                    geojsonInput.value = JSON.stringify(geojson);

                    // Calculate centroid for lat/lng
                    const bounds = layer.getBounds();
                    const center = bounds.getCenter();
                    latInput.value = center.lat.toFixed(8);
                    lngInput.value = center.lng.toFixed(8);
                } else {
                    geojsonInput.value = '';
                    latInput.value = '';
                    lngInput.value = '';
                }
            }

            // Update geojson nama when nama_kecamatan changes
            document.getElementById('nama_kecamatan').addEventListener('input', updateGeoJsonInput);

            // Load existing geojson if available (for validation errors)
            const existingGeojson = document.getElementById('geojson_data').value;
            if (existingGeojson) {
                try {
                    const geojson = JSON.parse(existingGeojson);
                    const layer = L.geoJSON(geojson, {
                        style: {
                            color: warnaInput.value,
                            fillColor: warnaInput.value
                        }
                    });
                    layer.eachLayer(function(l) {
                        drawnItems.addLayer(l);
                    });
                    map.fitBounds(drawnItems.getBounds());
                } catch (e) {
                    console.error('Error parsing existing GeoJSON:', e);
                }
            }
        });
    </script>
@endpush
