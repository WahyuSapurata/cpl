@extends('layouts.layout')
@section('button')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="#" id="btn-extract" class="btn btn-sm btn-danger export">Export PDF</a>
        </div>
        <!--end::Actions-->
    </div>
@endsection
@section('content')
    <!-- Button trigger modal -->
    <button type="button" id="button-matakul" class="btn btn-primary d-none" data-bs-toggle="modal"
        data-bs-target="#staticBackdrop_modal">
        Launch static backdrop modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih Mata Kuliah Terlebih Dahulu</h1>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <select name="mata_kuliah" class="form-select" data-control="select2" id="mata_kuliah_select"
                        data-dropdown-parent="#staticBackdrop_modal" data-allow-clear="true"
                        data-placeholder="Pilih jenis mata kuliah">
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="row">

                <div class="card mb-5 py-3" style="width: max-content">
                    <div style="font-size: 15px; font-weight: bold">
                        <table>
                            <tr>
                                <td>Mata Kuliah</td>
                                <td>: <span id="mata_kuliah"></span></td>
                            </tr>
                            <tr>
                                <td>Kode</td>
                                <td>: <span id="kode_mk"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="container">
                            <div class="py-5 table-responsive">
                                <table id="kt_table_data"
                                    class="table table-striped table-rounded border border-gray-300 table-row-bordered table-row-gray-300">
                                    <thead class="text-center">
                                        <tr class="fw-bolder fs-6 text-gray-800">
                                            <th>No</th>
                                            <th>Kode CPL</th>
                                            <th>Nilai IK x Bobot</th>
                                            <th>Jumlah Bobot IK</th>
                                            <th>Nilai CPL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection
@section('script')
    <script>
        let control = new Control();

        $(document).ready(async function() {
            // Simulasikan klik pada tombol dengan ID 'autoClickButton'
            $('#button-matakul').click();

            try {
                const res = await $.ajax({
                    url: '/operator/get-mata-kuliah',
                    method: 'GET'
                });

                if (res.success === true) {
                    $('#mata_kuliah_select').html("");
                    let html = "<option></option>";
                    $.each(res.data, function(x, y) {
                        html += `<option value="${y.uuid}">${y.mata_kuliah}</option>`;
                    });
                    $('#mata_kuliah_select').html(html);

                    // Menanggapi perubahan pada elemen select
                    $('#mata_kuliah_select').on('change', function() {
                        let selectedUuid = $(this).val();
                        $('#staticBackdrop_modal').modal('hide');

                        initDatatable(selectedUuid);
                        extract(selectedUuid);

                        $.each(res.data, function(x, y) {
                            if (y.uuid === selectedUuid) {
                                $('#mata_kuliah').text(y.mata_kuliah);
                                $('#kode_mk').text(y.kode_mk);
                            }
                        });
                    });

                } else {
                    console.error('Gagal mengambil data:', res.message);
                }
            } catch (error) {
                console.error('Gagal melakukan permintaan AJAX:', error);
            }
        });

        $(document).on('keyup', '#search_', function(e) {
            e.preventDefault();
            control.searchTable(this.value);
        })

        const initDatatable = async (selectedUuid) => {
            // Destroy existing DataTable if it exists
            if ($.fn.DataTable.isDataTable('#kt_table_data')) {
                $('#kt_table_data').DataTable().clear().destroy();
            }

            $('#kt_table_data').DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                processing: true,
                ajax: '/dosen/get-nilaicpl/' + selectedUuid,
                columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, {
                    data: 'kode_cpl',
                    className: 'text-center',
                }, {
                    data: 'nilai_ik',
                    className: 'text-center',
                }, {
                    data: 'bobot_ik',
                    className: 'text-center',
                }, {
                    data: 'nilai_cpl',
                    className: 'text-center',
                }],
                rowCallback: function(row, data, index) {
                    var api = this.api();
                    var startIndex = api.context[0]._iDisplayStart;
                    var rowIndex = startIndex + index + 1;
                    $('td', row).eq(0).html(rowIndex);
                },
            });
        };

        const extract = (selectedUuid) => {
            $('#btn-extract').click(function(e) {
                e.preventDefault();
                window.open(`/operator/extract-pdf/` + selectedUuid, "_blank");
            });
        };
    </script>
@endsection
