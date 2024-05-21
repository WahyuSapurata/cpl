<?php

namespace App\Http\Controllers;

use App\Models\CplDenganIk;
use App\Models\CplProdi;
use App\Models\IkDenganCpmk;
use App\Models\IndikatorKinerja;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\SubCpmk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class NilaiCpl extends BaseController
{
    public function index()
    {
        $module = 'Perhitungan CPL';
        return view('dosen.nilaicpl.index', compact('module'));
    }

    public function get($params)
    {
        // Mengambil semua data pengguna
        $dataFull = Nilai::all();

        if (auth()->user()->role === 'operator' || auth()->user()->role === 'kajur' || auth()->user()->role === 'lpm' || auth()->user()->role === 'admin') {
            $dataCombine = $dataFull->where('uuid_mk', $params)->values();
        } else {
            $dataCombine = $dataFull->where('uuid_user', auth()->user()->uuid)->where('uuid_mk', $params)->values();
        }

        // Mengambil semua data CPL yang sesuai dengan UUID yang ada dalam data nilai
        $cplIds = $dataCombine->pluck('uuid_cpl')->unique(); // Ambil UUID CPL yang unik dari data nilai
        $cpl = CplProdi::whereIn('uuid', $cplIds)->get(); // Ambil data CPL yang sesuai dengan UUID yang ada dalam data nilai

        $combanedCpl = $cpl->map(function ($item) use ($dataCombine) {
            $combinedData = $dataCombine->map(function ($itemCpl) {
                $dataIk = IndikatorKinerja::where('uuid', $itemCpl->uuid_ik)->first();
                $dataCpmk = IkDenganCpmk::where('uuid', $itemCpl->uuid_cpmk)->first();
                $dataSubCpmk = SubCpmk::where('uuid_cpmk', $dataCpmk->uuid)->get();
                $nilai = 0;
                $bobot = 0;
                foreach ($dataSubCpmk as $itemsub) {
                    $nilai += $itemsub->nilai_sub;
                    $bobot += $itemsub->bobot / 100;
                }
                $itemCpl->bobot_ik = $dataIk->bobot;
                $itemCpl->bobot_cpmk = $dataCpmk->bobot;
                $itemCpl->nilai = $nilai * $bobot;
                return $itemCpl;
            });
            $combinedDatas = $combinedData->where('uuid_cpl', $item->uuid)->values();

            $nilaiIk = 0;
            $bobotIk = 0;
            foreach ($combinedDatas as $row) {
                // $nilaiIk += $row->nilai * $row->bobot_cpmk / $row->bobot_cpmk * $row->bobot_ik;
                $nilaiIk += ($row->nilai * $row->bobot_cpmk) / $row->bobot_ik;
                $bobotIk += $row->bobot_ik;
            }

            $item->nilai_ik = $nilaiIk;
            $item->bobot_ik = $bobotIk;
            $item->nilai_cpl = $nilaiIk / $bobotIk;
            return $item;
        });

        return $this->sendResponse($combanedCpl, 'Get data success');
    }

    public function extract_pdf($params)
    {
        $mata_kuliah = MataKuliah::where('uuid', $params)->first();
        // Mengambil semua data pengguna
        $dataFull = Nilai::all();

        if (auth()->user()->role === 'operator' || auth()->user()->role === 'kajur' || auth()->user()->role === 'lpm' || auth()->user()->role === 'admin') {
            $dataCombine = $dataFull->where('uuid_mk', $params)->values();
        } else {
            $dataCombine = $dataFull->where('uuid_user', auth()->user()->uuid)->where('uuid_mk', $params)->values();
        }

        // Mengambil semua data CPL yang sesuai dengan UUID yang ada dalam data nilai
        $cplIds = $dataCombine->pluck('uuid_cpl')->unique(); // Ambil UUID CPL yang unik dari data nilai
        $cpl = CplProdi::whereIn('uuid', $cplIds)->get(); // Ambil data CPL yang sesuai dengan UUID yang ada dalam data nilai

        $combanedCpl = $cpl->map(function ($item) use ($dataCombine) {
            $combinedData = $dataCombine->map(function ($itemCpl) {
                $dataIk = IndikatorKinerja::where('uuid', $itemCpl->uuid_ik)->first();
                $dataCpmk = IkDenganCpmk::where('uuid', $itemCpl->uuid_cpmk)->first();
                $dataSubCpmk = SubCpmk::where('uuid_cpmk', $dataCpmk->uuid)->get();
                $nilai = 0;
                $bobot = 0;
                foreach ($dataSubCpmk as $itemsub) {
                    $nilai += $itemsub->nilai_sub;
                    $bobot += $itemsub->bobot / 100;
                }
                $itemCpl->bobot_ik = $dataIk->bobot;
                $itemCpl->bobot_cpmk = $dataCpmk->bobot;
                $itemCpl->nilai = $nilai * $bobot;
                return $itemCpl;
            });
            $combinedDatas = $combinedData->where('uuid_cpl', $item->uuid)->values();

            $nilaiIk = 0;
            $bobotIk = 0;
            foreach ($combinedDatas as $row) {
                // $nilaiIk += $row->nilai * $row->bobot_cpmk / $row->bobot_cpmk * $row->bobot_ik;
                $nilaiIk += ($row->nilai * $row->bobot_cpmk) / $row->bobot_ik;
                $bobotIk += $row->bobot_ik;
            }

            $item->nilai_ik = $nilaiIk;
            $item->bobot_ik = $bobotIk;
            $item->nilai_cpl = $nilaiIk / $bobotIk;
            return $item;
        });
        // return view('operator.pdf.index', compact('mata_kuliah', 'combanedCpl'));
        $data = ['title' => 'Welcome to Laravel PDF!'];
        $pdf = Pdf::loadView('operator.pdf.index', compact('mata_kuliah', 'combanedCpl'));

        return $pdf->stream('CPL.pdf');
    }
}
