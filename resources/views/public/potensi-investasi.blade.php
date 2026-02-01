@extends('layouts.public')

@section('title', 'Potensi Investasi')
@section('description', 'Temukan potensi investasi di berbagai sektor unggulan dengan proyeksi nilai investasi yang
    menjanjikan.')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Potensi Investasi</h1>
        <p class="text-xl text-gray-600 mb-8">Temukan peluang investasi di berbagai sektor unggulan</p>

        <!-- Total Investasi -->
        <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-2xl p-8 text-white mb-8">
            <div class="text-xl opacity-90 mb-2">Total Estimasi Nilai Investasi</div>
            <div class="text-4xl md:text-5xl font-bold">Rp {{ number_format($totalInvestasi, 0, ',', '.') }}</div>
        </div>

        <!-- Sektor Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($sektors as $sektor)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition">
                    <div class="h-2" style="background-color: {{ $sektor->warna }}"></div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-2xl"
                                style="background-color: {{ $sektor->warna }}">
                                <i class="fas {{ $sektor->ikon ?? 'fa-briefcase' }}"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-xl text-gray-800">{{ $sektor->nama_sektor }}</h3>
                                <span class="text-lg text-gray-500">{{ $sektor->peluang_bisnis_count }} peluang</span>
                            </div>
                        </div>
                        <p class="text-lg text-gray-600 mb-4">
                            {{ $sektor->deskripsi ?? 'Sektor ' . $sektor->nama_sektor . ' menawarkan berbagai peluang investasi yang menjanjikan.' }}
                        </p>
                        <a href="{{ route('peluang-bisnis', ['sektor' => $sektor->id]) }}"
                            class="inline-flex items-center text-lg font-medium hover:underline"
                            style="color: {{ $sektor->warna }}">
                            Lihat Peluang <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
