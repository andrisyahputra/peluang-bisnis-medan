@extends('layouts.public')

@section('title', 'RDTR Interaktif')
@section('description', 'Peta Rencana Detail Tata Ruang interaktif untuk melihat zonasi dan peruntukan lahan.')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">RDTR Interaktif</h1>
        <p class="text-xl text-gray-600 mb-6">Rencana Detail Tata Ruang Kota</p>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div id="rdtr-map" style="height: 600px;"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
            <div class="bg-white rounded-lg p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="w-6 h-6 rounded bg-yellow-400 mr-3"></div>
                    <span class="text-lg">Zona Perumahan</span>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="w-6 h-6 rounded bg-red-400 mr-3"></div>
                    <span class="text-lg">Zona Perdagangan</span>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="w-6 h-6 rounded bg-purple-400 mr-3"></div>
                    <span class="text-lg">Zona Industri</span>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="w-6 h-6 rounded bg-green-400 mr-3"></div>
                    <span class="text-lg">Zona RTH</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('rdtr-map').setView([3.5952, 98.6722], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Add sample zones
            const zones = @json($kecamatans);
            const colors = ['#fbbf24', '#f87171', '#a78bfa', '#34d399'];
            zones.forEach((zone, index) => {
                if (zone.geojson_data) {
                    L.geoJSON(zone.geojson_data, {
                        style: {
                            fillColor: colors[index % colors.length],
                            fillOpacity: 0.4,
                            color: colors[index % colors.length],
                            weight: 2
                        }
                    }).addTo(map);
                }
            });
        });
    </script>
@endpush
