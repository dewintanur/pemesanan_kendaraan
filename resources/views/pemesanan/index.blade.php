@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">🚗 Daftar Pemesanan Kendaraan</h2>
        <a href="{{ route('pemesanan.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
            + Pesan Kendaraan
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-700 bg-green-100 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">#</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">User</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kendaraan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Driver</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($data as $d)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 text-sm">{{ $d->user->name }}</td>
                    <td class="px-4 py-3 text-sm">
                        {{ $d->kendaraan->nomor_plat }}<br>
                        <span class="text-xs text-gray-500">{{ $d->kendaraan->jenis }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $d->driver->nama }}</td>
                    <td class="px-4 py-3 text-sm">
                        {{ \Carbon\Carbon::parse($d->tanggal_pakai)->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <span class="inline-block px-3 py-1 rounded-full text-white text-xs font-medium
                            {{ $d->status == 'disetujui' ? 'bg-green-600' :
                                ($d->status == 'ditolak' ? 'bg-red-600' :
                                'bg-yellow-500') }}">
                            {{ ucfirst($d->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm space-x-1">
                        @if($d->status == 'disetujui')
                        <a href="{{ route('riwayat.form', $d->id) }}"
                            class="inline-block bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                            Kembalikan
                        </a>
                        @endif

                        <a href="{{ route('pemesanan.show', $d->id) }}"
                            class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-xs">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500 text-sm">
                        Belum ada data pemesanan kendaraan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
