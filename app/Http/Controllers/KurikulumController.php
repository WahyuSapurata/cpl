<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKurikulumRequest;
use App\Http\Requests\UpdateKurikulumRequest;
use App\Models\Kurikulum;

class KurikulumController extends BaseController
{
    public function index()
    {
        $module = 'Kurikulum';
        return view('operator.kurikulum.index', compact('module'));
    }

    public function get()
    {
        // Mengambil semua data pengguna
        $dataFull = Kurikulum::all();

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($dataFull, 'Get data success');
    }

    public function store(StoreKurikulumRequest $storeKurikulumRequest)
    {
        $data = array();
        try {
            $data = new Kurikulum();
            $data->kode = $storeKurikulumRequest->kode;
            $data->nama = $storeKurikulumRequest->nama;
            $data->tahun_mulai = $storeKurikulumRequest->tahun_mulai;
            $data->tahun_berakhir = $storeKurikulumRequest->tahun_berakhir;
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
            $data = Kurikulum::where('uuid', $params)->first();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Show data success');
    }

    public function update(StoreKurikulumRequest $storeKurikulumRequest, $params)
    {
        try {
            $data = Kurikulum::where('uuid', $params)->first();
            $data->kode = $storeKurikulumRequest->kode;
            $data->nama = $storeKurikulumRequest->nama;
            $data->tahun_mulai = $storeKurikulumRequest->tahun_mulai;
            $data->tahun_berakhir = $storeKurikulumRequest->tahun_berakhir;
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
            $data = Kurikulum::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
