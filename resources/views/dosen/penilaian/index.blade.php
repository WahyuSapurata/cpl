@extends('layouts.layout')
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="row">

                <div class="row justify-content-center">
                    <div class="card mb-5 py-3 w-50">
                        <form method="GET" action="{{ route('dosen.get-penilaian') }}">
                            <div class="mb-10">
                                <label class="form-label">Mata Kuliah</label>
                                <select name="uuid_matkul" class="form-select" data-control="select2"
                                    id="from_select_matkul" data-placeholder="Pilih jenis inputan">
                                </select>
                                <small class="text-danger uuid_matkul_error"></small>
                            </div>
                            <div class="mb-10">
                                <label class="form-label">CPMK</label>
                                <select name="uuid_cpmk" class="form-select" data-control="select2" id="from_select_cpmk"
                                    data-placeholder="Pilih">
                                </select>
                                <small class="text-danger uuid_cpmk_error"></small>
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
            $('#from_select_matkul').on('change', function() {
                let selectedUuid = $(this).val();
                control.push_select_kode_cpmk('/dosen/get-cpmk-by-matkul/' + selectedUuid,
                    '#from_select_cpmk');
            });
            control.push_select_data(data, '#from_select_tahun_ajaran');
        });

        $(function() {
            control.push_select_mahasiswa('/operator/data-master/get-mahasiswa', '#from_select_mahasiswa');
        });
    </script>
@endsection
