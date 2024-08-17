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
                    <div class="text-muted fs-sm-2">Grafik Masih Kosong Pilih Mata Kuliah Terlebih Dahulu</div>
                </div>

                <div id="onData" class="card justify-content-center align-items-center shadow-lg d-none">
                    <div id="loading" class="spinner-border loading text-danger"
                        style="width: 20px; height: 20px; position: absolute;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <canvas id="kt_chartjs" style="max-height: 400px"></canvas>
                </div>

                <div id="noGrafik" class="d-grid justify-content-center gap-5 d-none" style="justify-items: center">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20em"
                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <style>
                            svg {
                                fill: #6363636b
                            }
                        </style>
                        <path
                            d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                    </svg>
                    <div class="text-muted fs-sm-2">Belum ada nilai cpl</div>
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
                    url: `/operator/get-cpl-dashboard`,
                    method: 'GET',
                    data: data,
                    beforeSend: function() {
                        $('.loading').show();
                    },
                    success: function(response) {
                        if (response.data.data && Object.keys(response.data.data).length > 0) {
                            getGrafik(response.data.data);
                        } else {
                            // Data kosong, kosongkan grafik atau lakukan sesuatu yang sesuai
                            clearGrafik();
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    },
                    complete: function() {
                        // Menyembunyikan elemen loading setelah permintaan AJAX selesai
                        $('.loading').hide();
                    }
                });
            });
        });

        function getGrafik(data) {
            $('#onData').removeClass('d-none');
            $('#noGrafik').addClass('d-none');
            var ctx = document.getElementById('kt_chartjs').getContext('2d');
            var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');

            var labels = [];
            var jumlahData = [];
            var backgroundColors = [];
            var nilaiBobot = [];

            // Mengiterasi objek data
            for (const [key, value] of Object.entries(data)) {
                labels.push(value.kode_cpl + ' Target ' + '70' + '%');
                jumlahData.push(value.nilai);
                nilaiBobot.push(value.total_bobot);

                // Menambahkan warna acak untuk setiap bar
                backgroundColors.push(getRandomColor());
            }

            // Fungsi untuk menghasilkan warna acak
            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            // Chart data
            const chartData = {
                labels: labels,
                datasets: [{
                    label: 'Nilai CPL', // Menggunakan label umum untuk dataset
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    pointBackgroundColor: 'rgb(255, 99, 132)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)',
                    data: jumlahData,
                }, {
                    label: 'Target Bobot', // Menggunakan label umum untuk dataset
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgb(54, 162, 235)',
                    pointBackgroundColor: 'rgb(54, 162, 235)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(54, 162, 235)',
                    data: nilaiBobot,
                }]
            };

            // Chart config
            const config = {
                type: 'radar',
                data: chartData,
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Grafik Nilai Berdasarkan CPL'
                        }
                    },
                    responsive: true,
                    scales: {
                        r: {
                            beginAtZero: true,
                            angleLines: {
                                display: true
                            },
                            suggestedMin: 0,
                            suggestedMax: 100
                        }
                    },
                    defaults: {
                        global: {
                            defaultFont: fontFamily
                        }
                    }
                }
            };

            // Destroy existing chart if it exists
            if (window.myChart) {
                window.myChart.destroy();
            }

            // Create new ChartJS instance
            window.myChart = new Chart(ctx, config);
        }

        function clearGrafik() {
            $('#noGrafik').removeClass('d-none');
            $('#onData').addClass('d-none');
        }
    </script>
@endsection
