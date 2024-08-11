{{-- resources/views/home.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <!-- Card for Total Jaringan -->
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="card-title">Total Jaringan</div>
                <div class="card-text">
                    <h2>{{ $totalJaringan }}</h2>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <span><i class="fas fa-network-wired"></i></span>
                <a href="#" class="btn btn-light btn-sm">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Card for Total Users (Contoh Tambahan) -->
    {{--
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="card-title">Total Users</div>
                <div class="card-text">
                    <h2>{{ $totalUsers }}</h2>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users"></i></span>
                <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    --}}

    <!-- Chart for Data Overview -->
    <div class="col-lg-6 col-md-12 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5>Overview</h5>
            </div>
            <div class="card-body">
                <canvas id="overviewChart"></canvas>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('overviewChart').getContext('2d');
        var overviewChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jaringan'],
                datasets: [{
                    label: 'Total',
                    data: [{{ $totalJaringan }}],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@stop