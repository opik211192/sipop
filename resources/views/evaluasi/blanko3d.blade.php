<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blanko 3D</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }

        .col-bobot {
            width: 120px;
        }

        .col-ada-tidak-ada {
            width: 150px;
        }

        .col-kondisi,
        .col-fungsi {
            width: 80px;
        }

        .col-keterangan {
            width: 200px;
        }

        .is-invalid {
            border-color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        @if(session('success'))
        <script>
            alert('{{ session("success") }}');
            window.close();
            window.opener.location.reload();
        </script>
        @endif

        <div class="d-flex justify-content-between mt-2 mb-2 align-items-center">
            <h1>Blanko 3D</h1>
            <div class="d-flex">
                <h1 class="font-weight-light">{{ $jaringan->nama }}</h1>
                <h5 class="font-weight-light">{{ $jaringan->tahun }}</h5>
            </div>
        </div>
        <form id="blanko3d-form"
            action="{{ route('inventarisasi-awal-kesiapan-konservasi-proses', ['jaringan' => $jaringan->id]) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body bg-light">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Kelembagaan dan SDM</th>
                                <th>Rincian</th>
                                <th class="col-bobot">Bobot (%)</th>
                                <th class="col-ada-tidak-ada">Ada/Tidak Ada</th>
                                <th class="col-kondisi d-none">Kondisi (%)</th>
                                <th class="col-fungsi d-none">Fungsi (%)</th>
                                <th class="col-keterangan">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $index => $item)
                            @php
                            $alphas = range('a', 'z');
                            @endphp
                            <tr>
                                <td rowspan="{{ count($item->rincians) }}">{{ $index + 1 }}</td>
                                <td rowspan="{{ count($item->rincians) }}">{{ $item->nama_item }}</td>
                                @foreach($item->rincians as $rincianIndex => $rincian)
                                @if($rincianIndex > 0)
                            </tr>
                            <tr>
                                @endif
                                <td>{{ $alphas[$rincianIndex] }}. {{ $rincian->rincian }}</td>
                                <td>
                                    <input type="text" name="items[{{ $item->id }}][rincian][{{ $rincian->id }}][bobot]"
                                        class="form-control" value="{{ $rincian->bobot }}" max="100"
                                        oninput="validateAndConvert(this)" onchange="calculateWeights()" readonly>
                                </td>
                                <td>
                                    <select name="items[{{ $item->id }}][rincian][{{ $rincian->id }}][ada_tidak_ada]"
                                        class="form-control" style="width: 120px" onchange="calculateWeights()">
                                        <option value="1" {{ $rincian->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada
                                        </option>
                                        <option value="0" {{ $rincian->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select>
                                </td>
                                <td class="d-none">
                                    <input type="text"
                                        name="items[{{ $item->id }}][rincian][{{ $rincian->id }}][kondisi]"
                                        class="form-control" value="{{ $rincian->kondisi }}" max="100"
                                        oninput="validateAndConvert(this)">
                                </td>
                                <td class="d-none">
                                    <input type="text"
                                        name="items[{{ $item->id }}][rincian][{{ $rincian->id }}][fungsi]"
                                        class="form-control" value="{{ $rincian->fungsi }}" max="100"
                                        oninput="validateAndConvert(this)">
                                </td>
                                <td>
                                    <input type="text"
                                        name="items[{{ $item->id }}][rincian][{{ $rincian->id }}][keterangan]"
                                        class="form-control" value="{{ $rincian->keterangan }}">
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">Total Bobot (%)</td>
                                <td><input type="text" class="form-control" id="total-bobot" disabled></td>
                                <td><input type="text" class="form-control" id="total-ada-tidak-ada" disabled></td>
                                <td class="d-none"><input type="text" class="form-control" id="total-kondisi" disabled></td>
                                <td class="d-none"><input type="text" class="form-control" id="total-fungsi" disabled></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Input tersembunyi untuk mengirim bobot ke backend -->
            <input type="hidden" name="hasil_ada_tidak_ada" id="hasil-ada-tidak-ada">
            <input type="hidden" name="hasil_kondisi" id="hasil-kondisi">
            <input type="hidden" name="hasil_fungsi" id="hasil-fungsi">

            <div class="form-group">
                <button type="submit" class="btn btn-primary mt-3 mb-2">Simpan</button>
                <button type="button" class="btn btn-secondary mt-3 mb-2" onclick="window.close()">Batal</button>
            </div>
        </form>
    </div>

    <script>
        // Function menghitung ada tidak ada
        function calculateWeights() {
            let totalItems = $('input[name^="items"][name$="[bobot]"]').length;
            let totalBobot = 0;
            let totalBobotAda = 0;
            let totalBobotKondisi = 0;
            let totalBobotFungsi = 0;

            $('input[name^="items"][name$="[bobot]"]').each(function () {
                let bobot = parseFloat($(this).val().replace(/,/g, '.')) || 0;
                let ada = $(this).closest('tr').find('select[name$="[ada_tidak_ada]"]').val();
                let kondisi = parseFloat($(this).closest('tr').find('input[name$="[kondisi]"]').val().replace(/,/g, '.')) || 0;
                let fungsi = parseFloat($(this).closest('tr').find('input[name$="[fungsi]"]').val().replace(/,/g, '.')) || 0;

                if (!isNaN(bobot)) {
                    totalBobot += bobot;
                    if (ada == '1') {
                        totalBobotAda += bobot;
                    }
                    if (!isNaN(kondisi)) {
                        totalBobotKondisi += bobot * (kondisi / 100);
                    }
                    if (!isNaN(fungsi)) {
                        totalBobotFungsi += bobot * (fungsi / 100);
                    }
                }
            });

            $('#total-bobot').val(totalBobot.toFixed(2)); // Update total bobot
            $('#total-ada-tidak-ada').val(totalBobotAda.toFixed(2)); // Update total ada/tidak ada
            $('#total-kondisi').val((totalBobotKondisi).toFixed(2)); // Update total kondisi
            $('#total-fungsi').val((totalBobotFungsi).toFixed(2)); // Update total fungsi

            // Set hidden inputs for backend
            $('#hasil-ada-tidak-ada').val((totalBobotAda / totalBobot * 100).toFixed(2));
            $('#hasil-kondisi').val((totalBobotKondisi / totalBobot * 100).toFixed(2));
            $('#hasil-fungsi').val((totalBobotFungsi / totalBobot * 100).toFixed(2));

            // Add or remove invalid class based on total bobot
            if (totalBobot !== 100) {
                $('#total-bobot').addClass('is-invalid');
            } else {
                $('#total-bobot').removeClass('is-invalid');
            }
        }

        // Function to validate input and convert comma to dot for decimal input
        function validateAndConvert(input) {
            input.value = input.value.replace(/,/g, '.');
            if (parseFloat(input.value) > 100) {
                input.value = 100;
            }
        }

        $(document).ready(function () {
            // Calculate the weights on page load
            calculateWeights();

            // Recalculate the weights whenever a select value changes
            $('select[name^="items"]').change(function () {
                calculateWeights();
            });

            // Recalculate weights whenever an input value changes
            $('input[name^="items"][name$="[kondisi]"], input[name^="items"][name$="[fungsi]"], input[name^="items"][name$="[bobot]"]').on('input change', function () {
                calculateWeights();
            });

            $('#blanko3d-form').on('submit', function (e) {
                let totalBobot = parseFloat($('#total-bobot').val().replace(/,/g, '.')) || 0;

                if (totalBobot !== 100) {
                    e.preventDefault(); // Stop form from submitting
                    alert('Total bobot harus mencapai 100%. Mohon periksa kembali.');
                    $('#total-bobot').addClass('is-invalid');
                } else {
                    $('#total-bobot').removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>