<?php

namespace App\Http\Controllers;

use App\Models\CplProdi;
use App\Models\Cpmk;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Penilaian;
use App\Models\SubCpmk;
use Illuminate\Http\Request;

class PerhitunganCpl extends BaseController
{
    public function index()
    {
        $module = 'Perhitungan CPL';
        return view('operator.perhitungan.index', compact('module'));
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

        // Mengelompokkan data mahasiswa berdasarkan SubCpmk dan menghitung total mahasiswa per mata kuliah
        $mahasiswaByMatkul = $penilaian->groupBy(function ($item) use ($subCpmks) {
            $subCpmk = $subCpmks->where('uuid', $item->uuid_sub_cpmks)->first();
            return $subCpmk ? $subCpmk->uuid_matkul : null;
        })->map(function ($group) {
            return $group->unique('uuid_mahasiswa')->count();
        });

        // Inisialisasi array untuk menyimpan hasil penjumlahan berdasarkan CPL dan mata kuliah
        $summedData = [];

        // Iterasi melalui penilaian untuk menjumlahkan nilai dan bobot berdasarkan CPL dan mata kuliah
        foreach ($penilaian as $item) {
            $subCpmk = $subCpmks->where('uuid', $item->uuid_sub_cpmks)->first();
            if ($subCpmk) {
                $dataCpmk = $cpmk->where('uuid', $subCpmk->uuid_cpmk)->first();
                $dataCpl = $cpl->where('uuid', $dataCpmk->uuid_cpl)->first();
                $kodeCpl = $dataCpl ? $dataCpl->kode_cpl : null;

                $matkul = MataKuliah::where('uuid', $subCpmk->uuid_matkul)->first();

                // Jika kode CPL dan mata kuliah ada, tambahkan nilai ke hasil penjumlahan
                if ($kodeCpl && $matkul) {
                    if (!isset($summedData[$kodeCpl])) {
                        $summedData[$kodeCpl] = [
                            'kode_cpl' => $kodeCpl,
                            'mata_kuliah' => []
                        ];
                    }

                    // Ambil total mahasiswa untuk mata kuliah ini
                    $totalMahasiswaMatkul = $mahasiswaByMatkul[$subCpmk->uuid_matkul] ?? 0;

                    // Hitung nilai berdasarkan bobot dan nilai penilaian
                    $nilaiPerRow = ($item->nilai * $subCpmk->bobot);

                    // Cek jika mata kuliah sudah ada dalam CPL, tambahkan bobot, nilai, dan total mahasiswa
                    $found = false;
                    foreach ($summedData[$kodeCpl]['mata_kuliah'] as &$mk) {
                        if ($mk['matkul'] == $matkul->mata_kuliah) {
                            $mk['nilai'] += $nilaiPerRow / $dataCpmk->bobot;
                            $mk['bobot'] = $dataCpmk->bobot;
                            $mk['total_mahasiswa'] = $totalMahasiswaMatkul;
                            $found = true;
                            break;
                        }
                    }

                    // Jika belum ada, tambahkan sebagai mata kuliah baru
                    if (!$found) {
                        $summedData[$kodeCpl]['mata_kuliah'][] = [
                            'matkul' => $matkul->mata_kuliah,
                            'nilai' => $nilaiPerRow / $dataCpmk->bobot,
                            'bobot' => $dataCpmk->bobot,
                            'total_mahasiswa' => $totalMahasiswaMatkul
                        ];
                    }
                }
            }
        }

        // Menambahkan kode CPL yang belum ada di penilaian dengan array mata kuliah kosong
        foreach ($cpl as $dataCpl) {
            $kodeCpl = $dataCpl->kode_cpl;
            if (!isset($summedData[$kodeCpl])) {
                $summedData[$kodeCpl] = [
                    'kode_cpl' => $kodeCpl,
                    'mata_kuliah' => []
                ];
            }
        }

        // Konversi hasil menjadi array satu dimensi
        $result = array_values($summedData);

        return $this->sendResponse($result, 'Get data success');
    }
}
