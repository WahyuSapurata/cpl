<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCplProdiRequest;
use App\Http\Requests\UpdateCplProdiRequest;
use App\Models\CplProdi;

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

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($dataFull, 'Get data success');
    }

    public function store(StoreCplProdiRequest $storeCplProdiRequest)
    {
        $data = array();
        try {
            $data = new CplProdi();
            $data->kode_cpl = $storeCplProdiRequest->kode_cpl;
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
            $data->kode_cpl = $storeCplProdiRequest->kode_cpl;
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
