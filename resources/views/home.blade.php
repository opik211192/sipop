@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<!-- Dropdown for Year and Satker Selection -->
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

                <label for="satker" class="mr-2 font-weight-bold text-primary">
                    <i class="fas fa-building mr-1"></i>Pilih Satker:
                </label>
                <select name="satker" id="satker" class="form-control font-weight-bold mr-2" style="width: 200px;"
                    onchange="this.form.submit()">
                    <option value="Balai" {{ $selectedSatker=='Balai' ? 'selected' : '' }}>Satker Balai</option>
                    <option value="PJPA" {{ $selectedSatker=='PJPA' ? 'selected' : '' }}>Satker PJPA</option>
                    <option value="PJSA" {{ $selectedSatker=='PJSA' ? 'selected' : '' }}>Satker PJSA</option>
                    <option value="Bendungan" {{ $selectedSatker=='Bendungan' ? 'selected' : '' }}>Satker Bendungan
                    </option>
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

@if($selectedSatker == 'PJPA')
<!-- Card for Total Jaringan (Placed at the top) -->
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card bg-info text-white shadow-lg">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-title font-weight-bold">Total Paket</div>
                        <div class="card-text display-4 ">{{ $totalJaringan }}</div>
                    </div>
                    <i class="fas fa-database fa-3x"></i>
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
</div>

<div class="row">
    <!-- Cards for Air Tanah, Air Baku, and Embung -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card bg-primary text-white shadow-lg">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-title font-weight-bold">Air Tanah</div>
                        <div class="card-text display-4">{{ $totalAirTanah }}</div>
                    </div>
                    <i class="fas fa-tint fa-3x"></i>
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

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card bg-warning text-white shadow-lg">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-title font-weight-bold">Air Baku</div>
                        <div class="card-text display-4">{{ $totalAirBaku }}</div>
                    </div>
                    <i class="fas fa-water fa-3x"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <a href="{{ route('jaringan-atab.index') }}"
                    class="btn btn-light btn-sm btn-block text-warning font-weight-bold">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card bg-success text-white shadow-lg">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-title font-weight-bold">Embung</div>
                        <div class="card-text display-4">{{ $totalEmbung }}</div>
                    </div>
                    <i class="fas fa-mountain fa-3x"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <a href="{{ route('jaringan-atab.index') }}"
                    class="btn btn-light btn-sm btn-block text-success font-weight-bold">
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
                <div class="mt-4 text-center">
                    <span class="legend-item bg-primary"></span> Air Tanah
                    <span class="legend-item bg-warning"></span> Air Baku
                    <span class="legend-item bg-success"></span> Embung
                </div>
            </div>
        </div>
    </div>
</div>
@else
<!-- Tampilkan pesan kosong atau tidak tampilkan apa-apa jika bukan PJPA -->
<div class="alert alert-danger">Tidak ada data yang tersedia untuk Satker selain PJPA.</div>
@endif
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

    .card-text {
        font-size: 2rem;
    }

    .btn:hover {
        transform: scale(1.05);
        transition: transform 0.2s;
    }

    /* Custom legend styling */
    .legend-item {
        display: inline-block;
        width: 40px;
        height: 20px;
        margin-right: 10px;
        margin-bottom: 10px;
        border-radius: 3px;
    }

    .legend-item+.legend-item {
        margin-left: 15px;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> <!-- Tambahkan ini -->

<script>
    @if($selectedSatker == 'PJPA')
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('tahapanChart').getContext('2d');

        // Daftar tahapan yang ingin ditampilkan di sumbu Y
        var tahapan = [
            'Persiapan',
            'Pembentukan Tim',
            'Penyusunan Rencana Kerja',
            'Sosialisasi dan Koordinasi',
            'Penyusunan Lembar Evaluasi Kesiapan OP',
            'Inventarisasi Data dan Informasi',
            'Evaluasi Awal Kesiapan OP',
            'Evaluasi Akhir Kesiapan OP',
            'Serah Terima hasil OP'
        ];

        // Data tahapan
        var data = {!! json_encode($data) !!};
        var ids = {!! json_encode($jaringanIds) !!};
        

        // Hitung persentase untuk setiap data
        var percentages = data.map(function(value) {
            if (value === tahapan.length - 1) {
            return 100; // Jika "Serah Terima hasil OP", set ke 100%
            } else if (value > 0) {
            return (value / (tahapan.length - 1)) * 100; // Hitung persentase berdasarkan posisi tahapan
            } else {
            return 0; // Jika "Persiapan" atau belum mulai
            }
        });

        var tahapanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!}, // Nama jaringan
                datasets: [{
                    label: 'Tahapan Pelaksanaan',
                    data: data, // Data tahapan
                    backgroundColor: {!! json_encode($colors) !!}, // Warna sesuai jenis jaringan
                    borderColor: {!! json_encode($borderColors) !!}, // Warna border sesuai jenis jaringan
                    borderWidth: 1
                }]
            },
            options: {
                layout: {
                    padding: {
                        top: 20 // Tambahkan padding di atas untuk memberi ruang bagi label
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: tahapan.length - 1, // Pastikan semua tahapan muncul
                        stepSize: 1,
                        ticks: {
                            callback: function(value) {
                                return tahapan[value]; // Tampilkan nama tahapan
                            },
                            font: {
                                weight: 'bold',
                                size: 12
                            }
                        },
                        title: {
                            display: true,
                            text: 'Tahapan'
                        }   
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Paket'
                        },
                        ticks: {
                            font: {
                                weight: 'bold',
                                size: 11
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Nonaktifkan legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var value = tooltipItem.raw;
                                return 'Tahapan: ' + tahapan[value]; // Menampilkan nama tahapan di tooltip
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end', // Semua label diatur ke 'end' untuk menempatkannya di atas batang
                        align: 'start', // Semua label diatur ke 'start' agar muncul di atas batang
                        formatter: function(value, context) {
                            return percentages[context.dataIndex] + '%'; // Tampilkan persentase di atas batang
                        },
                        font: {
                            weight: 'bold',
                            size: 12
                        },
                        color: '#000',
                        // Offset the label to move it further above the bar
                        offset: -20 // Menggeser label sedikit lebih tinggi di atas batang
                    }
                },
                onClick: function (event, elements) {
                    if (elements.length > 0) {
                        var index = elements[0].index;
                        var id = ids[index];
                        var url = `http://127.0.0.1:8000/jaringan-atab/${id}/show`;
                        window.location.href = url; // Arahkan ke URL berdasarkan ID
                    }
                }
            },
            plugins: [ChartDataLabels] // Aktifkan plugin ChartDataLabels
        });
    });
    @endif
</script>
@stop