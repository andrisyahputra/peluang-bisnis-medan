@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-briefcase text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-lg">Total Peluang Bisnis</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPeluang }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-14 h-14 rounded-xl bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-lg">Unggulan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalUnggulan }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center">
                    <i class="fas fa-layer-group text-green-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-lg">Total Sektor</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalSektor }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center">
                    <i class="fas fa-map text-purple-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-lg">Total Kecamatan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalKecamatan }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Investasi -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-lg">Total Estimasi Investasi</p>
                <p class="text-4xl font-bold mt-1">Rp {{ number_format($totalInvestasi, 0, ',', '.') }}</p>
            </div>
            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center">
                <i class="fas fa-chart-line text-3xl"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Peluang Per Sektor -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-xl text-gray-800 mb-4">Peluang Per Sektor</h3>
            <div class="space-y-4">
                @foreach ($peluangPerSektor as $sektor)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-lg text-gray-600">{{ $sektor->nama_sektor }}</span>
                            <span class="text-lg font-medium">{{ $sektor->peluang_bisnis_count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full"
                                style="width: {{ $totalPeluang > 0 ? ($sektor->peluang_bisnis_count / $totalPeluang) * 100 : 0 }}%; background-color: {{ $sektor->warna }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Peluang Terbaru -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-xl text-gray-800 mb-4">Peluang Bisnis Terbaru</h3>
            <div class="space-y-3">
                @forelse($peluangTerbaru as $peluang)
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white"
                            style="background-color: {{ $peluang->sektor->warna }}">
                            <i class="fas {{ $peluang->sektor->ikon ?? 'fa-briefcase' }}"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="font-medium text-gray-800 text-lg">{{ $peluang->nama_usaha }}</p>
                            <p class="text-lg text-gray-500">{{ $peluang->kecamatan->nama_kecamatan }}</p>
                        </div>
                        @if ($peluang->status_unggulan)
                            <span class="text-yellow-500"><i class="fas fa-star"></i></span>
                        @endif
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-8 text-lg">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
