@extends('layouts.app')
@section('content')
    <!-- form kamu -->

<form action="{{ route('riwayat.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-md max-w-2xl mx-auto mt-4">
    @csrf
    <input type="hidden" name="pemesanan_id" value="{{ $pemesanan->id }}">
    <input type="hidden" name="kendaraan_id" value="{{ $pemesanan->kendaraan->id }}">

    <h2 class="text-xl font-semibold text-gray-800 mb-6">Form Pengembalian Kendaraan</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">KM Awal</label>
            <input type="number" name="km_awal"
                value="{{ $pemesanan->kendaraan->km_terakhir }}"
                class="w-full rounded-lg border-gray-300 bg-gray-100 px-4 py-2 text-gray-700"
                readonly required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">KM Akhir</label>
            <input type="number" name="km_akhir"
                class="w-full rounded-lg border-gray-300 px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>
    </div>

    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">BBM Dipakai (liter)</label>
        <input type="number" name="bbm_pakai"
            class="w-full rounded-lg border-gray-300 px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
            <input type="datetime-local" name="tanggal_mulai"
                value="{{ \Carbon\Carbon::parse($pemesanan->tanggal_pakai)->format('Y-m-d\TH:i') }}"
                class="w-full rounded-lg border-gray-300 px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
            <input type="datetime-local" name="tanggal_selesai"
                value="{{ now()->format('Y-m-d\TH:i') }}"
                class="w-full rounded-lg border-gray-300 px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>

    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
        <textarea name="catatan" rows="3"
            class="w-full rounded-lg border-gray-300 px-4 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
    </div>

    <div class="mt-6 text-right">
        <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium shadow">
            Simpan Riwayat
        </button>
    </div>
</form>
@endsection
