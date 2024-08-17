@extends('adminlte::page')

@section('title', 'Edit Jaringan')

@section('content_header')
<h1>Edit Paket</h1>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content')
<div class="card col-md-10 mx-auto">
    <div class="card-body">
        <form action="{{ route('jaringan-atab.update', $jaringan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Gunakan method PUT untuk update -->

            <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" name="nama" id="nama" class="form-control"
                        value="{{ old('nama', $jaringan->nama) }}" required>
                    @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="latitude" class="col-sm-2 col-form-label">Latitude</label>
                <div class="col-sm-10">
                    <input type="text" name="latitude" id="latitude" class="form-control"
                        value="{{ old('latitude', $jaringan->latitude) }}" required>
                    @error('latitude')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="longitude" class="col-sm-2 col-form-label">Longitude</label>
                <div class="col-sm-10">
                    <input type="text" name="longitude" id="longitude" class="form-control"
                        value="{{ old('longitude', $jaringan->longitude) }}" required>
                    @error('longitude')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="province_id" class="col-sm-2 col-form-label">Provinsi</label>
                <div class="col-sm-10">
                    <select name="province_id" id="province_id" class="form-control">
                        <option value="">Pilih Provinsi</option>
                        @foreach($provinces as $province)
                        @if($province->name == 'JAWA BARAT' || $province->name == 'JAWA TENGAH')
                        <option value="{{ $province->id }}" {{ old('province_id', $jaringan->province_id) == $province->id ?
                            'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                    @error('province_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="city_id" class="col-sm-2 col-form-label">Kota/Kabupaten</label>
                <div class="col-sm-10">
                    <select name="city_id" id="city_id" class="form-control">
                        <option value="">==Pilih Salah Satu==</option>
                    </select>
                    @error('city_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="district_id" class="col-sm-2 col-form-label">Kecamatan</label>
                <div class="col-sm-10">
                    <select name="district_id" id="district_id" class="form-control">
                        <option value="">==Pilih Salah Satu==</option>
                    </select>
                    @error('district_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="village_id" class="col-sm-2 col-form-label">Desa</label>
                <div class="col-sm-10">
                    <select name="village_id" id="village_id" class="form-control">
                        <option value="">==Pilih Salah Satu==</option>
                    </select>
                    @error('village_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

           <div class="form-group row">
            <label for="wilayah_sungai" class="col-sm-2 col-form-label">DAS</label>
            <div class="col-sm-10">
                <select name="wilayah_sungai" id="wilayah_sungai" class="form-control">
                    <option value="">Pilih DAS</option>
                    <option value="DAS Citanduy" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Citanduy' ?
                        'selected' : '' }}>DAS Citanduy</option>
                    <option value="DAS Cibeureum" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Cibeureum' ?
                        'selected' : '' }}>DAS Cibeureum</option>
                    <option value="DAS Citotok" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Citotok' ?
                        'selected' : '' }}>DAS Citotok</option>
                    <option value="DAS Cimeneng" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Cimeneng' ?
                        'selected' : '' }}>DAS Cimeneng</option>
                    <option value="DAS Cikonde" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Cikonde' ?
                        'selected' : '' }}>DAS Cikonde</option>
                    <option value="DAS Sapuregel" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Sapuregel' ?
                        'selected' : '' }}>DAS Sapuregel</option>
                    <option value="DAS Gatel" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Gatel' ? 'selected' :
                        '' }}>DAS Gatel</option>
                    <option value="DAS Branalang" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Branalang' ?
                        'selected' : '' }}>DAS Branalang</option>
                    <option value="DAS Kipah" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Kipah' ? 'selected' :
                        '' }}>DAS Kipah</option>
                    <option value="DAS Panembung" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Panembung' ?
                        'selected' : '' }}>DAS Panembung</option>
                    <option value="DAS Karanganyar" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Karanganyar' ?
                        'selected' : '' }}>DAS Karanganyar</option>
                    <option value="DAS Tambakreja" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Tambakreja' ?
                        'selected' : '' }}>DAS Tambakreja</option>
                    <option value="DAS Nirbaya" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Nirbaya' ?
                        'selected' : '' }}>DAS Nirbaya</option>
                    <option value="DAS Solokjari" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Solokjari' ?
                        'selected' : '' }}>DAS Solokjari</option>
                    <option value="DAS Permisan" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Permisan' ?
                        'selected' : '' }}>DAS Permisan</option>
                    <option value="DAS Lembongpucung" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Lembongpucung'
                        ? 'selected' : '' }}>DAS Lembongpucung</option>
                    <option value="DAS Solok Permisan" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Solok
                        Permisan' ? 'selected' : '' }}>DAS Solok Permisan</option>
                    <option value="DAS Solokpring" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Solokpring' ?
                        'selected' : '' }}>DAS Solokpring</option>
                    <option value="DAS Pandan" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Pandan' ? 'selected'
                        : '' }}>DAS Pandan</option>
                    <option value="DAS Solokdewata" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Solokdewata' ?
                        'selected' : '' }}>DAS Solokdewata</option>
                    <option value="DAS Ciparayangan" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Ciparayangan' ?
                        'selected' : '' }}>DAS Ciparayangan</option>
                    <option value="DAS Cijolang" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Cijolang' ?
                        'selected' : '' }}>DAS Cijolang</option>
                    <option value="DAS Cipambokongan" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Cipambokongan'
                        ? 'selected' : '' }}>DAS Cipambokongan</option>
                    <option value="DAS Cipanerekean" {{ old('wilayah_sungai', $jaringan->wilayah_sungai) == 'DAS Cipanerekean' ?
                        'selected' : '' }}>DAS Cipanerekean</option>
                </select>
                @error('wilayah_sungai')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

            <div class="form-group row">
                <label for="jenis" class="col-sm-2 col-form-label">Infrastruktur</label>
                <div class="col-sm-10">
                    <select name="jenis" id="jenis" class="form-control">
                        <option value="">Pilih Infrastruktur</option>
                        <option value="Air Tanah" {{ old('jenis', $jaringan->jenis) == 'Air Tanah' ? 'selected' : ''
                            }}>Air Tanah</option>
                        <option value="Air Baku" {{ old('jenis', $jaringan->jenis) == 'Air Baku' ? 'selected' : ''
                            }}>Air Baku</option>
                        <option value="Embung" {{ old('jenis', $jaringan->jenis) == 'Embung' ? 'selected' : '' }}>Embung
                        </option>
                    </select>
                    @error('jenis')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                <div class="col-sm-10">
                    <select name="tahun" id="tahun" class="form-control">
                        <option value="">Pilih Tahun</option>
                        @for ($year = 1998; $year <= date('Y'); $year++) <option value="{{ $year }}" {{ old('tahun',
                            $jaringan->tahun) == $year ? 'selected' : '' }}>
                            {{ $year }}
                            </option>
                            @endfor
                    </select>
                    @error('tahun')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="satker" class="col-sm-2 col-form-label">Satker</label>
                <div class="col-sm-10">
                    <!-- Display read-only select input -->
                    <select name="satker_display" id="satker_display" class="form-control" disabled>
                        <option value="Satker PJPA" selected>Satker PJPA</option>
                    </select>

                    <!-- Hidden input field to ensure value is sent -->
                    <input type="hidden" name="satker" value="Satker PJPA">

                    @error('satker')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('jaringan-atab.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    function onChangeSelect(url, id, name, selectedId = null) {
        // send ajax request to get the cities of the selected province and append to the select tag
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                id: id
            },
            success: function (data) {
                $('#' + name).empty();
                $('#' + name).append('<option value="">==Pilih Salah Satu==</option>');

                $.each(data, function (key, value) {
                    let selected = selectedId == key ? 'selected' : '';
                    $('#' + name).append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                });
            }
        });
    }

    $(function () {
        $('#province_id').on('change', function () {
            onChangeSelect('{{ route("cities") }}', $(this).val(), 'city_id');
        });

        $('#city_id').on('change', function () {
            onChangeSelect('{{ route("districts") }}', $(this).val(), 'district_id');
        });

        $('#district_id').on('change', function () {
            onChangeSelect('{{ route("villages") }}', $(this).val(), 'village_id');
        });

        // Load current data for city, district, and village
        let cityId = '{{ old('city_id', $jaringan->city_id) }}';
        let districtId = '{{ old('district_id', $jaringan->district_id) }}';
        let villageId = '{{ old('village_id', $jaringan->village_id) }}';

        if ($('#province_id').val()) {
            onChangeSelect('{{ route("cities") }}', $('#province_id').val(), 'city_id', cityId);
        }

        if (cityId) {
            onChangeSelect('{{ route("districts") }}', cityId, 'district_id', districtId);
        }

        if (districtId) {
            onChangeSelect('{{ route("villages") }}', districtId, 'village_id', villageId);
        }
    });
</script>
@stop