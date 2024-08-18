@extends('layouts.layout')
@section('button')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
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
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        {{-- <!--begin::Actions-->
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <div id="alert-bobot"></div>
    </div>
    <!--end::Actions--> --}}
    </div>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <div class="row">

                <form action="{{ route('dosen.update-penilaian') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="container">
                                <div class="py-5 table-responsive">
                                    <table id="kt_table_data"
                                        class="table table-striped table-rounded border border-gray-300 table-row-bordered table-row-gray-300">
                                        <thead class="text-center">
                                            <tr class="fw-bolder fs-6 text-gray-800">
                                                <th>No</th>
                                                <th>Nama Mahasiswa</th>
                                                @foreach ($teknikPenilaian as $indikator)
                                                    <th>{{ $indikator['teknik_penilaian'] }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // Mengambil semua nilai penilaian yang diperlukan untuk semua mahasiswa dan teknik penilaian yang ada dalam satu query.
                                                $penilaian = \App\Models\Penilaian::whereIn(
                                                    'uuid_mahasiswa',
                                                    $mahasiswa_list->pluck('uuid_mahasiswa')->all(),
                                                )
                                                    ->whereIn('uuid_sub_cpmks', $teknikPenilaian->pluck('uuid')->all())
                                                    ->where('tahun_ajaran', request('tahun_ajaran'))
                                                    ->get();

                                                // Mengelompokkan nilai berdasarkan uuid_mahasiswa dan uuid_sub_cpmks untuk memudahkan pencarian nanti
                                                $nilaiGrouped = $penilaian->groupBy([
                                                    'uuid_mahasiswa',
                                                    'uuid_sub_cpmks',
                                                ]);
                                            @endphp

                                            @if ($mahasiswa_list->isEmpty())
                                                <tr>
                                                    <td colspan="{{ count($teknikPenilaian) + 2 }}" class="text-center">
                                                        Data masih kosong</td>
                                                </tr>
                                            @else
                                                @foreach ($mahasiswa_list as $li_mhs)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <input type="hidden" name="uuid_mahasiswa[]"
                                                            value="{{ $li_mhs->uuid_mahasiswa }}">
                                                        <td>{{ $li_mhs->mahasiswa }}</td>
                                                        @foreach ($teknikPenilaian as $nilai)
                                                            <td>
                                                                <input type="hidden" name="uuid_sub_cpmks[]"
                                                                    value="{{ $nilai['uuid'] }}">
                                                                <input type="hidden" name="tahun_ajaran"
                                                                    value="{{ request('tahun_ajaran') }}">
                                                                @php
                                                                    // Cek apakah key 'uuid_mahasiswa' ada di dalam $nilaiGrouped
                                                                    $nilaiPenilaian = isset(
                                                                        $nilaiGrouped[$li_mhs->uuid_mahasiswa][
                                                                            $nilai['uuid']
                                                                        ],
                                                                    )
                                                                        ? $nilaiGrouped[$li_mhs->uuid_mahasiswa][
                                                                            $nilai['uuid']
                                                                        ]->first()
                                                                        : null;
                                                                @endphp
                                                                <input type="number" name="nilai[]" max="100"
                                                                    min="0"
                                                                    value="{{ $nilaiPenilaian ? $nilaiPenilaian->nilai : '' }}"
                                                                    class="form-control" placeholder="Isi Nilai"
                                                                    oninput="this.value = Math.min(Math.max(this.value, 0), 100)">
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success mb-5 ">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection
@section('script')
    <script>
        $(document).on('click', '#button-back', function() {
            const previousUrl = document.referrer; // Ambil URL sebelumnya dari document.referrer

            // Navigasi ke URL sebelumnya
            window.location.href = previousUrl;

            // Reload halaman jika sudah kembali ke URL sebelumnya
            if (window.location.href === previousUrl) {
                window.location.reload();
            }
        });
    </script>
@endsection
