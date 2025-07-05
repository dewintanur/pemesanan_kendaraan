@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-6">Tambah Riwayat Kendaraan</h2>

    <form action="{{ route('riwayat.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="kendaraan_id" class="block font-medium">Pilih Kendaraan</label>
            <select name="kendaraan_id" id="kendaraan_id" class="form-control" required>
                <option value="">-- Pilih --</option>
                @foreach($kendaraan as $k)
                    <option value="{{ $k->id }}">{{ $k->nomor_plat }} - {{ $k->jenis }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="pemesanan_id" class="block font-medium">Pilih Pemesanan</label>
            <select name="pemesanan_id" id="pemesanan_id" class="form-control" required>
                <option value="">-- Pilih --</option>
                <!-- opsi akan diisi otomatis via JS -->
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block font-medium">KM Awal</label>
                <input type="number" name="km_awal" id="km_awal" class="form-control" readonly required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">KM Akhir</label>
                <input type="number" name="km_akhir" class="form-control" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-medium">BBM Dipakai (liter)</label>
            <input type="number" name="bbm_pakai" class="form-control" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block font-medium">Tanggal Mulai</label>
                <input type="datetime-local" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Tanggal Selesai</label>
                <input type="datetime-local" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Catatan</label>
            <textarea name="catatan" class="form-control" rows="4"></textarea>
        </div>

        <div class="text-end">
            <button class="btn btn-primary">Simpan</button>
        </div>
    </form>

    <script>
    document.getElementById('kendaraan_id').addEventListener('change', function () {
        const kendaraanId = this.value;

        if (kendaraanId) {
            // Ambil data kendaraan (km terakhir)
            fetch(`/get-kendaraan/${kendaraanId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('km_awal').value = data.km_terakhir || 0;
                });

            // Ambil pemesanan berdasarkan kendaraan
            fetch(`/get-pemesanan/${kendaraanId}`)
                .then(res => res.json())
                .then(data => {
                    const select = document.getElementById('pemesanan_id');
                    select.innerHTML = '<option value="">-- Pilih Pemesanan --</option>';

                    data.forEach(p => {
                        const option = document.createElement('option');
                        option.value = p.id;
                        option.text = `${p.user.name} - ${p.tanggal_pakai}`;
                        option.dataset.tanggal = p.tanggal_pakai;
                        select.appendChild(option);
                    });
                });
        }
    });

    // Isi tanggal otomatis saat pilih pemesanan
    document.getElementById('pemesanan_id').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const tanggal = selected.dataset.tanggal;

        if (tanggal) {
            document.getElementById('tanggal_mulai').value = tanggal + 'T08:00';
        }

        const now = new Date().toISOString().slice(0, 16); // format: yyyy-MM-ddTHH:mm
        document.getElementById('tanggal_selesai').value = now;
    });
    </script>
</div>
@endsection
