@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Daftar Pemesanan untuk Disetujui</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
    @endif
@if(session('new_approval_notif'))
    <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded shadow">
        {{ session('new_approval_notif') }}
    </div>
@endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Kendaraan</th>
                    <th class="px-4 py-3">Driver</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Lokasi</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $a->pemesanan->user->name }}</td>
                    <td class="px-4 py-2">{{ $a->pemesanan->kendaraan->nomor_plat }}</td>
                    <td class="px-4 py-2">{{ $a->pemesanan->driver->nama }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($a->pemesanan->tanggal_pakai)->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $a->pemesanan->lokasi }}</td>
                    <td class="px-4 py-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium 
                            {{ $a->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($a->status === 'disetujui' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($a->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 flex gap-2">
                        <form action="{{ route('approval.approve', $a->id) }}" method="POST">
                            @csrf
                            <button class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded">
                                Setujui
                            </button>
                        </form>
                        <form action="{{ route('approval.reject', $a->id) }}" method="POST">
                            @csrf
                            <button class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded">
                                Tolak
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-3 text-center text-gray-500">Tidak ada pemesanan yang menunggu persetujuan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
