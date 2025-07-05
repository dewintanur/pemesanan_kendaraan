@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-10 px-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">📝 Form Pemesanan Kendaraan</h2>

        <form action="{{ route('pemesanan.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Pilih Kendaraan</label>
                <select name="kendaraan_id"
                    class="w-full border-gray-300 rounded mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="" disabled selected>-- Pilih --</option>
                    @foreach($kendaraan as $k)
                        <option value="{{ $k->id }}">{{ $k->nomor_plat }} – {{ $k->jenis }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Pilih Driver</label>
                <select name="driver_id"
                    class="w-full border-gray-300 rounded mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="" disabled selected>-- Pilih --</option>
                    @foreach($driver as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Pakai</label>
                <input type="date" name="tanggal_pakai"
                    class="w-full border-gray-300 rounded mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Lokasi Tujuan</label>
                <input type="text" name="lokasi"
                    class="w-full border-gray-300 rounded mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Contoh: Site Tambang A" required>
            </div>
            <!-- Approver Level 1 -->
            <div class="mb-3">
                <label>Approver Level 1</label>
                <select name="approver1" class="form-select" required>
                    @foreach($approverLevel1 as $a)
                        <option value="{{ $a->id }}">{{ $a->name }} ({{ $a->email }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Approver Level 2 -->
            <div class="mb-3">
                <label>Approver Level 2</label>
                <select name="approver2" class="form-select" required>
                    @foreach($approverLevel2 as $a)
                        <option value="{{ $a->id }}">{{ $a->name }} ({{ $a->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow transition">
                    Kirim Pemesanan
                </button>
            </div>
        </form>
    </div>
@endsection