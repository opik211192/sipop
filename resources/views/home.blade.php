@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<!-- Dropdown for Year Selection -->
<div class="row mb-3">
    <div class="col-lg-12">
        <form method="GET" action="{{ route('home') }}">
            <div class="d-flex justify-content-end align-items-center">
                <label for="tahun" class="mr-2 font-weight-bold text-primary">
                    <i class="fas fa-calendar-alt mr-1"></i>Pilih Tahun:
                </label>
                <select name="tahun" id="tahun" class="form-control font-weight-bold mr-2" style="width: 120px;"
                    onchange="this.form.submit()">
                    @foreach($years as $year)
                    <option value="{{ $year }}" {{ $year==$selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                <div class="btn-group" role="group">
                    <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-placement="top"
                        title="Cari">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary" data-toggle="tooltip" data-placement="top"
                        title="Reset">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <!-- Card for Total Jaringan -->
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card bg-primary text-white shadow-lg">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-title font-weight-bold">Total Paket</div>
                        <div class="card-text display-4">{{ $totalJaringan }}</div>
                    </div>
                    <i class="fas fa-network-wired fa-3x"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <a href="{{ route('jaringan-atab.index') }}"
                    class="btn btn-light btn-sm btn-block text-primary font-weight-bold">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card for Satker PJPA -->
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card bg-info text-white shadow-lg">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-title font-weight-bold">Satker PJPA</div>
                        <ul class="list-unstyled">
                            <li>Air Tanah: <strong>{{ $totalAirTanah }}</strong></li>
                            <li>Air Baku: <strong>{{ $totalAirBaku }}</strong></li>
                            <li>Embung: <strong>{{ $totalEmbung }}</strong></li>
                        </ul>
                    </div>
                    <i class="fas fa-project-diagram fa-3x"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <a href="{{ route('jaringan-atab.index') }}"
                    class="btn btn-light btn-sm btn-block text-info font-weight-bold">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Row for Chart -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-primary text-white">
                <h3 class="card-title"><i class="fas fa-chart-bar"></i> Tahapan Pelaksanaan</h3>
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; height:500px; width:100%">
                    <canvas id="tahapanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .chart-container {
        position: relative;
        height: 500px;
        width: 100%;
    }

    .card-title {
        font-size: 1.5rem;
    }

    .list-unstyled li {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .btn:hover {
        transform: scale(1.05);
        transition: transform 0.2s;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('tahapanChart').getContext('2d');
        var tahapanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!}, // Nama jaringan
                datasets: [{
                    label: 'Tahapan Jaringan',
                    data: {!! json_encode($data) !!}, // Tahapan
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1, 
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return {!! json_encode($tahapan) !!}[value]; // Tampilkan nama tahapan
                            }
                        }
                    },
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: ''
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var value = tooltipItem.raw;
                                return 'Tahapan: ' + {!! json_encode($tahapan) !!}[value]; // Menampilkan nama tahapan di tooltip
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@stop