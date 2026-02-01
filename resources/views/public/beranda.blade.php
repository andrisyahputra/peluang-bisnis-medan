@extends('layouts.public')

@section('title', 'Beranda')
@section('description', 'Selamat datang di Peta Peluang Bisnis - Platform informasi investasi dan peluang usaha untuk
pertumbuhan ekonomi daerah.')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-2xl p-8 md:p-12 text-white mb-8">
        <div class="max-w-3xl">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Peta Peluang Bisnis Kota</h1>
            <p class="text-xl mb-6 text-gray-200">Temukan potensi investasi dan peluang usaha di berbagai sektor
                unggulan. Platform digital untuk mendukung pertumbuhan ekonomi dan kemudahan berinvestasi.</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('peluang-bisnis') }}"
                    class="bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-lg font-semibold text-lg transition">
                    <i class="fas fa-map-marker-alt mr-2"></i> Jelajahi Peta
                </a>
                <a href="{{ route('potensi-investasi') }}"
                    class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-lg font-semibold text-lg transition">
                    <i class="fas fa-chart-line mr-2"></i> Potensi Investasi
                </a>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm text-center">
            <div class="text-3xl font-bold text-primary-500">{{ $totalPeluang }}</div>
            <div class="text-gray-600 text-lg">Total Peluang</div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm text-center">
            <div class="text-3xl font-bold text-accent-500">{{ $totalUnggulan }}</div>
            <div class="text-gray-600 text-lg">Sektor Unggulan</div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm text-center">
            <div class="text-3xl font-bold text-green-500">{{ $sektors->count() }}</div>
            <div class="text-gray-600 text-lg">Kategori Sektor</div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm text-center">
            <div class="text-3xl font-bold text-blue-500">21</div>
            <div class="text-gray-600 text-lg">Kecamatan</div>
        </div>
    </div>

    <!-- Sectors -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Sektor Bisnis</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach ($sektors as $sektor)
        <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white text-xl"
                    style="background-color: {{ $sektor->warna }}">
                    <i class="fas {{ $sektor->ikon ?? 'fa-briefcase' }}"></i>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-lg text-gray-800">{{ $sektor->nama_sektor }}</h3>
                    <span class="text-2xl font-bold"
                        style="color: {{ $sektor->warna }}">{{ $sektor->peluang_bisnis_count }}</span>
                    <span class="text-gray-500 text-lg">peluang</span>
                </div>
            </div>
            <a href="{{ route('peluang-bisnis', ['sektor' => $sektor->id]) }}"
                class="text-primary-500 hover:text-primary-600 text-lg font-medium">
                Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        @endforeach
    </div>

    <!-- CTA -->
    <!-- <div class="bg-gradient-to-r from-accent-400 to-accent-500 rounded-2xl p-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-2">Siap Berinvestasi?</h2>
            <p class="text-white/90 mb-6 text-xl">Hubungi kami untuk informasi lebih lanjut tentang peluang investasi di
                kota kami.</p>
            <a href="{{ route('insentif') }}"
                class="bg-white text-accent-600 px-8 py-3 rounded-lg font-semibold text-lg hover:bg-gray-100 transition inline-block">
                Pelajari Insentif
            </a>
        </div> -->
</div>
@endsection