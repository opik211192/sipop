<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blanko 1A</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mt-2 mb-2 align-items-center">
            <h1>Blanko 1A</h1>
            <div class="d-flex ">
                <h1 class="font-weight-light">{{ $jaringan->nama }}</h1>
                <h5 class="font-weight-light">{{ $jaringan->tahun }}</h5>
            </div>
        </div>
        <form id="evaluasi-awal-form"
            action="{{ route('inventarisasi-awal-prasarana-air-tanah-proses', ['jaringan' => $jaringan->id]) }}"
            method="POST">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-body bg-light">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Prasarana Air Tanah</th>
                                <th>Ada/Tidak ada</th>
                                <th>Kondisi (%)</th>
                                <th>Fungsi (%)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_item }}</td>
                                <td>
                                    <select name="items[{{ $item->id }}][ada_tidak_ada]" class="form-control"
                                        style="width: 120px" onchange="calculateWeights()">
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="items[{{ $item->id }}][kondisi]" class="form-control"
                                        value="{{ $item->kondisi }}" oninput="validateAndConvert(this)">
                                </td>
                                <td>
                                    <input type="text" name="items[{{ $item->id }}][fungsi]" class="form-control"
                                        value="{{ $item->fungsi }}" oninput="validateAndConvert(this)">
                                </td>
                                <td>
                                    <input type="text" name="items[{{ $item->id }}][keterangan]" class="form-control"
                                        value="{{ $item->keterangan }}" style="width: 120px">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Bobot (%)</td>
                                <td><input type="text" class="form-control" id="bobot-ada-tidak-ada" disabled></td>
                                <td><input type="text" class="form-control" id="bobot-kondisi" disabled></td>
                                <td><input type="text" class="form-control" id="bobot-fungsi" disabled></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Hidden inputs to send weights to the backend -->
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
            let totalItems = $('select[name^="items"]').length;
            let itemsPresent = $('select[name^="items"]').filter(function () {
                return $(this).val() == '1';
            }).length;
            let weight = (itemsPresent / totalItems) * 100; // Calculate weight with decimals
            $('#bobot-ada-tidak-ada').val(weight.toFixed(2)); // Update the weight input
            $('#hasil-ada-tidak-ada').val(weight.toFixed(2)); // Update the hidden input

            let totalKondisi = 0;
            let totalFungsi = 0;
            let itemCount = $('input[name^="items"][name$="[kondisi]"]').length;

            $('input[name^="items"][name$="[kondisi]"]').each(function () {
                let value = parseFloat($(this).val().replace(/,/g, '.'));
                totalKondisi += isNaN(value) ? 0 : value;
            });

            $('input[name^="items"][name$="[fungsi]"]').each(function () {
                let value = parseFloat($(this).val().replace(/,/g, '.'));
                totalFungsi += isNaN(value) ? 0 : value;
            });

            let averageKondisi = (totalKondisi / itemCount).toFixed(2);
            let averageFungsi = (totalFungsi / itemCount).toFixed(2);

            $('#bobot-kondisi').val(averageKondisi);
            $('#hasil-kondisi').val(averageKondisi);
            $('#bobot-fungsi').val(averageFungsi);
            $('#hasil-fungsi').val(averageFungsi);
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
            $('input[name^="items"][name$="[kondisi]"], input[name^="items"][name$="[fungsi]"]').on('input', function () {
                calculateWeights();
            });

            $('#evaluasi-awal-form').on('submit', function (event) {
                event.preventDefault(); // Prevent the form from submitting normally

                // Get the form data
                var formData = $(this).serialize();

                // Submit the form data via AJAX
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }

                        // Close the current window
                        window.close();

                        // Refresh the parent window
                        window.opener.location.reload();
                    },
                    error: function (xhr, status, error) {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
</body>

</html>