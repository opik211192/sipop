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
</head>

<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mt-2 mb-2">
            <h1>Blanko 3D</h1>
            <h1 class="font-weight-light">{{ $jaringan->nama }}</h1>
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
                                <th>Jenis Dokumen Rencana Konservasi</th>
                                <th>Rincian</th>
                                <th>Ada/Tidak Ada</th>
                                <th>Kondisi (%)</th>
                                <th>Fungsi (%)</th>
                                <th>Keterangan</th>
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
                                    <select name="items[{{ $item->id }}][rincian][{{ $rincian->id }}][ada_tidak_ada]"
                                        class="form-control" style="width: 120px">
                                        <option value="1" {{ $rincian->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada
                                        </option>
                                        <option value="0" {{ $rincian->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak
                                            Ada</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number"
                                        name="items[{{ $item->id }}][rincian][{{ $rincian->id }}][kondisi]"
                                        class="form-control" value="{{ $rincian->kondisi }}">
                                </td>
                                <td>
                                    <input type="number"
                                        name="items[{{ $item->id }}][rincian][{{ $rincian->id }}][fungsi]"
                                        class="form-control" value="{{ $rincian->fungsi }}">
                                </td>
                                <td>
                                    <input type="text"
                                        name="items[{{ $item->id }}][rincian][{{ $rincian->id }}][keterangan]"
                                        class="form-control" value="{{ $rincian->keterangan }}" style="width: 120px">
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">Bobot (%)</td>
                                <td><input type="text" class="form-control" id="bobot-ada-tidak-ada" disabled></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary mt-3 mb-2">Simpan</button>
                <button type="button" class="btn btn-secondary mt-3 mb-2" onclick="window.close()">Batal</button>
            </div>
        </form>
    </div>

    <script>
        // Function to calculate the total weight
        function calculateWeight() {
            let totalWeight = 0;
            $('select[name^="items"]').each(function () {
                if ($(this).val() == '1') {
                    totalWeight += 1; // or any other weight logic you want to apply
                }
            });
            $('#bobot-ada-tidak-ada').val(totalWeight);
        }

        // Function to validate the form
        function validateForm() {
            let isValid = true;
            $('select[name^="items"], input[name^="items"]').each(function () {
                if ($(this).val() === '' || $(this).val() === null) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            return isValid;
        }

        $(document).ready(function () {
            // Calculate the weight on page load
            calculateWeight();

            // Recalculate the weight whenever a select value changes
            $('select[name^="items"]').change(function () {
                calculateWeight();
            });

            $('#blanko3d-form').on('submit', function (event) {
                event.preventDefault(); // Prevent the form from submitting normally

                // Validate the form
                if (!validateForm()) {
                    alert('Harap isi semua kolom.');
                    return false;
                }

                // Get the form data
                var formData = $(this).serialize();

                // Submit the form data via AJAX
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function (response) {
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