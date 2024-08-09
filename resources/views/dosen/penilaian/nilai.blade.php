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
                                    @foreach ($matkul_user as $matkul)
                                        <option value="{{ $matkul->uuid }}"
                                            {{ $matkul->uuid == request('uuid_matkul') ? 'selected' : '' }}>
                                            {{ $matkul->mata_kuliah }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger uuid_matkul_error"></small>
                            </div>
                            <div class="mb-10">
                                <label class="form-label">CPMK</label>
                                <select name="uuid_cpmk" class="form-select" data-control="select2" id="from_select_cpmk"
                                    data-placeholder="Pilih">
                                    @foreach ($cpmk as $item_cpmk)
                                        <option value="{{ $item_cpmk->uuid }}"
                                            {{ $item_cpmk->uuid == request('uuid_cpmk') ? 'selected' : '' }}>
                                            {{ $item_cpmk->kode_cpmk }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger uuid_cpmk_error"></small>
                            </div>
                            @php
                                function generateSchoolYears($startYear)
                                {
                                    $currentYear = date('Y');
                                    $years = [];

                                    for ($year = $startYear; $year <= $currentYear; $year++) {
                                        $years[] = [
                                            'text' => "$year/" . ($year + 1),
                                        ];
                                    }

                                    // Balik urutan tahun agar tahun sekarang berada di paling atas
                                    $years = array_reverse($years);

                                    return $years;
                                }

                                $data = generateSchoolYears(2000);
                            @endphp
                            <div class="mb-10">
                                <label class="form-label">Tahun Ajaran</label>
                                <select name="tahun_ajaran" class="form-select" data-control="select2"
                                    id="from_select_tahun_ajaran" data-placeholder="Pilih">
                                    @foreach ($data as $item_tahun)
                                        <option value="{{ $item_tahun['text'] }}"
                                            {{ $item_tahun['text'] == request('tahun_ajaran') ? 'selected' : '' }}>
                                            {{ $item_tahun['text'] }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger tahun_ajaran_error"></small>
                            </div>
                            <div class="d-flex my-5">
                                <button class="btn btn-primary btn-sm" id="button-cari"></i>Cari Data</button>
                            </div>
                        </form>
                    </div>
                </div>

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
