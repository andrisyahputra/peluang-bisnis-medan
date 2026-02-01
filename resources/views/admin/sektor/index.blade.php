@extends('layouts.admin')

@section('title', 'Manajemen Sektor')

@section('content')
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Sektor</h2>
            <a href="{{ route('admin.sektor.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-lg">
                <i class="fas fa-plus mr-2"></i> Tambah Sektor
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Nama Sektor</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Warna</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Ikon</th>
                        <th class="px-6 py-4 text-center text-lg font-semibold text-gray-700">Peluang</th>
                        <th class="px-6 py-4 text-center text-lg font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-center text-lg font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($sektors as $index => $sektor)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-lg">{{ $sektors->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800 text-lg">{{ $sektor->nama_sektor }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span class="w-6 h-6 rounded" style="background-color: {{ $sektor->warna }}"></span>
                                    <span class="ml-2 text-lg text-gray-600">{{ $sektor->warna }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <i class="fas {{ $sektor->ikon ?? 'fa-circle' }} text-xl"
                                    style="color: {{ $sektor->warna }}"></i>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-blue-100 text-blue-800">
                                    {{ $sektor->peluang_bisnis_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($sektor->is_active)
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.sektor.edit', $sektor) }}"
                                    class="text-blue-600 hover:text-blue-800 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.sektor.destroy', $sektor) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus sektor ini?')">
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
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 text-lg">Belum ada data sektor
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sektors->hasPages())
            <div class="p-6 border-t border-gray-200">
                {{ $sektors->links() }}
            </div>
        @endif
    </div>
@endsection
