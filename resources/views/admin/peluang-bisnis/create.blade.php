@extends('layouts.admin')

@section('title', 'Tambah Peluang Bisnis')

@section('content')
    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Tambah Peluang Bisnis Baru</h2>
            </div>

            <form action="{{ route('admin.peluang-bisnis.store') }}" method="POST" class="p-6" enctype="multipart/form-data" noValidate>
                @csrf

                <div class="mb-4">
                    <label for="nama_usaha" class="block text-lg font-medium text-gray-700 mb-2">Nama Usaha *</label>
                    <input type="text" id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg @error('nama_usaha') border-red-500 @enderror">
                    @error('nama_usaha')
                        <p class="mt-1 text-lg text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gambar" class="block text-lg font-medium text-gray-700 mb-2">Gambar</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg @error('gambar') border-red-500 @enderror">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, JPEG, PNG, GIF. Maks: 2MB.</p>
                    @error('gambar')
                        <p class="mt-1 text-lg text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="sektor_id" class="block text-lg font-medium text-gray-700 mb-2">Sektor *</label>
                        <select id="sektor_id" name="sektor_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">
                            <option value="">Pilih Sektor</option>
                            @foreach ($sektors as $sektor)
                                <option value="{{ $sektor->id }}" {{ old('sektor_id') == $sektor->id ? 'selected' : '' }}>
                                    {{ $sektor->nama_sektor }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="kecamatan_id" class="block text-lg font-medium text-gray-700 mb-2">Kecamatan *</label>
                        <select id="kecamatan_id" name="kecamatan_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">
                            <option value="">Pilih Kecamatan</option>
                            @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}"
                                    {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>
                                    {{ $kecamatan->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="latitude" class="block text-lg font-medium text-gray-700 mb-2">Latitude *</label>
                        <input type="number" step="any" id="latitude" name="latitude" value="{{ old('latitude') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">
                    </div>

                    <div>
                        <label for="longitude" class="block text-lg font-medium text-gray-700 mb-2">Longitude *</label>
                        <input type="number" step="any" id="longitude" name="longitude" value="{{ old('longitude') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="alamat" class="block text-lg font-medium text-gray-700 mb-2">Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="kontak" class="block text-lg font-medium text-gray-700 mb-2">Kontak</label>
                        <input type="text" id="kontak" name="kontak" value="{{ old('kontak') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">
                    </div>

                    <div>
                        <label for="estimasi_investasi" class="block text-lg font-medium text-gray-700 mb-2">Estimasi
                            Investasi (Rp)</label>
                        <input type="number" id="estimasi_investasi" name="estimasi_investasi"
                            value="{{ old('estimasi_investasi') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-lg font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="flex gap-6 mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="status_unggulan" value="1"
                            {{ old('status_unggulan') ? 'checked' : '' }}
                            class="w-5 h-5 text-yellow-500 border-gray-300 rounded">
                        <span class="ml-2 text-lg text-gray-700"><i
                                class="fas fa-star text-yellow-500 mr-1"></i>Unggulan</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded">
                        <span class="ml-2 text-lg text-gray-700">Aktif</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.peluang-bisnis.index') }}"
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
