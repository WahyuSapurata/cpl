<?php

namespace App\Http\Controllers;

use App\Models\CplDenganIk;
use App\Models\CplProdi;
use App\Models\Cpmk;
use App\Models\IkDenganCpmk;
use App\Models\IndikatorKinerja;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\Penilaian;
use App\Models\SubCpmk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class NilaiCpl extends BaseController
{
    public function index(Request $request)
    {
        $module = 'Nilai CPL';
        return view('dosen.nilaicpl.index', compact('module'));
    }

    public function operator()
    {
        $module = 'Nilai CPL';
        return view('operator.nilaicpl.index', compact('module'));
    }

    public function get(Request $request)
    {
        // Mendapatkan tahun ajaran dari permintaan
        $tahun_ajaran = $request->tahun_ajaran;

        // Mengambil data CPMK berdasarkan uuid_matkul dari request
        $cpmk = Cpmk::where('uuid_matkul', $request->matkul)->get();

        // Mengambil UUID CPL dari CPMK
        $cplUuids = $cpmk->pluck('uuid_cpl');

        // Mengambil data CPL berdasarkan UUID yang ditemukan
        $cpl = CplProdi::whereIn('uuid', $cplUuids)->get();

        // Mengambil UUID CPMK untuk query SubCpmk
        $cpmkUuids = $cpmk->pluck('uuid');

        // Mengambil data SubCpmk berdasarkan UUID CPMK yang ditemukan
        $subCpmks = SubCpmk::whereIn('uuid_cpmk', $cpmkUuids)->get();

        // Mengambil UUID SubCpmk untuk query Penilaian
        $subCpmkUuids = $subCpmks->pluck('uuid');

        // Mengambil data penilaian yang sesuai dengan UUID SubCpmk dan tahun ajaran
        $penilaian = Penilaian::whereIn('uuid_sub_cpmks', $subCpmkUuids)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get()
            ->groupBy('uuid_mahasiswa');

        // Inisialisasi array untuk menyimpan hasil penjumlahan nilai dan bobot per CPL
        $summedData = [];

        // Iterasi melalui koleksi $penilaian yang dikelompokkan berdasarkan uuid_mahasiswa
        foreach ($penilaian as $uuidMahasiswa => $penilaianForMahasiswa) {
            $mahasiswa = Mahasiswa::where('uuid', $uuidMahasiswa)->first();
            $namaMahasiswa = $mahasiswa ? $mahasiswa->nama : null;

            $summedData[$uuidMahasiswa] = [
                'nama_mahasiswa' => $namaMahasiswa,
            ];

            // Inisialisasi total bobot dan total nilai untuk setiap CPL
            $totalBobot = [];
            $totalNilai = [];

            // Iterasi melalui penilaian mahasiswa untuk menghitung nilai berdasarkan CPL
            foreach ($penilaianForMahasiswa as $item) {
                $subCpmk = $subCpmks->where('uuid', $item->uuid_sub_cpmks)->first();
                if ($subCpmk) {
                    $dataCpmk = $cpmk->where('uuid', $subCpmk->uuid_cpmk)->first();
                    $dataCpl = $cpl->where('uuid', $dataCpmk->uuid_cpl)->first();
                    $kodeCpl = $dataCpl ? $dataCpl->kode_cpl : null;

                    // Jika kode CPL ada, tambahkan nilai dan akumulasikan bobot
                    if ($kodeCpl) {
                        if (!isset($totalNilai[$kodeCpl])) {
                            $totalNilai[$kodeCpl] = 0;
                            $totalBobot[$kodeCpl] = 0;
                        }

                        // Tambahkan nilai yang dihitung per row ke total nilai untuk CPL ini
                        $nilaiPerRow = $item->nilai * $subCpmk->bobot;
                        $totalNilai[$kodeCpl] += $nilaiPerRow;

                        // Akumulasikan bobot
                        $totalBobot[$kodeCpl] += $subCpmk->bobot;
                    }
                }
            }

            // Bagi total nilai dengan total bobot untuk setiap CPL
            foreach ($totalNilai as $kodeCpl => $nilai) {
                if ($totalBobot[$kodeCpl] > 0) {
                    $summedData[$uuidMahasiswa][$kodeCpl] = $nilai / $totalBobot[$kodeCpl];
                } else {
                    $summedData[$uuidMahasiswa][$kodeCpl] = 0; // Jika tidak ada bobot, beri nilai 0
                }
            }
        }

        // Menambahkan kode_cpl yang belum ada di penilaian dengan nilai 0
        foreach ($summedData as &$item) {
            foreach ($cpl as $dataCpl) {
                $kodeCpl = $dataCpl->kode_cpl;
                if (!isset($item[$kodeCpl])) {
                    $item[$kodeCpl] = 0;
                }
            }
        }

        // Mengubah array $summedData menjadi array kembali
        $summedData = array_values($summedData);

        return $this->sendResponse([
            'data' => $summedData, // Menggabungkan hasil ke dalam satu array
            'kode_cpl' => $cpl->pluck('kode_cpl')->unique()->values(),
        ], 'Get data success');
    }

    public function extract_pdf(Request $request)
    {
        // Mendapatkan data dari query parameter
        $params = $request->query('data');
        $dataParams = json_decode($params, true);

        // Mendapatkan tahun ajaran dari permintaan
        $tahun_ajaran = $dataParams['tahun_ajaran'];

        // Mengambil data CPMK berdasarkan uuid_matkul dari dataParams
        $cpmk = Cpmk::where('uuid_matkul', $dataParams['matkul'])->get();

        // Mengambil UUID CPL dari CPMK
        $cplUuids = $cpmk->pluck('uuid_cpl');

        // Mengambil data CPL berdasarkan UUID yang ditemukan
        $cpl = CplProdi::whereIn('uuid', $cplUuids)->get();

        // Mengambil UUID CPMK untuk query SubCpmk
        $cpmkUuids = $cpmk->pluck('uuid');

        // Mengambil data SubCpmk berdasarkan UUID CPMK yang ditemukan
        $subCpmks = SubCpmk::whereIn('uuid_cpmk', $cpmkUuids)->get();

        // Mengambil UUID SubCpmk untuk query Penilaian
        $subCpmkUuids = $subCpmks->pluck('uuid');

        // Mengambil data penilaian yang sesuai dengan UUID SubCpmk dan tahun ajaran
        $penilaian = Penilaian::whereIn('uuid_sub_cpmks', $subCpmkUuids)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get()
            ->groupBy('uuid_mahasiswa');

        // Inisialisasi array untuk menyimpan hasil penjumlahan nilai dan bobot per CPL
        $summedData = [];

        // Iterasi melalui koleksi $penilaian yang dikelompokkan berdasarkan uuid_mahasiswa
        foreach ($penilaian as $uuidMahasiswa => $penilaianForMahasiswa) {
            $mahasiswa = Mahasiswa::where('uuid', $uuidMahasiswa)->first();
            $namaMahasiswa = $mahasiswa ? $mahasiswa->nama : null;

            $summedData[$uuidMahasiswa] = [
                'nama_mahasiswa' => $namaMahasiswa,
            ];

            // Inisialisasi total bobot dan total nilai untuk setiap CPL
            $totalBobot = [];
            $totalNilai = [];

            // Iterasi melalui penilaian mahasiswa untuk menghitung nilai berdasarkan CPL
            foreach ($penilaianForMahasiswa as $item) {
                $subCpmk = $subCpmks->where('uuid', $item->uuid_sub_cpmks)->first();
                if ($subCpmk) {
                    $dataCpmk = $cpmk->where('uuid', $subCpmk->uuid_cpmk)->first();
                    $dataCpl = $cpl->where('uuid', $dataCpmk->uuid_cpl)->first();
                    $kodeCpl = $dataCpl ? $dataCpl->kode_cpl : null;

                    // Jika kode CPL ada, tambahkan nilai dan akumulasikan bobot
                    if ($kodeCpl) {
                        if (!isset($totalNilai[$kodeCpl])) {
                            $totalNilai[$kodeCpl] = 0;
                            $totalBobot[$kodeCpl] = 0;
                        }

                        // Tambahkan nilai yang dihitung per row ke total nilai untuk CPL ini
                        $nilaiPerRow = $item->nilai * $subCpmk->bobot;
                        $totalNilai[$kodeCpl] += $nilaiPerRow;

                        // Akumulasikan bobot
                        $totalBobot[$kodeCpl] += $subCpmk->bobot;
                    }
                }
            }

            // Bagi total nilai dengan total bobot untuk setiap CPL
            foreach ($totalNilai as $kodeCpl => $nilai) {
                if ($totalBobot[$kodeCpl] > 0) {
                    $summedData[$uuidMahasiswa][$kodeCpl] = $nilai / $totalBobot[$kodeCpl];
                } else {
                    $summedData[$uuidMahasiswa][$kodeCpl] = 0; // Jika tidak ada bobot, beri nilai 0
                }
            }
        }

        // Menambahkan kode_cpl yang belum ada di penilaian dengan nilai 0
        foreach ($summedData as &$item) {
            foreach ($cpl as $dataCpl) {
                $kodeCpl = $dataCpl->kode_cpl;
                if (!isset($item[$kodeCpl])) {
                    $item[$kodeCpl] = 0;
                }
            }
        }

        // Mengubah array $summedData menjadi array kembali
        $summedData = array_values($summedData);

        // Data untuk PDF
        $data = [
            'data' => $summedData, // Menggabungkan hasil ke dalam satu array
            'kode_cpl' => $cpl->pluck('kode_cpl')->unique()->values(),
        ];

        // Load view untuk PDF dengan data yang sudah dikumpulkan
        $pdf = Pdf::loadView('operator.pdf.index', compact('data'));

        // Menampilkan PDF
        return $pdf->stream('CPL.pdf');
    }

    public function get_operator(Request $request)
    {
        // Mendapatkan tahun ajaran dari permintaan
        $tahun_ajaran = $request->tahun_ajaran;

        // Mengambil semua data CPMK
        $cpmk = Cpmk::all();

        // Mengambil UUID CPL dari CPMK
        $cplUuids = $cpmk->pluck('uuid_cpl')->unique();

        // Mengambil data CPL berdasarkan UUID yang ditemukan
        $cpl = CplProdi::whereIn('uuid', $cplUuids)->get();

        // Mengambil UUID CPMK untuk query SubCpmk
        $cpmkUuids = $cpmk->pluck('uuid');

        // Mengambil data SubCpmk berdasarkan UUID CPMK yang ditemukan
        $subCpmks = SubCpmk::whereIn('uuid_cpmk', $cpmkUuids)->get();

        // Mengambil UUID SubCpmk untuk query Penilaian
        $subCpmkUuids = $subCpmks->pluck('uuid');

        // Mengambil data penilaian yang sesuai dengan UUID SubCpmk dan tahun ajaran
        $penilaian = Penilaian::whereIn('uuid_sub_cpmks', $subCpmkUuids)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get();

        // Inisialisasi array untuk menyimpan hasil penjumlahan
        $summedData = [];

        // Iterasi melalui penilaian untuk menjumlahkan nilai berdasarkan CPL
        foreach ($penilaian as $item) {
            $subCpmk = $subCpmks->where('uuid', $item->uuid_sub_cpmks)->first();
            if ($subCpmk) {
                $dataCpmk = $cpmk->where('uuid', $subCpmk->uuid_cpmk)->first();
                $dataCpl = $cpl->where('uuid', $dataCpmk->uuid_cpl)->first();
                $kodeCpl = $dataCpl ? $dataCpl->kode_cpl : null;
                $deskripsiCpl = $dataCpl ? $dataCpl->deskripsi : null;

                // Jika kode CPL ada, tambahkan nilai ke hasil penjumlahan
                if ($kodeCpl) {
                    if (!isset($summedData[$kodeCpl])) {
                        $summedData[$kodeCpl] = [
                            'kode_cpl' => $kodeCpl,
                            'deskripsi' => $deskripsiCpl,
                            'total_nilai' => 0,
                            'total_bobot' => 0
                        ];
                    }
                    $summedData[$kodeCpl]['total_nilai'] += $item->nilai * ($subCpmk->bobot / 100);
                    $summedData[$kodeCpl]['total_bobot'] += $subCpmk->bobot / 100;
                }
            }
        }

        // Membagi total nilai dengan total bobot
        foreach ($summedData as &$data) {
            $data['nilai'] = $data['total_bobot'] > 0 ? $data['total_nilai'] / $data['total_bobot'] : 0;
            unset($data['total_nilai']);
            unset($data['total_bobot']);
        }

        // Menambahkan kode CPL yang belum ada di penilaian dengan nilai 0
        foreach ($cpl as $dataCpl) {
            $kodeCpl = $dataCpl->kode_cpl;
            if (!isset($summedData[$kodeCpl])) {
                $summedData[$kodeCpl] = [
                    'kode_cpl' => $kodeCpl,
                    'deskripsi' => $dataCpl->deskripsi,
                    'nilai' => 0
                ];
            }
        }

        // Mengubah array $summedData menjadi array kembali
        $summedData = array_values($summedData);

        return $this->sendResponse([
            'data' => $summedData, // Menggabungkan hasil ke dalam satu array
        ], 'Get data success');
    }

    public function extract_pdf_operator(Request $request)
    {
        $params = $request->query('data');
        $dataParams = json_decode($params, true);

        // Mendapatkan tahun ajaran dari permintaan
        $tahun_ajaran = $dataParams['tahun_ajaran'];

        // Mengambil semua data CPMK
        $cpmk = Cpmk::all();

        // Mengambil UUID CPL dari CPMK
        $cplUuids = $cpmk->pluck('uuid_cpl')->unique();

        // Mengambil data CPL berdasarkan UUID yang ditemukan
        $cpl = CplProdi::whereIn('uuid', $cplUuids)->get();

        // Mengambil UUID CPMK untuk query SubCpmk
        $cpmkUuids = $cpmk->pluck('uuid');

        // Mengambil data SubCpmk berdasarkan UUID CPMK yang ditemukan
        $subCpmks = SubCpmk::whereIn('uuid_cpmk', $cpmkUuids)->get();

        // Mengambil UUID SubCpmk untuk query Penilaian
        $subCpmkUuids = $subCpmks->pluck('uuid');

        // Mengambil data penilaian yang sesuai dengan UUID SubCpmk dan tahun ajaran
        $penilaian = Penilaian::whereIn('uuid_sub_cpmks', $subCpmkUuids)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get();

        // Inisialisasi array untuk menyimpan hasil penjumlahan
        $summedData = [];

        // Iterasi melalui penilaian untuk menjumlahkan nilai berdasarkan CPL
        foreach ($penilaian as $item) {
            $subCpmk = $subCpmks->where('uuid', $item->uuid_sub_cpmks)->first();
            if ($subCpmk) {
                $dataCpmk = $cpmk->where('uuid', $subCpmk->uuid_cpmk)->first();
                $dataCpl = $cpl->where('uuid', $dataCpmk->uuid_cpl)->first();
                $kodeCpl = $dataCpl ? $dataCpl->kode_cpl : null;
                $deskripsiCpl = $dataCpl ? $dataCpl->deskripsi : null;

                // Jika kode CPL ada, tambahkan nilai ke hasil penjumlahan
                if ($kodeCpl) {
                    if (!isset($summedData[$kodeCpl])) {
                        $summedData[$kodeCpl] = [
                            'kode_cpl' => $kodeCpl,
                            'deskripsi' => $deskripsiCpl,
                            'total_nilai' => 0,
                            'total_bobot' => 0
                        ];
                    }
                    $summedData[$kodeCpl]['total_nilai'] += $item->nilai * ($subCpmk->bobot / 100);
                    $summedData[$kodeCpl]['total_bobot'] += $subCpmk->bobot / 100;
                }
            }
        }

        // Membagi total nilai dengan total bobot
        foreach ($summedData as &$data) {
            $data['nilai'] = $data['total_bobot'] > 0 ? $data['total_nilai'] / $data['total_bobot'] : 0;
            unset($data['total_nilai']);
            unset($data['total_bobot']);
        }

        // Menambahkan kode CPL yang belum ada di penilaian dengan nilai 0
        foreach ($cpl as $dataCpl) {
            $kodeCpl = $dataCpl->kode_cpl;
            if (!isset($summedData[$kodeCpl])) {
                $summedData[$kodeCpl] = [
                    'kode_cpl' => $kodeCpl,
                    'deskripsi' => $dataCpl->deskripsi,
                    'nilai' => 0
                ];
            }
        }

        // Mengubah array $summedData menjadi array kembali
        $summedData = array_values($summedData);

        // Load view untuk PDF dengan data yang sudah dikumpulkan
        $pdf = Pdf::loadView('operator.pdf.export', compact('summedData'));

        // Menampilkan PDF
        return $pdf->stream('CPL.pdf');
    }
}
