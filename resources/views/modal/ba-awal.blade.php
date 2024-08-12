<!-- Modal Penyusunan BA Hasil Evaluasi Awal Kesiapan OP -->
<div class="modal fade" id="modal-ba-evaluasi-{{ $jaringan->id }}" tabindex="-1" aria-labelledby="modalBAEvaluasiLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modalBAEvaluasiLabel">
                    <i class="fas fa-info-circle mr-2"></i> Penyusunan BA Hasil Evaluasi Awal Kesiapan OP: {{
                    $jaringan->nama }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead class="bg-gradient-primary text-white table-sm">
                                <tr>
                                    <th>No.</th>
                                    <th>Kriteria dan Rekomendasi</th>
                                    <th class="w-25">SIAP OP (Dengan Catatan)</th>
                                    <th class="w-25">SIAP OP</th>
                                    <th class="w-25">Hasil dari database</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-light">
                                    <td>1</td>
                                    <td class="text-bold">KESIAPAN DATA DAN INFORMASI PEKERJAAN FISIK</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: 100%</li>
                                            <li>Kondisi/Fungsi: > 70%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 80%</li>
                                            <li>Kondisi/Fungsi: > 80%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            {{-- ini blanko 1 --}}
                                            <li class="" id="hasil-ada-tidak-ada-1">Keberadaannya:</li>
                                            <li class="" id="hasil-kondisi-1">Kondisi:</li>
                                            <li class="" id="hasil-fungsi-1">Fungsi:</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td>2</td>
                                    <td class="text-bold">KESIAPAN DATA DAN INFORMASI PEKERJAAN NON-FISIK</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 70%</li>
                                            <li>Kondisi/Fungsi: > 70%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 80%</li>
                                            <li>Kondisi/Fungsi: > 80%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 80%</li>
                                            <li>Kondisi/Fungsi: > 80%</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td rowspan="6">3</td>
                                    <td class="text-bold border-right-0">KESIAPAN SARANA DAN PRASARANA PENDUKUNG
                                        PENGELOLA AIR TANAH DAN AIR BAKU</td>
                                    <td colspan="3"></td>
                                </tr>
                                <tr class="bg-light">
                                    <td>a. SARANA PENUNJANG OP TERPENUHI</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 80%</li>
                                            <li>Kondisi/Fungsi: > 80%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 80%</li>
                                            <li>Kondisi/Fungsi: > 80%</li>
                                        </ul>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr class="bg-light">
                                    <td>b. SARANA PENUNJANG OP TERPENUHI</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 60%</li>
                                            <li>Kondisi/Fungsi: > 70%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 60%</li>
                                            <li>Kondisi/Fungsi: > 70%</li>
                                        </ul>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr class="bg-light">
                                    <td>c. MANAJEMEN TERPENUHI</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 60%</li>
                                            <li>Kondisi/Fungsi: > 60%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 60%</li>
                                            <li>Kondisi/Fungsi: > 60%</li>
                                        </ul>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr class="bg-light">
                                    <td>d. KONSERVASI TERPENUHI</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 60%</li>
                                            <li>Kondisi/Fungsi: > 60%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 60%</li>
                                            <li>Kondisi/Fungsi: > 60%</li>
                                        </ul>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Alerts for recommendations -->
                        <div id="recommendation-success" class="alert alert-success d-flex align-items-center"
                            role="alert" style="display: none;">
                            <i class="fas fa-check-circle mr-2 fa-lg"></i>
                            <div>
                                <strong>Rekomendasi:</strong> <span class="text-uppercase">SIAP OP</span>
                            </div>
                        </div>
                        <div id="recommendation-failure" class="alert alert-danger d-flex align-items-center"
                            role="alert" style="display: none;">
                            <i class="fas fa-times-circle mr-2 fa-lg"></i>
                            <div>
                                <strong>Rekomendasi:</strong> <span class="text-uppercase">Belum SIAP OP</span>
                            </div>
                        </div>
                        <p>Upload BA Hasil Evaluasi Awal Kesiapan OP</p>
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" class="btn bg-gradient-danger text-white btn-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    $(document).ready(function () {
        $('#modal-ba-evaluasi-{{ $jaringan->id }}').on('shown.bs.modal', function () {

            $.ajax({
                url: "{{ route('api.ba-awal-kesiapan-op', $jaringan) }}",
                type: "GET",
                success: function (data) {
                    // Tampilkan hasil pada Blanko 1 dengan badge yang lebih besar dan informatif
                    $('#hasil-ada-tidak-ada-1').append(`<span class="badge badge-success ml-2" style="font-size: 14px;" title="Hasil Keberadaan">${data.blanko1.hasil_ada_tidak_ada}%</span>`);
                    $('#hasil-kondisi-1').append(`<span class="badge badge-success ml-2" style="font-size: 14px;" title="Hasil Kondisi">${data.blanko1.hasil_kondisi}%</span>`);
                    $('#hasil-fungsi-1').append(`<span class="badge badge-success ml-2" style="font-size: 14px;" title="Hasil Fungsi">${data.blanko1.hasil_fungsi}%</span>`);

                    // Log data untuk debugging
                    console.log(data);
                }
            });

        });
    });
</script>
@stop