@extends('adminlte::page')

@section('title', 'Peta Jaringan')

@section('content_header')
<div></div>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Peta Lokasi Jaringan</h3>
    </div>
    <div class="card-body">
        <div id="map"></div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #map {
        height: 500px;
        width: 100%;
    }

    .legend {
        background: white;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        position: absolute;
        bottom: 30px;
        left: 10px;
        z-index: 1000;

    }

    .legend div {
        margin: 5px 0;
    }
</style>
@stop

@section('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var map = L.map('map').setView([-7.2066386, 108.4358553], 8);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Menambahkan legenda
    var legend = L.control({position: 'bottomleft'});

    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'legend');
        div.innerHTML += '<div><i style="background: blue; width: 12px; height: 12px; display: inline-block;"></i> Air Tanah</div>';
        div.innerHTML += '<div><i style="background: red; width: 12px; height: 12px; display: inline-block;"></i> Air Baku</div>';
        div.innerHTML += '<div><i style="background: green; width: 12px; height: 12px; display: inline-block;"></i> Embung</div>';
        return div;
    };

    legend.addTo(map);

    // Fungsi untuk membuat ikon dengan warna khusus
    function getColoredIcon(color) {
        return L.icon({
            iconUrl: createColoredIcon(color),
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
    }

    // Fungsi untuk membuat SVG ikon dengan warna tertentu
    function createColoredIcon(color) {
        var svgIcon = `
            <svg width="25" height="41" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <path d="M12.5,0 C19.403,0 25,5.597 25,12.5 C25,20.186 12.5,41 12.5,41 C12.5,41 0,20.186 0,12.5 C0,5.597 5.597,0 12.5,0 Z" fill="${color}"/>
                    <path d="M12.5,6 C15.538,6 18,8.462 18,11.5 C18,14.538 15.538,17 12.5,17 C9.462,17 7,14.538 7,11.5 C7,8.462 9.462,6 12.5,6 Z" fill="#FFF"/>
                </g>
            </svg>
        `;
        return "data:image/svg+xml;base64," + btoa(svgIcon);
    }

    // Ambil data lokasi menggunakan AJAX
    $.ajax({
        url: '{{ route('data-peta') }}',
        method: 'GET',
        success: function(data) {
            data.forEach(function(location) {
                var iconColor;
                switch(location.jenis) {
                    case 'Air Tanah':
                        iconColor = 'blue';
                        break;
                    case 'Air Baku':
                        iconColor = 'red';
                        break;
                    case 'Embung':
                        iconColor = 'green';
                        break;
                    default:
                        iconColor = 'gray';
                }

                var marker = L.marker([location.latitude, location.longitude], {icon: getColoredIcon(iconColor)})
                    .addTo(map)
                    .bindPopup('<b>Nama Jaringan:</b> ' + location.nama); // Popup detail
            });
        },
        error: function(error) {
            console.error('Error fetching locations:', error);
        }
    });
</script>
@stop