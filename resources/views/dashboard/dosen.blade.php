@extends('layouts.layout')
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">

            <form class="row p-8 bg-white rounded-2 mb-5">
                <div class="col-md-10">
                    <label class="form-label">Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="form-select" data-control="select2" id="from_select_tahun_ajaran"
                        data-placeholder="Pilih">
                    </select>
                    <small class="text-danger tahun_ajaran_error"></small>
                </div>
                <div class="col-md-2 d-flex justify-content-center align-items-end">
                    <button class="btn btn-primary btn-sm " id="button-cari"></i>Cari Data</button>
                </div>
            </form>

            <div class="row">
                <div id="noData" class="d-grid justify-content-center gap-5" style="justify-items: center">
                    <svg xmlns="http://www.w3.org/2000/svg" height="10em"
                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <style>
                            svg {
                                fill: #6363636b
                            }
                        </style>
                        <path
                            d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                    </svg>
                    <div class="text-muted fs-sm-2">Pilih Tahun Ajaran Terlebih Dahulu</div>
                </div>

                <div id="kosong" class="d-grid justify-content-center gap-5 d-none" style="justify-items: center">
                    <svg xmlns="http://www.w3.org/2000/svg" height="10em"
                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <style>
                            svg {
                                fill: #6363636b
                            }
                        </style>
                        <path
                            d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                    </svg>
                    <div class="text-muted fs-sm-2">Mata Kuliah Belum Ada</div>
                </div>

                <div id="row-matkul" class="row">

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
                $('#noData').addClass('d-none');

                const tahun_ajaran = $('#from_select_tahun_ajaran').val();

                const data = {
                    'tahun_ajaran': tahun_ajaran
                };

                $.ajax({
                    url: `/dosen/get-kelas`,
                    method: 'GET',
                    data: data,
                    success: function(response) {
                        $('#row-matkul')
                            .empty(); // Kosongkan konten sebelumnya sebelum menambahkan elemen baru

                        if (response.data.length > 0) {
                            $('#kosong').addClass('d-none');
                            response.data.forEach(element => {
                                // Membangun URL dinamis di dalam JavaScript
                                const urlDetail = `/dosen/dashboard/${element.uuid}`;

                                $('#row-matkul').append(`
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body d-grid gap-3">
                                                <div class="fs-3 fw-bolder text-center">${element.matkul}</div>
                                                <a href="${urlDetail}" class="btn btn-primary">Lihat Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });
                        } else {
                            $('#kosong').removeClass('d-none');
                        }

                    },
                    error: function(error) {
                        console.error(error);
                    },
                });
            });
        });
    </script>
@endsection
