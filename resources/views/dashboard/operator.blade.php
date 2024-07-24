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
                    <svg xmlns="http://www.w3.org/2000/svg" height="20em"
                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <style>
                            svg {
                                fill: #6363636b
                            }
                        </style>
                        <path
                            d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM164.7 328.7c22-22 53.9-40.7 91.3-40.7s69.3 18.7 91.3 40.7c11.1 11.1 20.1 23.4 26.4 35.4c6.2 11.7 10.3 24.4 10.3 35.9c0 5.2-2.6 10.2-6.9 13.2s-9.8 3.7-14.7 1.8l-20.5-7.7c-26.9-10.1-55.5-15.3-84.3-15.3h-3.2c-28.8 0-57.3 5.2-84.3 15.3L149.6 415c-4.9 1.8-10.4 1.2-14.7-1.8s-6.9-7.9-6.9-13.2c0-11.6 4.2-24.2 10.3-35.9c6.3-12 15.3-24.3 26.4-35.4zm-31.2-182l89.9 47.9c10.7 5.7 10.7 21.1 0 26.8l-89.9 47.9c-7.9 4.2-17.5-1.5-17.5-10.5c0-2.8 1-5.5 2.8-7.6l36-43.2-36-43.2c-1.8-2.1-2.8-4.8-2.8-7.6c0-9 9.6-14.7 17.5-10.5zM396 157.1c0 2.8-1 5.5-2.8 7.6l-36 43.2 36 43.2c1.8 2.1 2.8 4.8 2.8 7.6c0 9-9.6 14.7-17.5 10.5l-89.9-47.9c-10.7-5.7-10.7-21.1 0-26.8l89.9-47.9c7.9-4.2 17.5 1.5 17.5 10.5z" />
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
                            d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM164.7 328.7c22-22 53.9-40.7 91.3-40.7s69.3 18.7 91.3 40.7c11.1 11.1 20.1 23.4 26.4 35.4c6.2 11.7 10.3 24.4 10.3 35.9c0 5.2-2.6 10.2-6.9 13.2s-9.8 3.7-14.7 1.8l-20.5-7.7c-26.9-10.1-55.5-15.3-84.3-15.3h-3.2c-28.8 0-57.3 5.2-84.3 15.3L149.6 415c-4.9 1.8-10.4 1.2-14.7-1.8s-6.9-7.9-6.9-13.2c0-11.6 4.2-24.2 10.3-35.9c6.3-12 15.3-24.3 26.4-35.4zm-31.2-182l89.9 47.9c10.7 5.7 10.7 21.1 0 26.8l-89.9 47.9c-7.9 4.2-17.5-1.5-17.5-10.5c0-2.8 1-5.5 2.8-7.6l36-43.2-36-43.2c-1.8-2.1-2.8-4.8-2.8-7.6c0-9 9.6-14.7 17.5-10.5zM396 157.1c0 2.8-1 5.5-2.8 7.6l-36 43.2 36 43.2c1.8 2.1 2.8 4.8 2.8 7.6c0 9-9.6 14.7-17.5 10.5l-89.9-47.9c-10.7-5.7-10.7-21.1 0-26.8l89.9-47.9c7.9-4.2 17.5 1.5 17.5 10.5z" />
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
                labels.push(value.kode_cpl + ' Target ' + value.total_bobot + '%');
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
