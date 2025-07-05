@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h2 class="text-xl font-bold mb-4">Monitoring Kendaraan</h2>
    <a href="{{ route('kendaraan.create') }}"
        class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Kendaraan</a>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Plat</th>
                    <th class="px-4 py-2">Jenis</th>
                    <th class="px-4 py-2">Merk</th>
                    <th class="px-4 py-2">Tahun</th>
                    <th class="px-4 py-2">KM</th>
                    <th class="px-4 py-2">Terakhir BBM</th>
                    <th class="px-4 py-2">Terakhir Servis</th>
                    <th class="px-4 py-2">Jadwal Servis</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kendaraan as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $item->nomor_plat }}</td>
                    <td class="px-4 py-2">{{ $item->jenis }}</td>
                    <td class="px-4 py-2">{{ $item->merk }}</td>
                    <td class="px-4 py-2">{{ $item->tahun }}</td>
                    <td class="px-4 py-2">{{ $item->km_terakhir ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $item->tanggal_terakhir_bbm ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $item->tanggal_terakhir_service ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $item->jadwal_service_berikutnya ?? '-' }}</td>
                    <td class="px-4 py-2">
                        <span class="inline-block px-2 py-1 text-xs rounded 
                            {{ $item->status == 'aktif' ? 'bg-green-100 text-green-700' : 
                               ($item->status == 'servis' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center">
    <div class="space-y-1">
        <a href="{{ route('kendaraan.show', $item->id) }}"
            class="inline-block text-indigo-600 hover:underline">Detail</a>

        <a href="{{ route('kendaraan.edit', $item->id) }}"
            class="inline-block text-blue-600 hover:underline">Edit</a>

        @if ($item->status !== 'servis')
        <form action="{{ route('kendaraan.updateStatus', $item->id) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="servis">
            <input type="hidden" name="tanggal_servis" value="{{ now()->toDateString() }}">
            <button type="submit" class="text-yellow-600 hover:underline text-sm">Tandai Servis</button>
        </form>
        @endif

        @if ($item->status === 'servis')
        <form action="{{ route('kendaraan.updateStatus', $item->id) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="aktif">
            <button type="submit" class="text-green-600 hover:underline text-sm">Aktifkan</button>
        </form>
        @endif
    </div>
</td>

                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
