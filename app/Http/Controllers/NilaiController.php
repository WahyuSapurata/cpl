<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNilaiRequest;
use App\Http\Requests\UpdateNilaiRequest;
use App\Models\CplDenganIk;
use App\Models\CplProdi;
use App\Models\IkDenganCpmk;
use App\Models\IndikatorKinerja;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\SubCpmk;

class NilaiController extends BaseController
{
    public function index()
    {
        $module = 'Nilai';
        return view('dosen.nilai.index', compact('module'));
    }

    public function get($params)
    {
        // Mengambil semua data pengguna
        $dataFull = Nilai::all();

        $combinedData = $dataFull->map(function ($item) {
            $dataCpl = CplProdi::where('uuid', $item->uuid_cpl)->first();
            $dataIk = IndikatorKinerja::where('uuid', $item->uuid_ik)->first();
            $dataCpmk = IkDenganCpmk::where('uuid', $item->uuid_cpmk)->first();

            $dataSubCpmk = SubCpmk::where('uuid_cpmk', $dataCpmk->uuid)->get();
            $nilai = 0;
            $bobot = 0;
            foreach ($dataSubCpmk as $itemsub) {
                $nilai += $itemsub->nilai_sub;
                $bobot += $itemsub->bobot / 100;
            }

            $item->kode_cpl = $dataCpl->kode_cpl;
            $item->kode_ik = $dataIk->kode_ik;
            $item->kode_cpmk = $dataCpmk->kode_cpmk;
            $item->bobot = $dataCpmk->bobot;
            $item->nilai = $nilai * $bobot;
            return $item;
        });

        if (auth()->user()->role === 'operator' || auth()->user()->role === 'kajur' || auth()->user()->role === 'lpm' || auth()->user()->role === 'admin') {
            $dataCombine = $combinedData;
        } else {
            $dataCombine = $combinedData->where('uuid_user', auth()->user()->uuid)->where('uuid_mk', $params)->all();
        }

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($dataCombine, 'Get data success');
    }


    public function store(StoreNilaiRequest $storeNilaiRequest)
    {
        $data = array();
        try {
            $data = new Nilai();
            $data->uuid_user = auth()->user()->uuid;
            $data->uuid_mk = $storeNilaiRequest->uuid_mk;
            $data->uuid_cpl = $storeNilaiRequest->uuid_cpl;
            $data->uuid_ik = $storeNilaiRequest->uuid_ik;
            $data->uuid_cpmk = $storeNilaiRequest->uuid_cpmk;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Added data success');
    }

    public function show($params)
    {
        $data = array();
        try {
            $data = Nilai::where('uuid', $params)->first();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Show data success');
    }

    public function update(StoreNilaiRequest $storeNilaiRequest, $params)
    {
        try {
            $data = Nilai::where('uuid', $params)->first();
            $data->uuid_user = auth()->user()->uuid;
            $data->uuid_mk = $storeNilaiRequest->uuid_mk;
            $data->uuid_cpl = $storeNilaiRequest->uuid_cpl;
            $data->uuid_ik = $storeNilaiRequest->uuid_ik;
            $data->uuid_cpmk = $storeNilaiRequest->uuid_cpmk;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }

        return $this->sendResponse($data, 'Update data success');
    }

    public function delete($params)
    {
        $data = array();
        try {
            $data = Nilai::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
