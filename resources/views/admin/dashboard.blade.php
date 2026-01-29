@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Overview Performance')

@section('content')

<style>
    :root {
        --umb-blue: #0B4EA2;
        --umb-soft: #e8f0fb;
    }

    /* STAT CARD */
    .stat-card {
        border: none;
        border-radius: 18px;
        position: relative;
        overflow: hidden;
        transition: .3s;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 6px;
        height: 100%;
        background: var(--umb-blue);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(11,78,162,.15);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        background: var(--umb-soft);
        color: var(--umb-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.2rem;
    }

    /* CARD UMUM */
    .card-dashboard {
        border: none;
        border-radius: 18px;
        box-shadow: 0 10px 25px rgba(0,0,0,.06);
    }

    /* MOBILE */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.2rem;
        }

        canvas {
            max-height: 220px !important;
        }
    }
</style>

{{-- ==========================
    STATISTIK
========================== --}}
<div class="row g-4 mb-4">
    @php
        $stats = [
            ['label' => 'Total Pengaduan',  'value' => $total,    'icon' => 'bi-collection'],
            ['label' => 'Menunggu',         'value' => $pending,  'icon' => 'bi-clock-history'],
            ['label' => 'Diproses',         'value' => $diproses, 'icon' => 'bi-gear'],
            ['label' => 'Selesai',          'value' => $selesai,  'icon' => 'bi-check-circle'],
        ];
    @endphp

    @foreach ($stats as $stat)
        <div class="col-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="stat-icon">
                            <i class="bi {{ $stat['icon'] }}"></i>
                        </div>
                    </div>

                    <small class="text-muted">
                        {{ $stat['label'] }}
                    </small>

                    <h3 class="fw-bold mb-0 mt-1">
                        {{ $stat['value'] }}
                    </h3>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- ==========================
    GRAFIK
========================== --}}
<div class="row g-4">

    {{-- LINE CHART --}}
    <div class="col-lg-8">
        <div class="card card-dashboard h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-1">Tren Pengaduan</h6>
                <small class="text-muted">
                    Jumlah laporan masuk setiap periode
                </small>

                <div class="mt-4">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- DOUGHNUT --}}
    <div class="col-lg-4">
        <div class="card card-dashboard h-100">
            <div class="card-body p-4 text-center">
                <h6 class="fw-bold mb-1">Status Laporan</h6>
                <small class="text-muted">
                    Distribusi pengerjaan
                </small>

                <div class="mt-4">
                    <canvas id="doughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const primaryColor = '#0B4EA2';

    /* LINE CHART MULTI-DATASET */
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Pending',
                    data: {!! json_encode($dataPending) !!},
                    // Gunakan biru yang lebih gelap sedikit dari doughnut agar garis terlihat jelas
                    borderColor: '#e0f2fe', 
                    backgroundColor: 'rgba(224, 242, 254, 0.4)', // Area bawah pakai warna soft
                    pointBackgroundColor: '#e0f2fe', // Titik bulatnya senada badge
                    tension: .4,
                    fill: true,
                    pointRadius: 4
                },
                {
                    label: 'Diproses',
                    data: {!! json_encode($dataDiproses) !!},
                    borderColor: '#38bdf8', 
                    backgroundColor: 'rgba(56, 189, 248, 0.1)',
                    pointBackgroundColor: '#38bdf8',
                    tension: .4,
                    fill: true,
                    pointRadius: 4
                },
                {
                    label: 'Selesai',
                    data: {!! json_encode($dataSelesai) !!},
                    borderColor: '#1e40af', 
                    backgroundColor: 'rgba(30, 64, 175, 0.1)',
                    pointBackgroundColor: '#1e40af',
                    tension: .4,
                    fill: true,
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { 
                    display: true, 
                    position: 'top',
                    labels: { 
                        usePointStyle: true,
                        padding: 20
                    } 
                } 
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    ticks: { stepSize: 1 } 
                },
                x: { 
                    grid: { display: false } 
                }
            }
        }
    });

    /* DOUGHNUT */
    new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Diproses', 'Selesai'],
            datasets: [{
                data: [{{ $pending }}, {{ $diproses }}, {{ $selesai }}],
                backgroundColor: [
                    '#e0f2fe', // Pending (Biru Muda Pucat)
                    '#38bdf8', // Diproses (Biru Cerah)
                    '#1e40af'  // Selesai (Biru Navy/Indigo)
                ],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 14
                    }
                }
            }
        }
    });
</script>
@endpush
