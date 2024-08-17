@extends('layouts.layout')
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
