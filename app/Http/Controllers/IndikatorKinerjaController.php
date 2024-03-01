<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIndikatorKinerjaRequest;
use App\Http\Requests\UpdateIndikatorKinerjaRequest;
use App\Models\IndikatorKinerja;

class IndikatorKinerjaController extends BaseController
{
    public function index()
    {
        $module = 'Indikator Kinerja';
        return view('operator.indikatorkinerja.index', compact('module'));
    }

    public function get()
    {
        // Mengambil semua data pengguna
        $dataFull = IndikatorKinerja::all();

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($dataFull, 'Get data success');
    }

    public function store(StoreIndikatorKinerjaRequest $storeIndikatorKinerjaRequest)
    {
        $data = array();
        try {
            $data = new IndikatorKinerja();
            $data->kode_ik = $storeIndikatorKinerjaRequest->kode_ik;
            $data->kemampuan = $storeIndikatorKinerjaRequest->kemampuan;
            $data->deskripsi = $storeIndikatorKinerjaRequest->deskripsi;
            $data->bobot = $storeIndikatorKinerjaRequest->bobot;
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
            $data = IndikatorKinerja::where('uuid', $params)->first();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Show data success');
    }

    public function update(StoreIndikatorKinerjaRequest $storeIndikatorKinerjaRequest, $params)
    {
        try {
            $data = IndikatorKinerja::where('uuid', $params)->first();
            $data->kode_ik = $storeIndikatorKinerjaRequest->kode_ik;
            $data->kemampuan = $storeIndikatorKinerjaRequest->kemampuan;
            $data->deskripsi = $storeIndikatorKinerjaRequest->deskripsi;
            $data->bobot = $storeIndikatorKinerjaRequest->bobot;
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
            $data = IndikatorKinerja::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
