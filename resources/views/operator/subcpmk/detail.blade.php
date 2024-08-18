@extends('layouts.layout')
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="row">

                <div class="card mb-5 py-3" style="width: max-content">
                    <div style="font-size: 15px; font-weight: bold">
                        <table>
                            <tr>
                                <td>Mata Kuliah</td>
                                <td>: {{ $matkul->mata_kuliah }}</td>
                            </tr>
                            <tr>
                                <td>Kode</td>
                                <td>: {{ $matkul->kode_mk }}</td>
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
                                            <th>Kode CPMK</th>
                                            <th>Nama Sub</th>
                                            <th>Deskripsi</th>
                                            <th>Bobot (%)</th>
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

            let selectedUuid = @json($matkul->uuid);

            $('#uuid_matkul').val(selectedUuid);

            initDatatable(selectedUuid);
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
                ajax: '/dosen/get-subcpmk/' + selectedUuid,
                columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, {
                    data: 'kode_cpmk',
                    className: 'text-center',
                }, {
                    data: 'nama_sub',
                    className: 'text-center',
                }, {
                    data: 'deskripsi',
                }, {
                    data: 'bobot',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data + '%';
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
    </script>
@endsection
