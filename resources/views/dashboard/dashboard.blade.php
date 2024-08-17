@extends('layouts.layout')
@section('button')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <div class="fs-5 fw-bolder">Mata Kuliah : {{ $mata_kuliah->mata_kuliah }} | Tahun Ajaran :
                {{ $kelas->tahun_ajaran }}
            </div>
            <!--end::Title-->
        </div>
    </div>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">

            <div class="row">
                <div class="col-md-10">
                    <div id="onData" class="card justify-content-center align-items-center shadow-lg d-none">
                        <div id="loading" class="spinner-border loading text-danger"
                            style="width: 20px; height: 20px; position: absolute;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <canvas id="kt_chartjs" style="max-height: 400px"></canvas>
                    </div>

                    <div id="noGrafik" class="d-grid justify-content-center gap-5 d-none" style="justify-items: center">
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
                        <div class="text-muted fs-sm-2">Belum ada nilai cpl</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-grid gap-3">
                        <a href="{{ route('dosen.cpmk', ['params' => $mata_kuliah->uuid]) }}"
                            class="btn btn-primary">CPMK</a>
                        <a href="{{ route('dosen.subcpmk', ['params' => $mata_kuliah->uuid]) }}" class="btn btn-primary">Sub
                            CPMK</a>
                        <form action="{{ route('dosen.get-penilaian') }}" method="GET">
                            <input type="hidden" name="uuid_matkul" value="{{ $mata_kuliah->uuid }}">
                            <input type="hidden" name="tahun_ajaran" value="{{ $kelas->tahun_ajaran }}">
                            <button type="submit" class="btn btn-primary w-100">Penilaian</button>
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

        $(document).ready(function() {
            const data = {
                'matkul': @json($mata_kuliah->uuid),
                'tahun_ajaran': @json($kelas->tahun_ajaran)
            };

            $.ajax({
                url: `/dosen/get-nilai-cpl-user`,
                method: 'GET',
                data: data,
                beforeSend: function() {
                    $('.loading').show(); // Tampilkan elemen loading sebelum request dimulai
                },
                success: function(response) {
                    if (response.data && Object.keys(response.data).length > 0) {
                        // Jika data ada dan tidak kosong, panggil fungsi untuk menampilkan grafik
                        getGrafik(response.data);
                    } else {
                        // Jika data kosong, panggil fungsi untuk membersihkan grafik
                        clearGrafik();
                    }
                },
                error: function(error) {
                    console.error(error); // Menangani error saat request gagal
                },
                complete: function() {
                    // Sembunyikan elemen loading setelah permintaan AJAX selesai
                    $('.loading').hide();
                }
            });
        });

        function getGrafik(data) {
            $('#onData').removeClass('d-none');
            $('#noGrafik').addClass('d-none');
            var ctx = document.getElementById('kt_chartjs').getContext('2d');
            var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');

            var labels = [];
            var nilaiData = [];
            var targetData = [];

            // Mengiterasi objek data
            for (const [key, value] of Object.entries(data)) {
                labels.push(key);
                nilaiData.push(value.nilai);
                targetData.push(70); // Nilai target tetap 70 untuk setiap label
            }

            // Chart data
            const chartData = {
                labels: labels,
                datasets: [{
                        label: 'Target CPL',
                        backgroundColor: 'rgba(255, 0, 0, 0.7)', // Warna merah dengan transparansi
                        borderColor: 'rgba(255, 0, 0, 1)', // Warna merah tanpa transparansi
                        data: targetData, // Target tetap 70
                    },
                    {
                        label: 'Nilai CPL',
                        backgroundColor: 'rgba(0, 255, 0, 0.7)', // Warna hijau dengan transparansi
                        borderColor: 'rgba(0, 255, 0, 1)', // Warna hijau tanpa transparansi
                        data: nilaiData, // Nilai CPL yang diambil dari data
                    }
                ]
            };

            // Chart config
            const config = {
                type: 'bar',
                data: chartData,
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Grafik Nilai dan Target Berdasarkan CPL'
                        }
                    },
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            stacked: false
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
