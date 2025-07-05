@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 px-4 max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Jadwal Servis</h2>

    <form action="{{ route('jadwal_service.update', $jadwal->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="kendaraan_id" class="block font-semibold mb-1">Kendaraan</label>
            <select name="kendaraan_id" id="kendaraan_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Pilih Kendaraan --</option>
                @foreach ($kendaraan as $k)
<option value="{{ $k->id }}" {{ (old('kendaraan_id') ?? $jadwal->kendaraan_id) == $k->id ? 'selected' : '' }}>
                        {{ $k->merk }} ({{ $k->jenis }}) - {{ $k->nomor_plat }}
                    </option>
                @endforeach
            </select>
            @error('kendaraan_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="tanggal_service" class="block font-semibold mb-1">Tanggal Servis</label>
            <input type="date" name="tanggal_service" id="tanggal_service" value="{{ old('tanggal_service') ?? $jadwal->tanggal_service }}" class="w-full border rounded px-3 py-2" />
            @error('tanggal_service')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="deskripsi" class="block font-semibold mb-1">Deskripsi (opsional)</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full border rounded px-3 py-2">{{ old('deskripsi') ?? $jadwal->deskripsi }}</textarea>
            @error('deskripsi')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
            Update Jadwal Servis
        </button>
    </form>
</div>
@endsection
