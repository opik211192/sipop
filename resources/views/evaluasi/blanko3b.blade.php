<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blanko 3B</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
            <h1>Blanko 3B</h1>
            <div class="d-flex">
                <h1 class="font-weight-light">{{ $jaringan->nama }}</h1>
                <h5 class="font-weight-light">{{ $jaringan->tahun }}</h5>
            </div>
        </div>

        <!-- Form Upload di atas tombol simpan -->
        <div id="uploadSection">
            <?php
            $tahapanBlanko3b = $jaringan->tahapans->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
            $dokumenBlanko3b = $tahapanBlanko3b ? $tahapanBlanko3b->dokumens->where('nama_dokumen', 'Blanko 3B')->first() : null;
            ?>
            @if ($dokumenBlanko3b)
            <!-- Tombol Show Dokumen -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#showDokumenModal">
                <span class="fas fa-eye" title="Lihat Blanko 3B"></span> Lihat Dokumen
            </button>
            <!-- Tombol Delete Dokumen -->
            <button class="btn btn-danger" id="deleteDokumenBtn">
                <span class="fas fa-trash" title="Hapus Blanko 3B"></span> Hapus Dokumen
            </button>

            <!-- Modal Lihat Dokumen -->
            <div class="modal fade" id="showDokumenModal" tabindex="-1" role="dialog" aria-labelledby="showDokumenLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="showDokumenLabel">Lihat Dokumen Blanko 3B</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <iframe src="{{ asset('storage/blanko3b/' . basename($dokumenBlanko3b->path_dokumen)) }}"
                                width="100%" height="400px"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Aktifkan tombol submit jika dokumen ada
                $('#submitBtn').prop('disabled', false);

                $('#deleteDokumenBtn').on('click', function () {
                    if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
                        $.ajax({
                            url: '{{ route("delete-blanko3b", $jaringan->id) }}',
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    alert('Dokumen berhasil dihapus');
                                    location.reload();
                                } else {
                                    alert('Gagal menghapus dokumen, silakan coba lagi.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                                alert('Gagal menghapus dokumen, silakan coba lagi.');
                            }
                        });
                    }
                });
            </script>
            @else
            <!-- Form Upload jika dokumen belum ada -->
            <div class="col-md-6">
                <form id="upload-blanko3b-form" action="{{ route('upload-blanko3b', $jaringan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="blanko3b" class="form-label">Unggah Blanko 3B</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="blanko3b" name="blanko3b">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary"><span class="fas fa-upload"></span> Upload</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>

        <form id="blanko3b-form"
            action="{{ route('inventarisasi-awal-kesiapan-kelembagaan-sdm-proses', ['jaringan' => $jaringan->id]) }}"
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
                                <td class="d-none"><input type="text" class="form-control" id="total-kondisi" disabled>
                                </td>
                                <td class="d-none"><input type="text" class="form-control" id="total-fungsi" disabled>
                                </td>
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
                <button type="submit" class="btn btn-primary mt-3 mb-2" id="submitBtn" disabled><span
                        class="fa fa-save"></span> Simpan</button>
                <button type="button" class="btn btn-secondary mt-3 mb-2" onclick="window.close()"><span
                        class="fa fa-times"></span> Batal</button>
            </div>
        </form>
    </div>

    <script>
        // Periksa apakah dokumen sudah ada saat halaman dimuat
        $(document).ready(function() {
            @if ($dokumenBlanko3b)
            // Jika dokumen sudah ada, aktifkan tombol submit
            $('#submitBtn').prop('disabled', false);
            @endif
        });

        $('#upload-blanko3b-form').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $('#loading').show();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#loading').hide();
                    if (response.success) {
                        alert('Dokumen berhasil di-upload');
                        $('#submitBtn').prop('disabled', false);
                        // Ganti form upload dengan tombol Lihat Dokumen dan Hapus Dokumen
                        $('#uploadSection').html(`
                            <button class="btn btn-primary" data-toggle="modal" data-target="#showDokumenModal">
                                <span class="fas fa-eye" title="Lihat Blanko 3B"></span> Lihat Dokumen
                            </button>
                            <button class="btn btn-danger" id="deleteDokumenBtn">
                                <span class="fas fa-trash" title="Hapus Blanko 3B"></span> Hapus Dokumen
                            </button>
                            <div class="modal fade" id="showDokumenModal" tabindex="-1" role="dialog" aria-labelledby="showDokumenLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="showDokumenLabel">Lihat Dokumen Blanko 3B</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <iframe src="/storage/blanko3b/${response.fileName}" width="100%" height="400px"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                        location.reload();

                        // Tambahkan event listener untuk tombol Hapus Dokumen yang baru
                        $('#deleteDokumenBtn').on('click', function() {
                            if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
                                $.ajax({
                                    url: '{{ route("delete-blanko3b", $jaringan->id) }}',
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            alert('Dokumen berhasil dihapus');
                                            location.reload();
                                        } else {
                                            alert('Gagal menghapus dokumen, silakan coba lagi.');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error:', error);
                                        alert('Gagal menghapus dokumen, silakan coba lagi.');
                                    }
                                });
                            }
                        });
                    } else {
                        alert('Gagal mengunggah dokumen, silakan coba lagi.');
                    }
                },
                error: function(xhr, status, error) {
                    $('#loading').hide();
                    console.error('Error:', error);
                    alert('Gagal mengunggah dokumen, silakan coba lagi.');
                }
            });
        });

        function calculateWeights() {
            let totalItems = $('input[name^="items"][name$="[bobot]"]').length;
            let totalBobot = 0;
            let totalBobotAda = 0;
            let totalBobotKondisi = 0;
            let totalBobotFungsi = 0;

            $('input[name^="items"][name$="[bobot]"]').each(function() {
                let bobot = parseFloat($(this).val().replace(/,/g, '.')) || 0;
                let ada = $(this).closest('tr').find('select[name$="[ada_tidak_ada]"]').val();
                let kondisi = parseFloat($(this).closest('tr').find('input[name$="[kondisi]"]').val().replace(/,/g, '.')) || 0;
                let fungsi = parseFloat($(this).closest('tr').find('input[name$="[fungsi]"]').val().replace(/,/g, '.')) || 0;

                if (!isNaN(bobot)) {
                    totalBobot += bobot;
                    if (ada == '1') {
                        totalBobotAda += bobot;
                        totalBobotKondisi += (bobot * kondisi) / 100;
                        totalBobotFungsi += (bobot * fungsi) / 100;
                    }
                }
            });

            $('#total-bobot').val(totalBobot.toFixed(2));
            $('#total-ada-tidak-ada').val(totalBobotAda.toFixed(2));
            $('#total-kondisi').val(totalBobotKondisi.toFixed(2));
            $('#total-fungsi').val(totalBobotFungsi.toFixed(2));

            $('#hasil-ada-tidak-ada').val((totalBobotAda / totalBobot * 100).toFixed(2));
            $('#hasil-kondisi').val((totalBobotKondisi / totalBobot * 100).toFixed(2));
            $('#hasil-fungsi').val((totalBobotFungsi / totalBobot * 100).toFixed(2));

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

        $(document).ready(function() {
            calculateWeights();

            $('select[name^="items"]').change(function() {
                calculateWeights();
            });

            $('input[name^="items"][name$="[kondisi]"], input[name^="items"][name$="[fungsi]"], input[name^="items"][name$="[bobot]"]').on('input change', function() {
                calculateWeights();
            });

            $('#blanko3b-form').on('submit', function(e) {
                let totalBobot = parseFloat($('#total-bobot').val().replace(/,/g, '.')) || 0;

                if (totalBobot !== 100) {
                    e.preventDefault();
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