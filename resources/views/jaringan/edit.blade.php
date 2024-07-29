@extends('adminlte::page')

@section('title', 'Edit Jaringan')

@section('content_header')
<h1>Edit Jaringan</h1>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content')
<div class="card col-md-10">
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
                        <option value="{{ $province->id }}" {{ old('province_id', $jaringan->province_id) ==
                            $province->id ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
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
                <label for="wilayah_sungai" class="col-sm-2 col-form-label">Wilayah Sungai</label>
                <div class="col-sm-10">
                    <input type="text" name="wilayah_sungai" id="wilayah_sungai" class="form-control"
                        value="{{ old('wilayah_sungai', $jaringan->wilayah_sungai) }}">
                    @error('wilayah_sungai')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="jenis" class="col-sm-2 col-form-label">Jenis</label>
                <div class="col-sm-10">
                    <select name="jenis" id="jenis" class="form-control">
                        <option value="">Pilih Jenis</option>
                        <option value="Irigasi" {{ old('jenis', $jaringan->jenis) == 'Irigasi' ? 'selected' : ''
                            }}>Irigasi</option>
                        <option value="Embung" {{ old('jenis', $jaringan->jenis) == 'Embung' ? 'selected' : '' }}>Embung
                        </option>
                        <option value="ATAB" {{ old('jenis', $jaringan->jenis) == 'ATAB' ? 'selected' : '' }}>ATAB
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
                            $jaringan->
                            tahun) == $year ? 'selected' : '' }}>
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
                    <select name="satker" id="satker" class="form-control">
                        <option value="">Pilih Satker</option>
                        <option value="Satker Balai" {{ old('satker', $jaringan->satker) == 'Satker Balai' ? 'selected'
                            : ''
                            }}>Satker Balai</option>
                        <option value="Satker PJPA" {{ old('satker', $jaringan->satker) == 'Satker PJPA' ? 'selected' :
                            '' }}>Satker
                            PJPA</option>
                        <option value="Satker PJSA" {{ old('satker', $jaringan->satker) == 'Satker PJSA' ? 'selected' :
                            '' }}>Satker
                            PJSA</option>
                        <option value="Satker Bendungan" {{ old('satker', $jaringan->satker) == 'Satker Bendungan' ?
                            'selected' : ''
                            }}>Satker Bendungan</option>
                    </select>
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