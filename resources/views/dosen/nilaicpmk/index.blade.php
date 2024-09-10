@extends('layouts.layout')
@section('button')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
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
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <div id="alert-bobot"></div>
        </div>
        <!--end::Actions-->
    </div>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="row">

                <div class="rounded bg-white p-5 mb-2">
                    <form class="row w-100 d-flex align-items-center">
                        <div class="col-md-10 d-flex gap-4">
                            <select name="tahun_ajaran" class="form-select" data-control="select2"
                                id="from_select_tahun_ajaran" data-placeholder="Pilih Tahun Ajaran">
                            </select>
                            <select name="uuid_matkul" class="form-select" data-control="select2" id="from_select_matkul"
                                data-placeholder="Pilih Mata Kuliah">
                            </select>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center align-items-end">
                            <button class="btn btn-primary btn-sm " id="button-cari"></i>Cari Data</button>
                        </div>
                    </form>
                </div>

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

        const generateSchoolYears = (startYear) => {
            const currentYear = new Date().getFullYear();
            const years = [];

            for (let year = startYear; year <= currentYear; year++) {
                years.push({
                    text: `${year}/${year + 1}`
                });
            }

            // Membalik urutan tahun agar tahun sekarang berada di paling atas
            return years.reverse();
        };

        const data = generateSchoolYears(2000);

        $(function() {
            pushSelectTahunAjaran(data, '#from_select_tahun_ajaran');
            pushMataKuliah('/dosen/get-matkul-by-user', '#from_select_matkul');
        });

        function pushSelectTahunAjaran(data, element) {
            $(element).empty();
            let html = "<option></option>";
            $.each(data, function(index, item) {
                const isSelected = item.text === @json(request('tahun_ajaran')) ? 'selected' : '';
                html += `<option value="${item.text}" ${isSelected}>${item.text}</option>`;
            });
            $(element).html(html);
        }

        function pushMataKuliah(url, element) {
            $.ajax({
                url: url,
                method: "GET",
                success: function(res) {
                    $(element).empty();
                    let html = "<option></option>";
                    $.each(res.data, function(index, item) {
                        const isSelected = item.uuid === @json(request('uuid_matkul')) ? 'selected' : '';
                        html +=
                            `<option value="${item.uuid}" ${isSelected}>${item.mata_kuliah}</option>`;
                    });
                    $(element).html(html);
                },
                error: function(xhr) {
                    alert("Gagal memuat data mata kuliah");
                },
            });
        }

        $(document).ready(function() {

            // Ambil nilai dari request jika ada
            const matkul = @json(request('uuid_matkul'));
            const tahun_ajaran = @json(request('tahun_ajaran'));

            // Fungsi untuk melakukan AJAX request dan memuat data ke DataTable
            function loadData(matkul, tahun_ajaran) {
                const data = {
                    'matkul': matkul,
                    'tahun_ajaran': tahun_ajaran
                };

                $.ajax({
                    url: `/dosen/get-nilai-cpmk`,
                    method: 'GET',
                    data: data,
                    success: function(res) {
                        if (res.data && res.data.kode_cpmk) {
                            let kodeCpmk = res.data.kode_cpmk.map(item => item);
                            let kodeCpmkHead = kodeCpmk.map(cpmk =>
                                `<th>${cpmk}</th>`).join('');

                            let combinedData = combineDataByUuid(res.data.data);
                            let label_head = ['nama_mahasiswa', ...kodeCpmk];

                            // Hapus DataTable sebelumnya (jika ada) sebelum menginisialisasi yang baru
                            if ($.fn.DataTable.isDataTable('#kt_table_data')) {
                                $('#kt_table_data').DataTable().clear().destroy();
                            }

                            // Inisialisasi ulang DataTable dengan data yang diperbarui
                            initDatatable(combinedData, kodeCpmkHead, label_head);
                        } else {
                            console.error('Data CPMK tidak tersedia.');
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            // Jika ada request dari URL, langsung panggil fungsi loadData
            if (matkul && tahun_ajaran) {
                loadData(matkul, tahun_ajaran);
            }

            // Event listener untuk tombol "Cari Data"
            $('#button-cari').on('click', function(e) {
                e.preventDefault(); // Prevent form submission

                // Ambil nilai baru dari form
                const matkul = $('#from_select_matkul').val();
                const tahun_ajaran = $('#from_select_tahun_ajaran').val();

                // Validasi input sebelum mencari ulang data
                if (matkul && tahun_ajaran) {
                    loadData(matkul, tahun_ajaran);
                } else {
                    alert('Mata kuliah dan tahun ajaran harus dipilih.');
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

        const initDatatable = async (data, kodeCpmkHead, label_head) => {
            // Buat elemen No dengan atribut class yang sesuai
            let tr = `<tr><th>No</th><th>Nama Mahasiswa</th>${kodeCpmkHead}</tr>`;
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
    </script>
@endsection
