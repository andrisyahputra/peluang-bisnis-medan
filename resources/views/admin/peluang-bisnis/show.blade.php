@extends('layouts.admin')
@section('title', 'Detail Peluang Bisnis')

@section('content')
    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">{{ $peluangBisnis->nama_usaha }}</h2>
                <div class="flex space-x-2">
                    @if ($peluangBisnis->status_unggulan)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-star mr-1"></i> Unggulan
                        </span>
                    @endif
                    @if ($peluangBisnis->is_active)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-green-100 text-green-800">Aktif</span>
                    @else
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-red-100 text-red-800">Nonaktif</span>
                    @endif
                </div>
            </div>

            <div class="p-6">
                @if ($peluangBisnis->gambar)
                    <div class="mb-6">
                        <img src="{{ Storage::url($peluangBisnis->gambar) }}" alt="{{ $peluangBisnis->nama_usaha }}"
                            class="w-full h-64 object-cover rounded-xl shadow-sm">
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-lg text-gray-500 mb-1">Sektor</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-lg text-white"
                            style="background-color: {{ $peluangBisnis->sektor->warna }}">
                            <i class="fas {{ $peluangBisnis->sektor->ikon ?? 'fa-briefcase' }} mr-2"></i>
                            {{ $peluangBisnis->sektor->nama_sektor }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-lg text-gray-500 mb-1">Kecamatan</label>
                        <p class="text-xl font-medium text-gray-800">{{ $peluangBisnis->kecamatan->nama_kecamatan }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-lg text-gray-500 mb-1">Latitude</label>
                        <p class="text-xl font-medium text-gray-800">{{ $peluangBisnis->latitude }}</p>
                    </div>
                    <div>
                        <label class="block text-lg text-gray-500 mb-1">Longitude</label>
                        <p class="text-xl font-medium text-gray-800">{{ $peluangBisnis->longitude }}</p>
                    </div>
                </div>

                @if ($peluangBisnis->alamat)
                    <div class="mb-6">
                        <label class="block text-lg text-gray-500 mb-1">Alamat</label>
                        <p class="text-xl text-gray-800">{{ $peluangBisnis->alamat }}</p>
                    </div>
                @endif

                @if ($peluangBisnis->kontak)
                    <div class="mb-6">
                        <label class="block text-lg text-gray-500 mb-1">Kontak</label>
                        <p class="text-xl text-gray-800">{{ $peluangBisnis->kontak }}</p>
                    </div>
                @endif

                @if ($peluangBisnis->estimasi_investasi)
                    <div class="mb-6">
                        <label class="block text-lg text-gray-500 mb-1">Estimasi Investasi</label>
                        <p class="text-2xl font-bold text-green-600">{{ $peluangBisnis->estimasi_investasi_formatted }}</p>
                    </div>
                @endif

                @if ($peluangBisnis->deskripsi)
                    <div class="mb-6">
                        <label class="block text-lg text-gray-500 mb-1">Deskripsi</label>
                        <p class="text-lg text-gray-800">{{ $peluangBisnis->deskripsi }}</p>
                    </div>
                @endif

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <a href="{{ route('admin.peluang-bisnis.index') }}"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-lg text-gray-700 hover:bg-gray-50">
                        Kembali
                    </a>
                    <a href="{{ route('admin.peluang-bisnis.edit', $peluangBisnis) }}"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg text-lg hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
