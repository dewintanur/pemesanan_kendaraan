@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Daftar Riwayat Kendaraan</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
        <div class="flex space-x-2">
            <a href="{{ route('riwayat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow transition">
                + Tambah Riwayat Baru
            </a>
            <a href="{{ route('riwayat.export', request()->only('from', 'to')) }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow transition">
                Export Excel
            </a>
        </div>

        <form action="{{ route('riwayat.index') }}" method="GET" class="flex space-x-2">
            <input type="date" name="from" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('from') }}">
            <input type="date" name="to" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('to') }}">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded shadow transition">
                Filter
            </button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200 table-auto">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Kendaraan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Plat Nomor</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Pemesan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">KM Awal</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">KM Akhir</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">BBM Dipakai (L)</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal Mulai</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal Selesai</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Catatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($riwayat as $item)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->kendaraan->merk ?? '-' }} ({{ $item->kendaraan->jenis ?? '-' }})</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->kendaraan->nomor_plat ?? '-' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->pemesanan->user->name ?? '-' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->km_awal }} km</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->km_akhir }} km</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->bbm_pakai }} L</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->tanggal_mulai ?? '-' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->tanggal_selesai ?? '-' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->catatan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-4 py-6 text-center text-gray-500 text-sm">Belum ada riwayat kendaraan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
