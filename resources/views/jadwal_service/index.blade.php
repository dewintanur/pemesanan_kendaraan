@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Jadwal Servis Kendaraan</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('jadwal_service.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow mb-4 inline-block">
        + Tambah Jadwal Servis
    </a>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200 table-auto">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Kendaraan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal Servis</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Deskripsi</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($jadwals as $jadwal)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $loop->iteration + ($jadwals->currentPage() - 1) * $jadwals->perPage() }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                        {{ $jadwal->kendaraan->merk ?? '-' }} ({{ $jadwal->kendaraan->jenis ?? '-' }}) - {{ $jadwal->kendaraan->nomor_plat ?? '-' }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($jadwal->tanggal_service)->translatedFormat('d F Y') }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $jadwal->deskripsi ?? '-' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 space-x-2">
                        <a href="{{ route('jadwal_service.edit', $jadwal->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>

                        <form action="{{ route('jadwal_service.destroy', $jadwal->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus jadwal servis ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500 text-sm">Belum ada jadwal servis.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $jadwals->links() }}
    </div>
</div>
@endsection
