@extends('layouts.layout')
@section('button')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="#" id="btn-extract" class="btn btn-sm btn-danger export disabled">Export PDF</a>
        </div>
        <!--end::Actions-->
    </div>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="row">

                <div class="row justify-content-center">
                    <div class="card mb-5 py-3 w-50">
                        <form>
                            <div class="mb-10">
                                <label class="form-label">Tahun Ajaran</label>
                                <select name="tahun_ajaran" class="form-select" data-control="select2"
                                    id="from_select_tahun_ajaran" data-placeholder="Pilih">
                                </select>
                                <small class="text-danger tahun_ajaran_error"></small>
                            </div>
                            <div class="d-flex my-5">
                                <button class="btn btn-primary btn-sm" id="button-cari"></i>Cari Data</button>
                            </div>
                        </form>
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
                                            <th>Deskripsi</th>
                                            <th>Ketercapaian CPL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div id="data-kosong" class="fs-4 text-gray-400 text-center">Pilih option di atas terlebih
                                    dahulu</div>
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

        const generateSchoolYears = (startYear) => {
            const currentYear = new Date().getFullYear();
            const years = [];

            for (let year = startYear; year <= currentYear; year++) {
                years.push({
                    text: `${year}/${year + 1}`
                });
            }

            // Balik urutan tahun agar tahun sekarang berada di paling atas
            years.reverse();

            return years;
        };

        const data = generateSchoolYears(2000);

        $(function() {
            control.push_select_data(data, '#from_select_tahun_ajaran');
        });

        $(document).ready(function() {
            $(document).on('click', '#button-cari', function(e) {
                e.preventDefault(); // Menghentikan pengiriman form standar
                $('#btn-extract').removeClass('disabled');
                $('#data-kosong').empty();
                // Kosongkan elemen thead
                $('#tThead').empty();

                const tahun_ajaran = $('#from_select_tahun_ajaran').val();

                const data = {
                    'tahun_ajaran': tahun_ajaran
                };

                extract(data);

                $.ajax({
                    url: `/operator/get-cpl-operator`,
                    method: 'GET',
                    data: data,
                    success: function(res) {
                        // Hapus DataTable sebelumnya (jika ada) sebelum menginisialisasi yang baru
                        if ($.fn.DataTable.isDataTable('#kt_table_data')) {
                            $('#kt_table_data').DataTable().clear().destroy();
                        }

                        // Inisialisasi ulang DataTable dengan data yang diperbarui
                        initDatatable(res.data.data);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });

        const initDatatable = async (data) => {

            // Destroy existing DataTable if it exists
            if ($.fn.DataTable.isDataTable('#kt_table_data')) {
                $('#kt_table_data').DataTable().clear().destroy();
            }

            // Inisialisasi ulang DataTable dengan data yang diperbarui
            $('#kt_table_data').DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                processing: true,
                data: data,
                columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, {
                    data: 'kode_cpl',
                    className: 'text-center',
                }, {
                    data: 'deskripsi',
                }, {
                    data: 'nilai',
                    className: 'text-center',
                    render: function(data, type, row) {
                        // Memastikan bahwa nilai adalah angka
                        var number = parseFloat(data);
                        if (isNaN(number)) {
                            return data;
                        }

                        // Membulatkan angka ke dua desimal
                        return number.toFixed(2);
                    }
                }],
                rowCallback: function(row, data, index) {
                    var api = this.api();
                    var startIndex = api.context[0]._iDisplayStart;
                    var rowIndex = startIndex + index + 1;
                    $('td', row).eq(0).html(rowIndex);
                },
            });
        };

        const extract = (data) => {
            $('#btn-extract').click(function(e) {
                e.preventDefault();
                const jsonData = JSON.stringify(data);
                const encodedData = encodeURIComponent(jsonData);
                window.open('/operator/extract-pdf?data=' + encodedData, "_blank");
            });
        };
    </script>
@endsection
