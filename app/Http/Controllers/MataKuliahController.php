<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMataKuliahRequest;
use App\Http\Requests\UpdateMataKuliahRequest;
use App\Models\MataKuliah;
use App\Models\User;

class MataKuliahController extends BaseController
{
    public function index()
    {
        $module = 'Mata Kuliah';
        return view('operator.matakuliah.index', compact('module'));
    }

    public function get()
    {
        // Mengambil semua data pengguna
        $dataFull = MataKuliah::all();

        $combinedData = $dataFull->map(function ($item) {
            $dataDosen = User::where('uuid', $item->uuid_dosen)->first();
            $item->nama_dosen = $dataDosen->name;
            return $item;
        });

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($combinedData, 'Get data success');
    }

    public function store(StoreMataKuliahRequest $storeMataKuliahRequest)
    {
        $data = array();
        try {
            $data = new MataKuliah();
            $data->uuid_dosen = $storeMataKuliahRequest->uuid_dosen;
            $data->kode_mk = $storeMataKuliahRequest->kode_mk;
            $data->mata_kuliah = $storeMataKuliahRequest->mata_kuliah;
            $data->sks = $storeMataKuliahRequest->sks;
            $data->kelas = $storeMataKuliahRequest->kelas;
            $data->semester = $storeMataKuliahRequest->semester;
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
            $data = MataKuliah::where('uuid', $params)->first();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Show data success');
    }

    public function update(UpdateMataKuliahRequest $updateMataKuliahRequest, $params)
    {
        try {
            $data = MataKuliah::where('uuid', $params)->first();
            $data->uuid_dosen = $updateMataKuliahRequest->uuid_dosen;
            $data->kode_mk = $updateMataKuliahRequest->kode_mk;
            $data->mata_kuliah = $updateMataKuliahRequest->mata_kuliah;
            $data->sks = $updateMataKuliahRequest->sks;
            $data->kelas = $updateMataKuliahRequest->kelas;
            $data->semester = $updateMataKuliahRequest->semester;
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
            $data = MataKuliah::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
