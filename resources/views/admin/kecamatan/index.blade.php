@extends('layouts.admin')

@section('title', 'Manajemen Kecamatan')

@section('content')
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Kecamatan</h2>
            <a href="{{ route('admin.kecamatan.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-lg">
                <i class="fas fa-plus mr-2"></i> Tambah Kecamatan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Nama Kecamatan</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Kode</th>
                        <th class="px-6 py-4 text-center text-lg font-semibold text-gray-700">Polygon</th>
                        <th class="px-6 py-4 text-right text-lg font-semibold text-gray-700">Luas (Ha)</th>
                        <th class="px-6 py-4 text-right text-lg font-semibold text-gray-700">Penduduk</th>
                        <th class="px-6 py-4 text-center text-lg font-semibold text-gray-700">Peluang</th>
                        <th class="px-6 py-4 text-center text-lg font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-center text-lg font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($kecamatans as $index => $kecamatan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-lg">{{ $kecamatans->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800 text-lg">
                                <div class="flex items-center">
                                    @if ($kecamatan->warna)
                                        <span class="w-4 h-4 rounded mr-2"
                                            style="background-color: {{ $kecamatan->warna }}"></span>
                                    @endif
                                    {{ $kecamatan->nama_kecamatan }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-lg">{{ $kecamatan->kode_kecamatan }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($kecamatan->geojson_data)
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i> Ada
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-gray-100 text-gray-600">
                                        <i class="fas fa-times mr-1"></i> Belum
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-gray-600 text-lg">
                                {{ number_format($kecamatan->luas_wilayah) }}</td>
                            <td class="px-6 py-4 text-right text-gray-600 text-lg">
                                {{ number_format($kecamatan->jumlah_penduduk) }}</td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-blue-100 text-blue-800">
                                    {{ $kecamatan->peluang_bisnis_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($kecamatan->is_active)
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.kecamatan.edit', $kecamatan) }}"
                                    class="text-blue-600 hover:text-blue-800 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.kecamatan.destroy', $kecamatan) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Yakin ingin menghapus kecamatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500 text-lg">Belum ada data kecamatan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($kecamatans->hasPages())
            <div class="p-6 border-t border-gray-200">
                {{ $kecamatans->links() }}
            </div>
        @endif
    </div>
@endsection
