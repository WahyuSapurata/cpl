<?php

namespace App\Http\Controllers;

use App\Models\CplProdi;
use App\Models\Cpmk;
use App\Models\Mahasiswa;
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
            ->get();

        // Menghitung jumlah mahasiswa unik dalam penilaian
        $jumlahMahasiswa = $penilaian->groupBy('uuid_mahasiswa')->count();

        // Inisialisasi array untuk menyimpan hasil penjumlahan
        $summedData = [];

        // Iterasi melalui CPMK yang sudah dikelompokkan berdasarkan CPL
        foreach ($groupedCpmks as $uuidCpl => $cpmks) {
            $totalWeight = 0;
            $totalValue = 0;

            foreach ($cpmks as $cpmkItem) {
                // Temukan SubCpmk yang sesuai
                $subCpmk = $subCpmks->where('uuid_cpmk', $cpmkItem->uuid)->first();

                if ($subCpmk) {
                    // Temukan nilai penilaian yang sesuai
                    $nilai = $penilaian
                        ->where('uuid_sub_cpmks', $subCpmk->uuid)
                        ->avg('nilai');

                    if ($nilai) {
                        $totalValue += $nilai * ($subCpmk->bobot / 100);
                        $totalWeight += $subCpmk->bobot;
                    }
                }
            }

            // Temukan kode CPL yang sesuai
            $kodeCpl = $cpl->where('uuid', $uuidCpl)->first()->kode_cpl;

            // Jika kode CPL ada, tambahkan nilai dan bobot ke hasil penjumlahan
            if ($kodeCpl) {
                $summedData[$kodeCpl] = [
                    'nilai' => $totalWeight > 0 ? $totalValue : 0,
                    'bobot' => $totalWeight
                ];
            }
        }
        return $this->sendResponse($summedData, 'Get data success');
    }
}
