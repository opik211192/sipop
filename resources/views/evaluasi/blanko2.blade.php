<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blanko 2</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .is-invalid {
            border-color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mt-2 mb-2 align-items-center">
            <h1>Blanko 2</h1>
            <div class="d-flex">
                <h1 class="font-weight-light">{{ $jaringan->nama }}</h1>
                <h5 class="font-weight-light">{{ $jaringan->tahun }}</h5>
            </div>
        </div>
        <form id="data-informasi-non-fisik-form"
            action="{{ route('inventarisasi-awal-data-informasi-non-fisik-proses', ['jaringan' => $jaringan->id]) }}"
            method="POST">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-body bg-light">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Dokumen Administrasi</th>
                                <th>Bobot (%)</th>
                                <th>Ada/Tidak ada</th>
                                <th>Keterangan</th>
                                <th>Upload File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            $subIndex = 1;
                            $subIndex2 = 1;
                            $isPelaksanaanRendered = false;
                            $isItemno5Rendered = false;
                            $dokumenPelaksanaan = ['Kontrak', 'AS Build Drawing', 'PHO', 'Dokumentasi'];
                            $itemno5 = [
                            'Log book',
                            'Gambar dinding',
                            'Struktur organisasi P3AT/KM ATAB', 'Gambar konstruksi sumur'];
                            @endphp

                            <!-- Dokumen Perencanaan -->
                            @foreach($items as $index => $item)
                            @if($item->nama_item == 'Dokumen Perencanaan')
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama_item }}</td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][bobot]"
                                        value="{{ $item->bobot }}"></td>
                                <td><select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]">
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}"></td>
                                <td>
                                    <button type="button" class="btn btn-primary"><i class="fa fa-upload"></i></button>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            <!-- Dokumen Pelaksanaan -->
                            @if(!$isPelaksanaanRendered)
                            <tr>
                                <td rowspan="{{ count($dokumenPelaksanaan) + 1 }}">{{ $no++ }}</td>
                                <td colspan="5"><strong>Dokumen Pelaksanaan</strong></td>
                            </tr>
                            @foreach($items as $index => $item)
                            @if(in_array($item->nama_item, $dokumenPelaksanaan))
                            <tr>
                                <td>{{ chr(96 + $subIndex++) }}. {{ $item->nama_item }}</td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][bobot]"
                                        value="{{ $item->bobot }}"></td>
                                <td><select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]">
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}"></td>
                                <td>
                                    <button type="button" class="btn btn-primary"><i class="fa fa-upload"></i></button>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @php $isPelaksanaanRendered = true; @endphp
                            @endif

                            <!-- Hasil Uji Kualitas Air -->
                            @foreach($items as $index => $item)
                            @if($item->nama_item == 'Hasil Uji kualitas air')
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama_item }}</td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][bobot]"
                                        value="{{ $item->bobot }}"></td>
                                <td><select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]">
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}"></td>
                                <td>
                                    <button type="button" class="btn btn-primary"><i class="fa fa-upload"></i></button>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            <!-- Manual OP -->
                            @foreach($items as $index => $item)
                            @if($item->nama_item == 'Manual OP')
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama_item }}</td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][bobot]"
                                        value="{{ $item->bobot }}"></td>
                                <td><select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]">
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}"></td>
                                <td>
                                    <button type="button" class="btn btn-primary"><i class="fa fa-upload"></i></button>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            <!-- Item No. 5 -->
                            @if(!$isItemno5Rendered)
                            <tr>
                                <td rowspan="{{ count($itemno5) + 1 }}">{{ $no++ }}</td>
                            </tr>
                            @foreach($items as $index => $item)
                            @if(in_array($item->nama_item, $itemno5))
                            <tr>
                                <td>{{ chr(96 + $subIndex2++) }}. {{ $item->nama_item }}
                                </td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][bobot]"
                                        value="{{ $item->bobot }}"></td>
                                <td><select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]">
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}"></td>
                                <td>
                                    <button type="button" class="btn btn-primary"><i class="fa fa-upload"></i></button>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @php $isItemno5Rendered = true; @endphp
                            @endif

                            <!-- Item lainnya -->
                            @foreach($items as $index => $item)
                            @if(!in_array($item->nama_item, array_merge(['Dokumen Perencanaan', 'Hasil Uji kualitas
                            air', 'Manual OP'], $dokumenPelaksanaan, $itemno5)))
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama_item }}</td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][bobot]"
                                        value="{{ $item->bobot }}"></td>
                                <td><select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]">
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}"></td>
                                <td>
                                    <button type="button" class="btn btn-primary"><i class="fa fa-upload"></i></button>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Total Bobot (%)</td>
                                <td><input type="text" class="form-control" id="total-bobot" disabled></td>
                                <td><input type="text" class="form-control" id="bobot-ada-tidak-ada" disabled></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Input tersembunyi untuk mengirim bobot ke backend -->
            <input type="hidden" name="hasil_total_bobot" id="hasil-total-bobot">
            <input type="hidden" name="hasil_ada_tidak_ada" id="hasil-ada-tidak-ada">

            <div class="form-group">
                <button type="submit" class="btn btn-primary mt-3 mb-2">Simpan</button>
                <button type="button" class="btn btn-secondary mt-3 mb-2" onclick="window.close()">Batal</button>
            </div>
        </form>
    </div>

    {{-- modal upload --}}
    @include('evaluasi.modal-upload-blanko2')

    <script>
        function calculateWeights() {
            let totalBobot = 0;
            let totalItems = $('input[name^="items"][name$="[bobot]"]').length;
            let totalBobotAda = 0;

            $('input[name^="items"][name$="[bobot]"]').each(function () {
                let bobot = parseFloat($(this).val().replace(/,/g, '.')) || 0;
                let ada = $(this).closest('tr').find('select[name$="[ada_tidak_ada]"]').val();

                if (!isNaN(bobot)) {
                    totalBobot += bobot;
                    if (ada == '1') {
                        totalBobotAda += bobot;
                    }
                }
            });

            $('#total-bobot').val(totalBobot.toFixed(2)); // Update total bobot
            $('#bobot-ada-tidak-ada').val(totalBobotAda.toFixed(2)); // Update total ada/tidak ada

            // Set hidden inputs for backend
            $('#hasil-total-bobot').val(totalBobot.toFixed(2));
            $('#hasil-ada-tidak-ada').val((totalBobotAda / totalBobot * 100).toFixed(2));

            // Add or remove invalid class based on total bobot
            if (totalBobot !== 100) {
                $('#total-bobot').addClass('is-invalid');
            } else {
                $('#total-bobot').removeClass('is-invalid');
            }
        }

        function validateAndConvert(input) {
            input.value = input.value.replace(/,/g, '.');
            if (parseFloat(input.value) > 100) {
                input.value = 100;
            }
        }

        function toggleUploadButton(itemId) {
            let bobot = $(`input[name="items[${itemId}][bobot]"]`).val();
            let uploadBtn = $(`#upload-btn-${itemId}`);

            if (bobot && parseFloat(bobot) > 0) {
                uploadBtn.prop('disabled', false);
            } else {
                uploadBtn.prop('disabled', true);
            }
        }

        $(document).ready(function () {
            calculateWeights();

            $('select[name^="items"]').change(function () {
                calculateWeights();
            });

            $('input[name^="items"][name$="[bobot]"]').on('input change', function () {
                calculateWeights();
            });

            $('#data-informasi-non-fisik-form').on('submit', function (e) {
                let totalBobot = parseFloat($('#total-bobot').val().replace(/,/g, '.')) || 0;

                if (totalBobot !== 100) {
                    e.preventDefault();
                    alert('Total bobot harus mencapai 100%. Mohon periksa kembali.');
                    $('#total-bobot').addClass('is-invalid');
                } else {
                    $('#total-bobot').removeClass('is-invalid');
                }
            });

            // Initial check for upload buttons
            $('input[name^="items"][name$="[bobot]"]').each(function () {
                let itemId = $(this).attr('name').match(/\d+/)[0];
                toggleUploadButton(itemId);
            });
        });
    </script>
</body>

</html>