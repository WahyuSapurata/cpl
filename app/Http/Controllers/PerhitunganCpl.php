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

        // Inisialisasi array untuk menyimpan hasil penjumlahan berdasarkan CPL dan mata kuliah
        $summedData = [];

        // Iterasi melalui CPMK untuk menjumlahkan bobot berdasarkan CPL dan mata kuliah
        foreach ($cpmk as $dataCpmk) {
            $dataCpl = $cpl->where('uuid', $dataCpmk->uuid_cpl)->first();
            $kodeCpl = $dataCpl ? $dataCpl->kode_cpl : null;

            $matkul = MataKuliah::where('uuid', $dataCpmk->uuid_matkul)->first();

            // Jika kode CPL dan mata kuliah ada, tambahkan bobot ke hasil penjumlahan
            if ($kodeCpl && $matkul) {
                // Inisialisasi CPL jika belum ada
                if (!isset($summedData[$kodeCpl])) {
                    $summedData[$kodeCpl] = [
                        'kode_cpl' => $kodeCpl,
                        'mata_kuliah' => []
                    ];
                }

                // Inisialisasi mata kuliah dalam CPL jika belum ada
                if (!isset($summedData[$kodeCpl]['mata_kuliah'][$matkul->mata_kuliah])) {
                    $summedData[$kodeCpl]['mata_kuliah'][$matkul->mata_kuliah] = [
                        'matkul' => $matkul->mata_kuliah,
                        'total_bobot' => 0,
                        'total_nilai' => 0,
                        'total_mahasiswa' => 0
                    ];
                }

                // Tambahkan bobot dari CPMK yang terkait dengan CPL dan mata kuliah
                $summedData[$kodeCpl]['mata_kuliah'][$matkul->mata_kuliah]['total_bobot'] += $dataCpmk->bobot;
            }
        }

        // Iterasi melalui penilaian untuk menjumlahkan nilai berdasarkan CPL dan mata kuliah
        foreach ($penilaian as $item) {
            $subCpmk = $subCpmks->where('uuid', $item->uuid_sub_cpmks)->first();
            if ($subCpmk) {
                $dataCpmk = $cpmk->where('uuid', $subCpmk->uuid_cpmk)->first();
                $dataCpl = $cpl->where('uuid', $dataCpmk->uuid_cpl)->first();
                $kodeCpl = $dataCpl ? $dataCpl->kode_cpl : null;

                $matkul = MataKuliah::where('uuid', $subCpmk->uuid_matkul)->first();

                // Jika kode CPL dan mata kuliah ada, tambahkan nilai ke hasil penjumlahan
                if ($kodeCpl && $matkul) {
                    // Hitung nilai berdasarkan bobot dan nilai penilaian
                    $nilaiPerRow = ($item->nilai * $subCpmk->bobot);

                    // Tambahkan nilai ke mata kuliah yang terkait
                    $summedData[$kodeCpl]['mata_kuliah'][$matkul->mata_kuliah]['total_nilai'] += $nilaiPerRow;

                    // Tambahkan total mahasiswa (jika relevan)
                    $summedData[$kodeCpl]['mata_kuliah'][$matkul->mata_kuliah]['total_mahasiswa'] = $penilaian
                        ->where('uuid_sub_cpmks', $item->uuid_sub_cpmks)
                        ->unique('uuid_mahasiswa')
                        ->count();
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
        foreach ($result as &$cplData) {
            $cplData['mata_kuliah'] = array_values($cplData['mata_kuliah']);
        }

        // Mengembalikan hasil sebagai response
        return $this->sendResponse($result, 'Get data success');
    }
}
