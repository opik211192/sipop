<div class="modal fade" id="blanko1Modal" tabindex="-1" aria-labelledby="blanko1ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blanko1ModalLabel">Blanko 1A</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                                        <th class="col-bobot">Bobot (%)</th>
                                        <th class="col-ada-tidak-ada">Ada/Tidak ada</th>
                                        <th class="col-kondisi">Kondisi (%)</th>
                                        <th class="col-fungsi">Fungsi (%)</th>
                                        <th class="col-keterangan">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->nama_item }}</td>
                                        <td>
                                            <input type="text" name="items[{{ $item->id }}][bobot]"
                                                class="form-control bobot-input" value="{{ $item->bobot }}"
                                                oninput="validateAndConvert(this)" onchange="calculateWeights()">
                                        </td>
                                        <td>
                                            <select name="items[{{ $item->id }}][ada_tidak_ada]" class="form-control"
                                                onchange="calculateWeights()">
                                                <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada
                                                </option>
                                                <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>
                                                    Tidak Ada
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="items[{{ $item->id }}][kondisi]"
                                                class="form-control col-kondisi" value="{{ $item->kondisi ?? 0 }}"
                                                oninput="validateAndConvert(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="items[{{ $item->id }}][fungsi]"
                                                class="form-control col-fungsi" value="{{ $item->fungsi ?? 0 }}"
                                                oninput="validateAndConvert(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="items[{{ $item->id }}][keterangan]"
                                                class="form-control col-keterangan" value="{{ $item->keterangan }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Total Bobot (%)</td>
                                        <td><input type="text" class="form-control" id="total-bobot" disabled></td>
                                        <td><input type="text" class="form-control" id="total-ada-tidak-ada" disabled>
                                        </td>
                                        <td><input type="text" class="form-control" id="total-kondisi" disabled></td>
                                        <td><input type="text" class="form-control" id="total-fungsi" disabled></td>
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
                        <button type="button" class="btn btn-secondary mt-3 mb-2" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Function menghitung bobot
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
        $('#total-kondisi').val((totalBobotKondisi / totalBobot * 100).toFixed(2)); // Update total kondisi
        $('#total-fungsi').val((totalBobotFungsi / totalBobot * 100).toFixed(2)); // Update total fungsi

        // Set hidden inputs for backend
        $('#hasil-ada-tidak-ada').val((totalBobotAda / totalBobot * 100).toFixed(2));
        $('#hasil-kondisi').val((totalBobotKondisi / totalBobot).toFixed(2));
        $('#hasil-fungsi').val((totalBobotFungsi / totalBobot).toFixed(2));

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

        // Add form submission validation
        $('#evaluasi-awal-form').on('submit', function (e) {
            let totalBobot = parseFloat($('#total-bobot').val().replace(/,/g, '.')) || 0;

            if (totalBobot !== 100) {
                e.preventDefault(); // Stop form from submitting
                alert('Total bobot harus mencapai 100%. Mohon periksa kembali.');
                $('#total-bobot').addClass('is-invalid');
            } else {
                $('#total-bobot').removeClass('is-invalid');
                // Get the form data
                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                        $('#blanko1Modal').modal('hide');
                        window.opener.location.reload();
                    },
                    error: function (xhr, status, error) {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                        console.log(xhr.responseText);
                        $('#blanko1Modal').modal('hide');
                        window.opener.location.reload();
                    }
                });
            }
        });
    });
</script>