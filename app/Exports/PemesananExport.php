<?php

namespace App\Exports;

use App\Models\Pemesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PemesananExport implements FromCollection, WithHeadings
{
    protected $from, $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        return Pemesanan::with(['user', 'kendaraan', 'driver'])
            ->whereBetween('tanggal_pakai', [$this->from, $this->to])
            ->get()
            ->map(function ($p) {
                return [
                    'Nama Pemesan'   => $p->user->name,
                    'Kendaraan'      => $p->kendaraan->nomor_plat . ' - ' . $p->kendaraan->jenis,
                    'Driver'         => $p->driver->nama,
                    'Tanggal Pakai'  => $p->tanggal_pakai,
                    'Lokasi'         => $p->lokasi,
                    'Status'         => ucfirst($p->status),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Pemesan', 'Kendaraan', 'Driver', 'Tanggal Pakai', 'Lokasi', 'Status'
        ];
    }
}

