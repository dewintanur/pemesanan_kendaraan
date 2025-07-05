@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Kendaraan</h2>

    {{-- Informasi Utama Kendaraan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div><strong>Plat:</strong> {{ $kendaraan->nomor_plat }}</div>
        <div><strong>Jenis:</strong> {{ $kendaraan->jenis }}</div>
        <div><strong>Merk:</strong> {{ $kendaraan->merk }}</div>
        <div><strong>Tahun:</strong> {{ $kendaraan->tahun }}</div>
        <div><strong>KM Terakhir:</strong> {{ $kendaraan->km_terakhir ?? '-' }}</div>
        <div><strong>Status:</strong> 
            <span class="inline-block px-2 py-1 text-xs rounded 
                {{ $kendaraan->status == 'aktif' ? 'bg-green-100 text-green-700' : 
                   ($kendaraan->status == 'servis' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                {{ ucfirst($kendaraan->status) }}
            </span>
        </div>
        <div><strong>Terakhir Diservis:</strong> 
            {{ $kendaraan->tanggal_terakhir_service ? \Carbon\Carbon::parse($kendaraan->tanggal_terakhir_service)->translatedFormat('d F Y') : '-' }}
        </div>
    </div>

    <hr class="my-6">

    <h3 class="text-xl font-semibold text-gray-700 mb-4">Riwayat Pemakaian</h3>

    @if ($riwayat->isEmpty())
        <p class="text-gray-500">Belum ada riwayat untuk kendaraan ini.</p>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-200">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Tanggal Mulai</th>
                    <th class="px-4 py-2">Tanggal Selesai</th>
                    <th class="px-4 py-2">KM Awal</th>
                    <th class="px-4 py-2">KM Akhir</th>
                    <th class="px-4 py-2">BBM</th>
                    <th class="px-4 py-2">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayat as $item)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y H:i') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y H:i') }}</td>
                    <td class="px-4 py-2">{{ $item->km_awal }}</td>
                    <td class="px-4 py-2">{{ $item->km_akhir }}</td>
                    <td class="px-4 py-2">{{ $item->bbm_pakai }} L</td>
                    <td class="px-4 py-2">{{ $item->catatan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <h3 class="text-xl font-semibold text-gray-700 mt-10 mb-4">Riwayat Servis</h3>

@if ($kendaraan->jadwalService->isEmpty())
    <p class="text-gray-500">Belum ada riwayat servis untuk kendaraan ini.</p>
@else
<div class="overflow-x-auto">
    <table class="min-w-full text-sm border border-gray-200">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Tanggal Servis</th>
                <th class="px-4 py-2">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kendaraan->jadwalService as $service)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($service->tanggal_service)->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $service->deskripsi ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

</div>
@endsection
