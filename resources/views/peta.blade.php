@extends('adminlte::page')

@section('title', 'Peta Jaringan')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">Peta Lokasi Jaringan</h1>
</div>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card shadow">
    <div class="card-header bg-gradient-primary text-white">
        <h3 class="card-title"><i class="fas fa-map-marker-alt"></i> Lokasi Jaringan</h3>
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
        border-radius: 5px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }

    .legend {
        background: rgba(255, 255, 255, 0.8);
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        position: absolute;
        bottom: 20px;
        left: 10px;
        z-index: 1000;
    }

    .legend div {
        display: flex;
        align-items: center;
        margin: 5px 0;
    }

    .legend i {
        width: 20px;
        height: 20px;
        display: inline-block;
        margin-right: 8px;
        border-radius: 3px;
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

    // Menambahkan layer groups
    var airTanahLayer = L.layerGroup();
    var airBakuLayer = L.layerGroup();
    var embungLayer = L.layerGroup();

    // Layer Control
    var baseMaps = {};
    var overlayMaps = {
        "<span style='color: blue; font-weight: bold;'><i class='fas fa-square' style='color: blue;'></i></span> Air Tanah": airTanahLayer,
        "<span style='color: red; font-weight: bold;'><i class='fas fa-square' style='color: red;'></i></span> Air Baku": airBakuLayer,
        "<span style='color: green; font-weight: bold;'><i class='fas fa-square' style='color: green;'></i></span> Embung": embungLayer
    };
    L.control.layers(baseMaps, overlayMaps, {collapsed: false}).addTo(map);

    // Menambahkan legenda
    var legend = L.control({position: 'bottomleft'});

    // legend.onAdd = function (map) {
    //     var div = L.DomUtil.create('div', 'legend');
    //     div.innerHTML += '<div><i style="background: blue;"></i> Air Tanah</div>';
    //     div.innerHTML += '<div><i style="background: red;"></i> Air Baku</div>';
    //     div.innerHTML += '<div><i style="background: green;"></i> Embung</div>';
    //     return div;
    // };

    // legend.addTo(map);

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

    // Memuat dan menampilkan GeoJSON
    $.getJSON('{{ asset('js/citanduy.json') }}', function(data) {
        L.geoJSON(data, {
            style: function(feature) {
                return {
                    color: 'blue',
                    weight: 2,
                    fillOpacity: feature.properties['fill-opacity'],
                    opacity: feature.properties['stroke-opacity']
                };
            }
        }).addTo(map);
    });

    $.ajax({
        url: '{{ route('data-peta') }}',
        method: 'GET',
        success: function(data) {
            data.forEach(function(location) {
                var iconColor;
                var targetLayer;
                switch(location.jenis) {
                    case 'Air Tanah':
                        iconColor = 'blue';
                        targetLayer = airTanahLayer;
                        break;
                    case 'Air Baku':
                        iconColor = 'red';
                        targetLayer = airBakuLayer;
                        break;
                    case 'Embung':
                        iconColor = 'green';
                        targetLayer = embungLayer;
                        break;
                    default:
                        iconColor = 'gray';
                        targetLayer = airTanahLayer; // Default layer
                }

                var marker = L.marker([location.latitude, location.longitude], {icon: getColoredIcon(iconColor)})
                    .addTo(targetLayer)
                    .bindPopup('<b>Nama Jaringan:</b> ' + location.nama); 
            });

            airTanahLayer.addTo(map);
            airBakuLayer.addTo(map);
            embungLayer.addTo(map);
        },
        error: function(error) {
            console.error('Error fetching locations:', error);
        }
    });

</script>
@stop