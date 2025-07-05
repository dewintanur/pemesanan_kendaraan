@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white shadow rounded-lg">
    <h2 class="text-xl font-bold text-gray-800 mb-4">📝 Riwayat Persetujuan Saya</h2>

    @if ($riwayat->isEmpty())
        <p class="text-gray-500">Belum ada riwayat persetujuan.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-200 rounded">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="px-4 py-2 font-semibold text-gray-700">#</th>
                        <th class="px-4 py-2 font-semibold text-gray-700">User</th>
                        <th class="px-4 py-2 font-semibold text-gray-700">Kendaraan</th>
                        <th class="px-4 py-2 font-semibold text-gray-700">Tanggal Pakai</th>
                        <th class="px-4 py-2 font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-2 font-semibold text-gray-700">Tanggal Approve</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $item)
                    <tr class="border-t hover:bg-gray-50 align-top">
                        <td class="px-4 py-2 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $item->pemesanan->user->name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div>{{ $item->pemesanan->kendaraan->nomor_plat }}</div>
                            <div class="text-xs text-gray-500">{{ $item->pemesanan->kendaraan->merk }}</div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->pemesanan->tanggal_pakai)->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-medium text-white 
                                {{ $item->status == 'disetujui' ? 'bg-green-600' : 'bg-red-600' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->tanggal_approve)->translatedFormat('d M Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('approval.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            ← Kembali ke daftar persetujuan
        </a>
    </div>
</div>
@endsection
