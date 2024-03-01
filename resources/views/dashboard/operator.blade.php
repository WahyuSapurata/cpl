@extends('layouts.layout')
@section('button')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <select name="mata_kuliah" class="form-select" data-control="select2" id="mata_kuliah_select"
                data-placeholder="Pilih mata kuliah">
            </select>
            <!--end::Title-->
        </div>
    </div>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
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
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection
@section('script')
    <script>
        var myChart;

        $(document).ready(async function() {
            // Menampilkan elemen loading

            try {
                // Melakukan permintaan AJAX pertama
                const res = await $.ajax({
                    url: '/operator/get-mata-kuliah',
                    method: 'GET'
                });

                if (res.success === true) {
                    // Mengosongkan dan mengisi opsi mata_kuliah_select
                    $('#mata_kuliah_select').html("");
                    let html = "<option></option>";
                    $.each(res.data, function(x, y) {
                        html += `<option value="${y.uuid}">${y.mata_kuliah}</option>`;
                    });
                    $('#mata_kuliah_select').html(html);

                    // Menanggapi perubahan pada elemen select
                    $('#mata_kuliah_select').on('change', async function() {
                        $('.loading').show();
                        $('#onData').removeClass('d-none');
                        $('#noData').addClass('d-none');
                        let selectedUuid = $(this).val();

                        try {
                            // Melakukan permintaan AJAX kedua
                            const response = await $.ajax({
                                url: '/dosen/get-nilaicpl/' + selectedUuid,
                                method: 'GET'
                            });

                            if (response.success === true) {
                                getGrafik(response.data);
                            } else {
                                console.error('Gagal mengambil data:', response.message);
                            }
                        } catch (error) {
                            console.error('Gagal melakukan permintaan AJAX kedua:', error);
                        } finally {
                            // Menyembunyikan elemen loading setelah permintaan AJAX selesai
                            $('.loading').hide();
                        }
                    });

                } else {
                    console.error('Gagal mengambil data:', res.message);
                }
            } catch (error) {
                console.error('Gagal melakukan permintaan AJAX pertama:', error);
            }
        });

        function getGrafik(data) {
            var ctx = document.getElementById('kt_chartjs');
            var primaryColor = KTUtil.getCssVariableValue('--bs-success');
            var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');

            var labels = [];
            var jumlahData = [];

            data.forEach(function(item) {
                labels.push(item.kode_cpl);
                jumlahData.push(item.nilai_cpl);
            });

            // Chart data
            const chartData = {
                labels: labels,
                datasets: [{
                    label: 'Nilai CPL',
                    backgroundColor: primaryColor,
                    borderColor: primaryColor,
                    data: jumlahData,
                }]
            };

            // Chart config
            const config = {
                type: 'bar',
                data: chartData,
                options: {
                    plugins: {
                        title: {
                            display: false
                        }
                    },
                    responsive: true,
                    defaults: {
                        global: {
                            defaultFont: fontFamily
                        }
                    }
                }
            };

            // Mendeklarasikan variabel myChart
            var myChart;

            // Update or reinitialize the ChartJS instance
            if (myChart) {
                // If the chart already exists, update its data
                myChart.data = chartData;
                myChart.update();
            } else {
                // If the chart does not exist, create a new instance
                myChart = new Chart(ctx, config);
            }
        }
    </script>
@endsection
