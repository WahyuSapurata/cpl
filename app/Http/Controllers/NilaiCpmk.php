<?php

namespace App\Http\Controllers;

use App\Models\Cpmk;
use App\Models\Mahasiswa;
use App\Models\Penilaian;
use App\Models\SubCpmk;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NilaiCpmk extends BaseController
{
    public function index()
    {
        $module = 'Nilai CPMK';
        return view('dosen.nilaicpmk.index', compact('module'));
    }

    public function get(Request $request)
    {
        // Mendapatkan tahun ajaran dari permintaan
        $tahun_ajaran = $request->tahun_ajaran;

        // Mengambil data SubCpmk berdasarkan uuid_matkul dari request
        $subCpmks = SubCpmk::where('uuid_matkul', $request->matkul)->get();

        // Mengambil UUID CPMK dari subCpmks
        $cpmkUuids = $subCpmks->pluck('uuid_cpmk');

        // Mengambil data CPMK berdasarkan UUID yang ditemukan
        $cpmk = Cpmk::whereIn('uuid', $cpmkUuids)->get();

        // Mengambil uuid_sub_cpmks untuk query Penilaian
        $subCpmkUuids = $subCpmks->pluck('uuid');

        // Mengambil data penilaian yang sesuai dengan uuid_sub_cpmks dan tahun ajaran
        $penilaian = Penilaian::whereIn('uuid_sub_cpmks', $subCpmkUuids)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get()
            ->groupBy('uuid_mahasiswa');

        // Inisialisasi array untuk menyimpan hasil penjumlahan
        $summedData = [];

        // Iterasi melalui koleksi $penilaian yang dikelompokkan berdasarkan uuid_mahasiswa
        foreach ($penilaian as $uuidMahasiswa => $penilaianForMahasiswa) {
            $mahasiswa = Mahasiswa::where('uuid', $uuidMahasiswa)->first();
            $namaMahasiswa = $mahasiswa ? $mahasiswa->nama : null;

            $summedData[$uuidMahasiswa] = [
                'nama_mahasiswa' => $namaMahasiswa,
            ];

            // Inisialisasi total bobot dan total nilai untuk mahasiswa ini
            $totalBobot = [];
            $totalNilai = [];

            // Iterasi melalui penilaian mahasiswa untuk menghitung nilai berdasarkan CPMK per row terlebih dahulu
            foreach ($penilaianForMahasiswa as $item) {
                // Cari sub CPMK yang sesuai dengan uuid_sub_cpmks dari penilaian
                $subCpmk = $subCpmks->where('uuid', $item->uuid_sub_cpmks)->first();

                if ($subCpmk) {
                    // Cari CPMK yang sesuai dengan uuid dari sub CPMK
                    $dataCpmk = $cpmk->where('uuid', $subCpmk->uuid_cpmk)->first();
                    $kodeCpmk = $dataCpmk ? $dataCpmk->kode_cpmk : null;

                    // Jika kode CPMK ditemukan, lakukan proses penjumlahan nilai dan bobot
                    if ($kodeCpmk) {
                        // Inisialisasi nilai dan bobot jika belum ada
                        if (!isset($totalNilai[$kodeCpmk])) {
                            $totalNilai[$kodeCpmk] = 0;
                            $totalBobot[$kodeCpmk] = 0;
                        }

                        // Lakukan perhitungan nilai per row dan akumulasi total bobot
                        $nilaiPerRow = $item->nilai * $subCpmk->bobot;
                        $totalNilai[$kodeCpmk] += $nilaiPerRow;
                        $totalBobot[$kodeCpmk] += $subCpmk->bobot;
                    }
                }
            }

            // Setelah selesai menghitung nilai per row, bagi total nilai dengan total bobot
            foreach ($totalNilai as $kodeCpmk => $nilai) {
                if ($totalBobot[$kodeCpmk] > 0) {
                    $summedData[$uuidMahasiswa][$kodeCpmk] = $nilai / $totalBobot[$kodeCpmk];
                } else {
                    $summedData[$uuidMahasiswa][$kodeCpmk] = 0; // Jika tidak ada bobot, beri nilai 0
                }
            }
        }

        // Menambahkan kode_cpmk yang belum ada di penilaian dengan nilai 0
        foreach ($summedData as &$item) {
            foreach ($cpmk as $dataCpmk) {
                $kodeCpmk = $dataCpmk->kode_cpmk;
                if (!isset($item[$kodeCpmk])) {
                    $item[$kodeCpmk] = 0;
                }
            }
        }

        // Mengubah array $summedData menjadi array kembali
        $summedData = array_values($summedData);

        return $this->sendResponse([
            'data' => $summedData, // Menggabungkan hasil ke dalam satu array
            'kode_cpmk' => $cpmk->pluck('kode_cpmk')->unique()->values(),
        ], 'Get data success');
    }
}
