@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded-lg mt-4">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Detail Pemesanan</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div><strong>Nama Pemesan:</strong> {{ $pemesanan->user->name }}</div>
            <div><strong>Driver:</strong> {{ $pemesanan->driver->nama }}</div>
            <div><strong>Kendaraan:</strong> {{ $pemesanan->kendaraan->nomor_plat }} - {{ $pemesanan->kendaraan->merk }}
            </div>
            <div><strong>Tanggal Pakai:</strong>
                {{ \Carbon\Carbon::parse($pemesanan->tanggal_pakai)->translatedFormat('d F Y') }}</div>
            <div><strong>Status:</strong>
                <span class="inline-block px-2 py-1 rounded-full text-white text-xs font-medium
                    {{ $pemesanan->status == 'disetujui' ? 'bg-green-600' :
        ($pemesanan->status == 'ditolak' ? 'bg-red-600' :
            'bg-yellow-500') }}">
                    {{ ucfirst($pemesanan->status) }}
                </span>
            </div>
        </div>

        <hr class="my-4">

        <h3 class="text-lg font-semibold mb-2 text-gray-700">Log Aktivitas Lengkap</h3>

        @if(empty($logs))
            <p class="text-gray-500 text-sm">Belum ada aktivitas.</p>
        @else
            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                @foreach($logs as $log)
                    <li>
                        <strong>{{ $log['user'] }}</strong> - {{ $log['aktivitas'] }} <br>
                        <span class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($log['waktu'])->translatedFormat('d M Y H:i') }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif



        <div class="mt-6">
            <a href="{{ route('pemesanan.index') }}"
                class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                ← Kembali
            </a>
        </div>
    </div>
@endsection