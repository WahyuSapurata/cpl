@extends('layouts.layout')
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="row">

                <div class="row justify-content-center">
                    <div class="card mb-5 py-3 w-50">
                        <form>
                            <div class="mb-10">
                                <label class="form-label">Mata Kuliah</label>
                                <select name="uuid_matkul" class="form-select" data-control="select2" id="from_select_matkul"
                                    data-placeholder="Pilih jenis inputan">
                                </select>
                                <small class="text-danger uuid_matkul_error"></small>
                            </div>
                            <div class="mb-10">
                                <label class="form-label">Tahun Ajaran</label>
                                <select name="tahun_ajaran" class="form-select" data-control="select2"
                                    id="from_select_tahun_ajaran" data-placeholder="Pilih">
                                </select>
                                <small class="text-danger tahun_ajaran_error"></small>
                            </div>
                            <div class="d-flex my-5">
                                <button class="btn btn-primary btn-sm " id="button-cari"></i>Cari Data</button>
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
                                        <tr id="tThead" class="fw-bolder fs-6 text-gray-800">
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
            control.push_select_mk('/dosen/get-matkul-by-user', '#from_select_matkul');
            control.push_select_data(data, '#from_select_tahun_ajaran');
        });

        $(document).ready(function() {
            $(document).on('click', '#button-cari', function(e) {
                e.preventDefault(); // Menghentikan pengiriman form standar
                $('#data-kosong').empty();
                // Kosongkan elemen thead
                $('#tThead').empty();

                const matkul = $('#from_select_matkul').val();
                const tahun_ajaran = $('#from_select_tahun_ajaran').val();

                const data = {
                    'matkul': matkul,
                    'tahun_ajaran': tahun_ajaran
                };

                $.ajax({
                    url: `/dosen/get-nilai-cpmk`,
                    method: 'GET',
                    data: data,
                    success: function(res) {
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
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
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
