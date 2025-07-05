@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6">📋 Laporan Pemesanan Kendaraan</h2>

        <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="text-sm font-medium">Dari Tanggal</label>
                <input type="date" name="from" value="{{ $from }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label class="text-sm font-medium">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ $to }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="flex items-end">
                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg">
                    Tampilkan Data
                </button>
            </div>
        </form>

        @if ($from && $to && $data->count())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow rounded-lg">
                    <thead>
                        <tr class="bg-green-100 text-green-800">
                            <th class="py-3 px-4 text-left">Nama</th>
                            <th class="py-3 px-4 text-left">Tanggal</th>
                            <th class="py-3 px-4 text-left">Lokasi</th>
                            <th class="py-3 px-4 text-left">Kendaraan</th>
                            <th class="py-3 px-4 text-left">Driver</th>
                            <th class="py-3 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $item->user->name }}</td>
                            <td class="py-2 px-4">{{ $item->tanggal_pakai }}</td>
                            <td class="py-2 px-4">{{ $item->lokasi }}</td>
                            <td class="py-2 px-4">{{ $item->kendaraan->nomor_plat ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $item->driver->nama ?? '-' }}</td>
                            <td class="py-2 px-4 capitalize">{{ $item->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('laporan.export', ['from' => $from, 'to' => $to]) }}"
                   class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-5 rounded-lg">
                    Export Excel
                </a>
            </div>
        @elseif($from && $to)
            <div class="text-center mt-10 text-gray-500">Tidak ada data pemesanan pada periode ini.</div>
        @endif
    </div>
</div>
@endsection
