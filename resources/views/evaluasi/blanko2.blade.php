<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blanko 2</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .is-invalid {
            border-color: #dc3545;
        }

        .uploading-btn {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .btn-icon {
            padding: 0.3rem;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
            window.close();
            window.opener.location.reload();
    </script>
    @endif
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
                            'Struktur organisasi P3AT/KM ATAB', 'Gambar konstruksi sumur'
                            ];
                            @endphp

                            <!-- Dokumen Perencanaan -->
                            @foreach($items as $index => $item)
                            @if($item->nama_item == 'Dokumen Perencanaan')
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama_item }}</td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][bobot]"
                                        value="{{ $item->bobot }}" readonly></td>
                                <td>
                                    <select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]" disabled>
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select>
                                    <input type="hidden" name="items[{{ $item->id }}][ada_tidak_ada]"
                                        value="{{ $item->ada_tidak_ada }}">
                                </td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}" readonly></td>
                                <td>
                                    <input type="file" id="file-{{ $item->id }}" style="display:none;">
                                    @if ($item->file_uploaded)
                                    <button type="button" id="delete-btn-{{ $item->id }}"
                                        class="btn btn-danger btn-icon delete-btn" data-item-id="{{ $item->id }}"
                                        title="Hapus Dokumen">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a href="{{ $item->file_url }}" target="_blank" class="btn btn-info btn-icon"
                                        title="Lihat Dokumen">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @else
                                    <button type="button" id="upload-btn-{{ $item->id }}"
                                        class="btn btn-primary btn-icon upload-btn" data-item-id="{{ $item->id }}"
                                        title="Upload Dokumen">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                    @endif
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
                                        value="{{ $item->bobot }}" readonly></td>
                                <td>
                                    <select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]" disabled>
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select>
                                    <input type="hidden" name="items[{{ $item->id }}][ada_tidak_ada]"
                                        value="{{ $item->ada_tidak_ada }}">
                                </td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}" readonly></td>
                                <td>
                                    <input type="file" id="file-{{ $item->id }}" style="display:none;">
                                    @if ($item->file_uploaded)
                                    <button type="button" id="delete-btn-{{ $item->id }}"
                                        class="btn btn-danger btn-icon delete-btn" data-item-id="{{ $item->id }}"
                                        title="Hapus Dokumen">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a href="{{ $item->file_url }}" target="_blank" class="btn btn-info btn-icon"
                                        title="Lihat Dokumen">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @else
                                    <button type="button" id="upload-btn-{{ $item->id }}"
                                        class="btn btn-primary btn-icon upload-btn" data-item-id="{{ $item->id }}"
                                        title="Upload Dokumen">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                    @endif
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
                                        value="{{ $item->bobot }}" readonly></td>
                                <td>
                                    <select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]" disabled>
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select>
                                    <input type="hidden" name="items[{{ $item->id }}][ada_tidak_ada]"
                                        value="{{ $item->ada_tidak_ada }}">
                                </td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}" readonly></td>
                                <td>
                                    <input type="file" id="file-{{ $item->id }}" style="display:none;">
                                    @if ($item->file_uploaded)
                                    <button type="button" id="delete-btn-{{ $item->id }}"
                                        class="btn btn-danger btn-icon delete-btn" data-item-id="{{ $item->id }}"
                                        title="Hapus Dokumen">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a href="{{ $item->file_url }}" target="_blank" class="btn btn-info btn-icon"
                                        title="Lihat Dokumen">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @else
                                    <button type="button" id="upload-btn-{{ $item->id }}"
                                        class="btn btn-primary btn-icon upload-btn" data-item-id="{{ $item->id }}"
                                        title="Upload Dokumen">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                    @endif
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
                                        value="{{ $item->bobot }}" readonly></td>
                                <td>
                                    <select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]" disabled>
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select>
                                    <input type="hidden" name="items[{{ $item->id }}][ada_tidak_ada]"
                                        value="{{ $item->ada_tidak_ada }}">
                                </td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}" readonly></td>
                                <td>
                                    <input type="file" id="file-{{ $item->id }}" style="display:none;">
                                    @if ($item->file_uploaded)
                                    <button type="button" id="delete-btn-{{ $item->id }}"
                                        class="btn btn-danger btn-icon delete-btn" data-item-id="{{ $item->id }}"
                                        title="Hapus Dokumen">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a href="{{ $item->file_url }}" target="_blank" class="btn btn-info btn-icon"
                                        title="Lihat Dokumen">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @else
                                    <button type="button" id="upload-btn-{{ $item->id }}"
                                        class="btn btn-primary btn-icon upload-btn" data-item-id="{{ $item->id }}"
                                        title="Upload Dokumen">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            <!-- Item No. 5 -->
                            @if(!$isItemno5Rendered)
                            <tr>
                                <td rowspan="{{ count($itemno5) + 1 }}">{{ $no++ }}</td>
                                {{-- <td colspan="5"><strong>Item No. 5</strong></td> --}}
                            </tr>
                            @foreach($items as $index => $item)
                            @if(in_array($item->nama_item, $itemno5))
                            <tr>
                                <td>{{ chr(96 + $subIndex2++) }}. {{ $item->nama_item }}
                                </td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][bobot]"
                                        value="{{ $item->bobot }}" readonly></td>
                                <td>
                                    <select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]" disabled>
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select>
                                    <input type="hidden" name="items[{{ $item->id }}][ada_tidak_ada]"
                                        value="{{ $item->ada_tidak_ada }}">
                                </td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}" readonly></td>
                                <td>
                                    <input type="file" id="file-{{ $item->id }}" style="display:none;">
                                    @if ($item->file_uploaded)
                                    <button type="button" id="delete-btn-{{ $item->id }}"
                                        class="btn btn-danger btn-icon delete-btn" data-item-id="{{ $item->id }}"
                                        title="Hapus Dokumen">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a href="{{ $item->file_url }}" target="_blank" class="btn btn-info btn-icon"
                                        title="Lihat Dokumen">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @else
                                    <button type="button" id="upload-btn-{{ $item->id }}"
                                        class="btn btn-primary btn-icon upload-btn" data-item-id="{{ $item->id }}"
                                        title="Upload Dokumen">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                    @endif
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
                                        value="{{ $item->bobot }}" readonly></td>
                                <td>
                                    <select class="form-control" name="items[{{ $item->id }}][ada_tidak_ada]" disabled>
                                        <option value="1" {{ $item->ada_tidak_ada == 1 ? 'selected' : '' }}>Ada</option>
                                        <option value="0" {{ $item->ada_tidak_ada == 0 ? 'selected' : '' }}>Tidak Ada
                                        </option>
                                    </select>
                                    <input type="hidden" name="items[{{ $item->id }}][ada_tidak_ada]"
                                        value="{{ $item->ada_tidak_ada }}">
                                </td>
                                <td><input type="text" class="form-control" name="items[{{ $item->id }}][keterangan]"
                                        value="{{ $item->keterangan }}" readonly></td>
                                <td>
                                    <input type="file" id="file-{{ $item->id }}" style="display:none;">
                                    @if ($item->file_uploaded)
                                    <button type="button" id="delete-btn-{{ $item->id }}"
                                        class="btn btn-danger btn-icon delete-btn" data-item-id="{{ $item->id }}"
                                        title="Hapus Dokumen">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a href="{{ $item->file_url }}" target="_blank" class="btn btn-info btn-icon"
                                        title="Lihat Dokumen">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @else
                                    <button type="button" id="upload-btn-{{ $item->id }}"
                                        class="btn btn-primary btn-icon upload-btn" data-item-id="{{ $item->id }}"
                                        title="Upload Dokumen">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                    @endif
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
                <div class="form-group">
                    <button type="submit" class="btn btn-primary mt-3 mb-2">Simpan</button>
                    <button type="button" class="btn btn-secondary mt-3 mb-2" onclick="window.close()">Kembali</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function calculateWeights() {
        let totalBobot = 0;
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

        $('#total-bobot').val(totalBobot.toFixed(2));
        $('#bobot-ada-tidak-ada').val(totalBobotAda.toFixed(2));

        $('#hasil-total-bobot').val(totalBobot.toFixed(2));
        $('#hasil-ada-tidak-ada').val((totalBobotAda / totalBobot * 100).toFixed(2));

        if (totalBobot !== 100) {
            $('#total-bobot').addClass('is-invalid');
        } else {
            $('#total-bobot').removeClass('is-invalid');
        }
    }

    $(document).ready(function () {
        window.addEventListener('beforeunload', function (event) {
            if (window.opener && !window.opener.closed) {
                window.opener.location.reload(); // Refresh window opener
            }
        });

        calculateWeights();

        $('.upload-btn').click(function () {
            var itemId = $(this).data('item-id');
            $('#file-' + itemId).click();
        });

        $('input[type="file"]').change(function () {
            var itemId = $(this).attr('id').split('-')[1];
            var formData = new FormData();
            formData.append('path_blanko', $(this)[0].files[0]);

            var uploadBtn = $('#upload-btn-' + itemId);
            uploadBtn.html('<i class="fa fa-spinner fa-spin"></i>');
            uploadBtn.addClass('uploading-btn');
            uploadBtn.prop('disabled', true);

            $.ajax({
                url: '/inventarisasi-awal-data-informasi-non-fisik/upload-dokumen/' + itemId,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        alert('File berhasil diupload.');
                        window.location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    alert('Gagal mengupload file. Silakan coba lagi.');
                },
                complete: function () {
                    uploadBtn.removeClass('uploading-btn');
                    uploadBtn.prop('disabled', false);
                }
            });
        });

        function deleteFile(itemId) {
            // Disable button to prevent multiple clicks
            var deleteBtn = $('#delete-btn-' + itemId);
            deleteBtn.prop('disabled', true);

            if (confirm('Apakah Anda yakin ingin menghapus file ini?')) {
                $.ajax({
                    url: '/inventarisasi-awal-data-informasi-non-fisik/delete-dokumen/' + itemId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            alert('File berhasil dihapus.');
                            window.location.reload(); // Refresh halaman setelah file dihapus
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Gagal menghapus file. Silakan coba lagi.');
                        deleteBtn.prop('disabled', false);
                    }
                });
            } else {
                // Re-enable button if cancel is pressed
                deleteBtn.prop('disabled', false);
            }
        }

        $(document).on('click', '.delete-btn', function () {
            var itemId = $(this).data('item-id');
            deleteFile(itemId);
        });

        $('select[name^="items"], input[name^="items"][name$="[bobot]"]').change(function () {
            calculateWeights();
        });

        calculateWeights();
    });
    </script>
</body>

</html>