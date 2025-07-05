@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h1>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Kendaraan -->
        <x-dashboard-card icon="M3 10h18M5 6h14M6 14h12M7 18h10" color="blue" title="Total Kendaraan" :value="$totalKendaraan" />
        <!-- Total Pemesanan -->
        <x-dashboard-card icon="M8 7V3m8 4V3m-9 4h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z" color="green" title="Total Pemesanan" :value="$totalPemesanan" />
        <!-- Total Driver -->
        <x-dashboard-card icon="M5.121 17.804A3 3 0 006 21h12a3 3 0 00.879-5.804M15 11a3 3 0 01-6 0m6 0a3 3 0 00-6 0" color="yellow" title="Total Driver" :value="$totalDriver" />
        <!-- Total Approver -->
        <x-dashboard-card icon="M16 7a4 4 0 01-8 0m8 0a4 4 0 00-8 0m12 14v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" color="red" title="Total Approver" :value="$totalApprover" />
    </div>

    {{-- Laporan Pemesanan --}}
    <div class="mb-10">
        <div class="bg-white shadow-lg rounded-xl p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Laporan Pemesanan</h3>
                <p class="text-sm text-gray-500">Export data pemesanan kendaraan sesuai periode.</p>
            </div>
            <a href="{{ route('laporan.index') }}"
               class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-5 rounded-lg transition">
                Lihat Laporan
            </a>
        </div>
    </div>

    {{-- Chart Pemesanan Bulanan --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Grafik Pemesanan per Bulan</h2>
        <canvas id="pemesananChart" height="120"></canvas>
    </div>

    {{-- Chart Pemesanan per Kendaraan --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Grafik Pemesanan per Kendaraan</h2>
        <canvas id="kendaraanChart" height="120"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('pemesananChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: @json($bulanLabels),
            datasets: [{
                label: 'Jumlah Pemesanan',
                data: @json($jumlahData),
                backgroundColor: 'rgba(59, 130, 246, 0.6)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const ctx2 = document.getElementById('kendaraanChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: @json($kendaraanLabels),
            datasets: [{
                label: 'Jumlah Pemesanan',
                data: @json($kendaraanData),
                backgroundColor: 'rgba(16, 185, 129, 0.6)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
