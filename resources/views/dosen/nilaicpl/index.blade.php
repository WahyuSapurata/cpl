@extends('layouts.layout')
@section('button')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Actions-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0 gap-3">
            <button class="btn btn-info btn-sm" id="button-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" id="svg-button"
                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <style>
                        #svg-button {
                            fill: #ffffff
                        }
                    </style>
                    <path
                        d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM217.4 376.9L117.5 269.8c-3.5-3.8-5.5-8.7-5.5-13.8s2-10.1 5.5-13.8l99.9-107.1c4.2-4.5 10.1-7.1 16.3-7.1c12.3 0 22.3 10 22.3 22.3l0 57.7 96 0c17.7 0 32 14.3 32 32l0 32c0 17.7-14.3 32-32 32l-96 0 0 57.7c0 12.3-10 22.3-22.3 22.3c-6.2 0-12.1-2.6-16.3-7.1z" />
                </svg>
                Kembali</button>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="#" id="btn-extract" class="btn btn-sm btn-danger export">Export PDF</a>
        </div>
        <!--end::Actions-->
    </div>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="row">

                <div class="card">
                    <div class="card-body p-0">
                        <div class="container">
                            <div class="py-5 table-responsive">
                                <table id="kt_table_data"
                                    class="table table-striped table-rounded border border-gray-300 table-row-bordered table-row-gray-300">
                                    <thead class="text-center">
                                        <tr id="tThead" class="fw-bolder fs-6 text-gray-800">
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

        $(document).on('click', '#button-back', function() {
            const previousUrl = document.referrer; // Ambil URL sebelumnya dari document.referrer

            // Navigasi ke URL sebelumnya
            window.location.href = previousUrl;

            // Reload halaman jika sudah kembali ke URL sebelumnya
            if (window.location.href === previousUrl) {
                window.location.reload();
            }
        });

        $(document).ready(function() {

            const matkul = @json(request('uuid_matkul'));
            const tahun_ajaran = @json(request('tahun_ajaran'));

            const data = {
                'matkul': matkul,
                'tahun_ajaran': tahun_ajaran
            };

            extract(data);

            $.ajax({
                url: `/dosen/get-nilaicpl`,
                method: 'GET',
                data: data,
                success: function(res) {
                    let kodeCpl = res.data.kode_cpl.map(item => item);
                    let kodeCplHead = kodeCpl.map(cpl =>
                        `<th>${cpl}</th>`).join('');

                    let combinedData = combineDataByUuid(res.data.data);
                    let label_head = ['nama_mahasiswa', ...kodeCpl];

                    // Hapus DataTable sebelumnya (jika ada) sebelum menginisialisasi yang baru
                    if ($.fn.DataTable.isDataTable('#kt_table_data')) {
                        $('#kt_table_data').DataTable().clear().destroy();
                    }

                    // Inisialisasi ulang DataTable dengan data yang diperbarui
                    initDatatable(combinedData, kodeCplHead, label_head);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        const combineDataByUuid = (data) => {

            const combined = {};

            data.forEach(item => {
                const nama_mahasiswa = item.nama_mahasiswa;

                if (!combined[nama_mahasiswa]) {
                    combined[nama_mahasiswa] = {
                        nama_mahasiswa,
                    };
                }

                Object.keys(item).forEach(key => {
                    if (key !== 'nama_mahasiswa') {
                        combined[nama_mahasiswa][key] = parseFloat(item[key]).toFixed(2);
                    }
                });
            });

            return Object.values(combined);
        };

        const initDatatable = async (data, kodeCplHead, label_head) => {
            // Buat elemen No dengan atribut class yang sesuai
            let tr = `<tr><th>No</th><th>Nama Mahasiswa</th>${kodeCplHead}</tr>`;
            // Tambahkan elemen thead yang baru
            $('#kt_table_data thead').html(tr);

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
                            return meta.row + 1;
                        },
                    },
                    ...label_head.map((key) => {
                        return {
                            data: key,
                            render: function(data, type, row, meta) {
                                return data ? data : '0';
                            }
                        };
                    })
                ],
                rowCallback: function(row, data, index) {
                    var api = this.api();
                    var startIndex = api.context[0]._iDisplayStart;
                    var rowIndex = startIndex + index + 1;
                    $('td', row).eq(0).html(rowIndex);
                },
            });
        };

        $(function() {
            control.push_select_mahasiswa('/operator/data-master/get-mahasiswa', '#from_select_mahasiswa');
        });

        const extract = (data) => {
            $('#btn-extract').click(function(e) {
                e.preventDefault();
                const jsonData = JSON.stringify(data);
                const encodedData = encodeURIComponent(jsonData);
                window.open('/dosen/extract-pdf?data=' + encodedData, "_blank");
            });
        };
    </script>
@endsection
