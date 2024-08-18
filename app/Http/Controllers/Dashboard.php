<?php

namespace App\Http\Controllers;

use App\Models\CplProdi;
use App\Models\Cpmk;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Penilaian;
use App\Models\SubCpmk;
use Illuminate\Http\Request;

class Dashboard extends BaseController
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->back();
        }
        return redirect()->route('login.login-akun');
    }

    public function dashboard($params)
    {
        $kelas = Kelas::where('uuid', $params)->first();
        $mata_kuliah = MataKuliah::where('uuid', $kelas->uuid_matkul)->first();
        $module = 'Dashboard';
        return view('dashboard.dashboard', compact('module', 'kelas', 'mata_kuliah'));
    }

    public function dashboard_admin()
    {
        $module = 'Dashboard';
        return view('dashboard.admin', compact('module'));
    }

    public function dashboard_operator()
    {
        $module = 'Dashboard';
        return view('dashboard.operator', compact('module'));
    }

    public function dashboard_kajur()
    {
        $module = 'Dashboard';
        return view('dashboard.kajur', compact('module'));
    }

    public function dashboard_lpm()
    {
        $module = 'Dashboard';
        return view('dashboard.lpm', compact('module'));
    }

    public function dashboard_dosen()
    {
        $module = 'Dashboard';
        return view('dashboard.dosen', compact('module'));
    }

    public function get_nilai_cpl_user(Request $request)
    {
        // Mendapatkan tahun ajaran dari permintaan
        $tahun_ajaran = $request->tahun_ajaran;

        // Mengambil data CPMK berdasarkan uuid_matkul dari request
        $cpmk = Cpmk::where('uuid_matkul', $request->matkul)->get();

        // Mengelompokkan CPMK berdasarkan UUID CPL
        $groupedCpmks = $cpmk->groupBy('uuid_cpl');

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
            ->get()
            ->groupBy('uuid_mahasiswa');

        // Inisialisasi array untuk menyimpan hasil per mahasiswa
        $summedData = [];
        $totalMahasiswa = $penilaian->count(); // Total mahasiswa yang memiliki penilaian

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
                $summedData[$uuidMahasiswa][$kodeCpl] = $totalBobot[$kodeCpl] > 0 ? $nilai / $totalBobot[$kodeCpl] : 0;
            }
        }

        // Menghitung total nilai CPL untuk semua mahasiswa
        $totalCplValues = [];
        foreach ($summedData as $data) {
            foreach ($data as $kodeCpl => $nilai) {
                if ($kodeCpl !== 'nama_mahasiswa') {
                    if (!isset($totalCplValues[$kodeCpl])) {
                        $totalCplValues[$kodeCpl] = 0;
                    }
                    $totalCplValues[$kodeCpl] += $nilai;
                }
            }
        }

        // Hitung rata-rata nilai CPL keseluruhan
        $averageCplValues = [];
        foreach ($totalCplValues as $kodeCpl => $totalValue) {
            $averageCplValues[$kodeCpl] = $totalMahasiswa > 0 ? $totalValue / $totalMahasiswa : 0;
        }

        // Mengembalikan response dengan rata-rata nilai CPL per mahasiswa
        return $this->sendResponse($averageCplValues, 'Get data success');
    }

    public function get_nilai_cpl_operator(Request $request)
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

                // Jika kode CPL ada, tambahkan nilai ke hasil penjumlahan
                if ($kodeCpl) {
                    if (!isset($summedData[$kodeCpl])) {
                        $summedData[$kodeCpl] = [
                            'kode_cpl' => $kodeCpl,
                            'total_bobot' => 0,
                            'total_nilai' => 0
                        ];
                    }
                    $summedData[$kodeCpl]['total_nilai'] += $item->nilai * ($subCpmk->bobot / 100);
                    $summedData[$kodeCpl]['total_bobot'] += $subCpmk->bobot;
                }
            }
        }

        // Membagi total nilai dengan total bobot
        foreach ($summedData as &$data) {
            $data['nilai'] = $data['total_bobot'] > 0 ? $data['total_nilai'] / ($data['total_bobot'] / 100) : 0;
            unset($data['total_nilai']);
        }

        // Menambahkan kode CPL yang belum ada di penilaian dengan nilai 0 dan bobot 0
        foreach ($cpl as $dataCpl) {
            $kodeCpl = $dataCpl->kode_cpl;
            if (!isset($summedData[$kodeCpl])) {
                $summedData[$kodeCpl] = [
                    'kode_cpl' => $kodeCpl,
                    'total_bobot' => 0,
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
}
