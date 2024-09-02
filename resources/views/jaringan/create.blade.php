@extends('adminlte::page')

@section('title', 'Tambah Jaringan')

@section('content_header')
<h1 class="font-weight-bold">Tambah Paket</h1>
@stop

@section('css')
@stop

@section('content')
<div class="card col-md-10 mx-auto">
    <div class="card-body">
        <form action="{{ route('jaringan-atab.store') }}" method="POST">
            @csrf

            <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                    @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="latitude" class="col-sm-2 col-form-label">Latitude</label>
                <div class="col-sm-10">
                    <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude') }}"
                        required placeholder="-6.200000">
                    @error('latitude')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="longitude" class="col-sm-2 col-form-label">Longitude</label>
                <div class="col-sm-10">
                    <input type="text" name="longitude" id="longitude" class="form-control"
                        value="{{ old('longitude') }}" required>
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
                    <option value="{{ $province->id }}" {{ old('province_id')==$province->id ? 'selected' : '' }}>
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
                        <option>==Pilih Salah Satu==</option>
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
                        <option>==Pilih Salah Satu==</option>
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
                        <option>==Pilih Salah Satu==</option>
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
                    <option value="DAS Citanduy">DAS Citanduy</option>
                    <option value="DAS Cibeureum">DAS Cibeureum</option>
                    <option value="DAS Citotok">DAS Citotok</option>
                    <option value="DAS Cimeneng">DAS Cimeneng</option>
                    <option value="DAS Cikonde">DAS Cikonde</option>
                    <option value="DAS Sapuregel">DAS Sapuregel</option>
                    <option value="DAS Gatel">DAS Gatel</option>
                    <option value="DAS Branalang">DAS Branalang</option>
                    <option value="DAS Kipah">DAS Kipah</option>
                    <option value="DAS Panembung">DAS Panembung</option>
                    <option value="DAS Karanganyar">DAS Karanganyar</option>
                    <option value="DAS Tambakreja">DAS Tambakreja</option>
                    <option value="DAS Nirbaya">DAS Nirbaya</option>
                    <option value="DAS Solokjari">DAS Solokjari</option>
                    <option value="DAS Permisan">DAS Permisan</option>
                    <option value="DAS Lembongpucung">DAS Lembongpucung</option>
                    <option value="DAS Solok Permisan">DAS Solok Permisan</option>
                    <option value="DAS Solokpring">DAS Solokpring</option>
                    <option value="DAS Pandan">DAS Pandan</option>
                    <option value="DAS Solokdewata">DAS Solokdewata</option>
                    <option value="DAS Ciparayangan">DAS Ciparayangan</option>
                    <option value="DAS Cijolang">DAS Cijolang</option>
                    <option value="DAS Cipambokongan">DAS Cipambokongan</option>
                    <option value="DAS Cipanerekean">DAS Cipanerekean</option>
                </select>
                @error('wilayah_sungai')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

            <div class="form-group row">
                <label for="satker" class="col-sm-2 col-form-label">Satker</label>
                <div class="col-sm-10">
                    <select name="satker" id="satker" class="form-control">
                        <option value="">Pilih Satker</option>
                        <option value="Satker Balai" {{ old('satker')=='Satker Balai' ? 'selected' : '' }}>Satker Balai
                        </option>
                        <option value="Satker PJPA" {{ old('satker')=='Satker PJPA' ? 'selected' : '' }}>Satker PJPA
                        </option>
                        <option value="Satker PJSA" {{ old('satker')=='Satker PJSA' ? 'selected' : '' }}>Satker PJSA
                        </option>
                        <option value="Satker Bendungan" {{ old('satker')=='Satker Bendungan' ? 'selected' : '' }}>
                            Satker Bendungan</option>
                    </select>
                    @error('satker')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="jenis" class="col-sm-2 col-form-label">Infrastruktur</label>
                <div class="col-sm-10">
                    <select name="jenis" id="jenis" class="form-control">
                        <option value="">Pilih Infrastruktur</option>
                        <option value="Air Tanah" {{ old('jenis')=='Air Tanah' ? 'selected' : '' }}>Air Tanah</option>
                        <option value="Air Baku" {{ old('jenis')=='Air Baku' ? 'selected' : '' }}>Air Baku</option>
                        <option value="Embung" {{ old('jenis')=='Embung' ? 'selected' : '' }}>Embung</option>
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
                        @for ($year = 1998; $year <= date('Y'); $year++) <option value="{{ $year }}" {{
                            old('tahun')==$year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                    </select>
                    @error('tahun')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                    <a href="{{ route('jaringan-atab.index') }}" class="btn bg-gradient-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    function onChangeSelect(url, id, name) {
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                id: id
            },
            success: function (data) {
                $('#' + name).empty();
                $('#' + name).append('<option>==Pilih Salah Satu==</option>');

                $.each(data, function (key, value) {
                    $('#' + name).append('<option value="' + key + '">' + value + '</option>');
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
    });

    $('#satker').on('change', function() {
        if ($(this).val() === 'Satker PJPA') {
            $('#jenis').prop('disabled', false);
        } else {
            $('#jenis').prop('disabled', true);
            $('#jenis').val(''); 
        }
    });

    $('#satker').trigger('change');
</script>
@stop