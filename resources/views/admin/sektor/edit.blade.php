@extends('layouts.admin')

@section('title', 'Edit Sektor')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Edit Sektor: {{ $sektor->nama_sektor }}</h2>
            </div>

            <form action="{{ route('admin.sektor.update', $sektor) }}" method="POST" class="p-6" noValidate>
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama_sektor" class="block text-lg font-medium text-gray-700 mb-2">Nama Sektor *</label>
                    <input type="text" id="nama_sektor" name="nama_sektor"
                        value="{{ old('nama_sektor', $sektor->nama_sektor) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg @error('nama_sektor') border-red-500 @enderror">
                    @error('nama_sektor')
                        <p class="mt-1 text-lg text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="warna" class="block text-lg font-medium text-gray-700 mb-2">Warna *</label>
                        <input type="color" id="warna" name="warna" value="{{ old('warna', $sektor->warna) }}"
                            class="w-full h-12 border border-gray-300 rounded-lg cursor-pointer">
                    </div>

                    <div>
                        <label for="ikon" class="block text-lg font-medium text-gray-700 mb-2">Ikon (Font
                            Awesome)</label>
                        <input type="text" id="ikon" name="ikon" value="{{ old('ikon', $sektor->ikon) }}"
                            placeholder="fa-briefcase"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-lg font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">{{ old('deskripsi', $sektor->deskripsi) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="urutan" class="block text-lg font-medium text-gray-700 mb-2">Urutan</label>
                    <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $sektor->urutan) }}"
                        min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $sektor->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded">
                        <span class="ml-2 text-lg text-gray-700">Aktif</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.sektor.index') }}"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg text-lg hover:bg-blue-700">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
