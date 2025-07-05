@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Input Data Kendaraan</h2>
    <form action="{{ route('kendaraan.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium">Nomor Plat</label>
            <input type="text" name="nomor_plat" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Jenis</label>
            <input type="text" name="jenis" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Merk</label>
            <input type="text" name="merk" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Tahun</label>
            <input type="number" name="tahun" min="1980" max="{{ date('Y') }}" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">KM Terakhir</label>
            <input type="number" name="km_terakhir" class="form-input w-full">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Tanggal Terakhir BBM</label>
            <input type="date" name="tanggal_terakhir_bbm" class="form-input w-full">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Tanggal Terakhir Service</label>
            <input type="date" name="tanggal_terakhir_service" class="form-input w-full">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Jadwal Service Berikutnya</label>
            <input type="date" name="jadwal_service_berikutnya" class="form-input w-full">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Status</label>
            <select name="status" class="form-select w-full">
                <option value="aktif">Aktif</option>
                <option value="servis">Servis</option>
                <option value="rusak">Rusak</option>
            </select>
        </div>
        <div class="text-right">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
