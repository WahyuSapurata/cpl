<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCplProdiRequest;
use App\Http\Requests\UpdateCplProdiRequest;
use App\Models\CplProdi;
use App\Models\Kurikulum;

class CplProdiController extends BaseController
{
    public function index()
    {
        $module = 'CPL';
        return view('operator.cpl.index', compact('module'));
    }

    public function get()
    {
        // Mengambil semua data pengguna
        $dataFull = CplProdi::all();
        $dataFull->map(function ($item) {
            $data_kurikulum = Kurikulum::where('uuid', $item->uuid_kurikulum)->first();

            $item->kurikulum = $data_kurikulum->kode;

            return $item;
        });

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($dataFull, 'Get data success');
    }

    public function store(StoreCplProdiRequest $storeCplProdiRequest)
    {
        $data = array();
        try {
            $data = new CplProdi();
            $data->uuid_kurikulum = $storeCplProdiRequest->uuid_kurikulum;
            $data->kode_cpl = $storeCplProdiRequest->kode_cpl;
            $data->aspek = $storeCplProdiRequest->aspek;
            $data->deskripsi = $storeCplProdiRequest->deskripsi;
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
            $data = CplProdi::where('uuid', $params)->first();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Show data success');
    }

    public function update(StoreCplProdiRequest $storeCplProdiRequest, $params)
    {
        try {
            $data = CplProdi::where('uuid', $params)->first();
            $data->uuid_kurikulum = $storeCplProdiRequest->uuid_kurikulum;
            $data->kode_cpl = $storeCplProdiRequest->kode_cpl;
            $data->aspek = $storeCplProdiRequest->aspek;
            $data->deskripsi = $storeCplProdiRequest->deskripsi;
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
            $data = CplProdi::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
