@extends('layouts.public')

@section('title', 'Profil Kota')
@section('description', 'Informasi lengkap tentang profil kota termasuk data kecamatan, jumlah penduduk, dan luas
    wilayah.')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Profil Kota Medan</h1>
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 text-white">
                <div class="text-4xl font-bold mb-2">{{ $kecamatans->count() }}</div>
                <div class="text-xl opacity-90">Total Kecamatan</div>
            </div>
            <div class="bg-gradient-to-br from-accent-400 to-accent-500 rounded-xl p-6 text-white">
                <div class="text-4xl font-bold mb-2">{{ number_format($totalPenduduk) }}</div>
                <div class="text-xl opacity-90">Jumlah Penduduk</div>
            </div>
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
                <div class="text-4xl font-bold mb-2">{{ number_format($totalLuas / 100, 2) }} km²</div>
                <div class="text-xl opacity-90">Luas Wilayah</div>
            </div>
        </div>

        <!-- Kecamatan List -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">No</th>
                            <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Nama Kecamatan</th>
                            <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Kode</th>
                            <th class="px-6 py-4 text-right text-lg font-semibold text-gray-700">Luas (Ha)</th>
                            <th class="px-6 py-4 text-right text-lg font-semibold text-gray-700">Penduduk</th>
                            <th class="px-6 py-4 text-right text-lg font-semibold text-gray-700">Peluang Bisnis</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($kecamatans as $index => $kecamatan)
                            <tr class="hover:bg-gray-50 text-lg">
                                <td class="px-6 py-4 text-gray-600">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $kecamatan->nama_kecamatan }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $kecamatan->kode_kecamatan }}</td>
                                <td class="px-6 py-4 text-right text-gray-600">{{ number_format($kecamatan->luas_wilayah) }}
                                </td>
                                <td class="px-6 py-4 text-right text-gray-600">
                                    {{ number_format($kecamatan->jumlah_penduduk) }}</td>
                                <td class="px-6 py-4 text-right">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-blue-100 text-blue-800">
                                        {{ $kecamatan->peluang_bisnis_count }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
