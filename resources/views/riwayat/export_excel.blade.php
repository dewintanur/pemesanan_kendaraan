<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kendaraan</th>
            <th>Plat</th>
            <th>User</th>
            <th>KM Awal</th>
            <th>KM Akhir</th>
            <th>BBM</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($riwayat as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->kendaraan->merk ?? '-' }}</td>
            <td>{{ $item->kendaraan->nomor_plat ?? '-' }}</td>
            <td>{{ $item->pemesanan->user->name ?? '-' }}</td>
            <td>{{ $item->km_awal }}</td>
            <td>{{ $item->km_akhir }}</td>
            <td>{{ $item->bbm_pakai }}</td>
            <td>{{ $item->tanggal_mulai }}</td>
            <td>{{ $item->tanggal_selesai }}</td>
            <td>{{ $item->catatan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
