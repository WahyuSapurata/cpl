<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIkDenganCpmkRequest;
use App\Http\Requests\UpdateIkDenganCpmkRequest;
use App\Models\IkDenganCpmk;
use App\Models\IndikatorKinerja;
use App\Models\MataKuliah;
use App\Models\User;

class IkDenganCpmkController extends BaseController
{
    public function index()
    {
        $module = 'Semester';
        return view('operator.ikdengancpmk.index', compact('module'));
    }

    public function matkulcpmk($params)
    {
        $module = 'Mata Kuliah CPMK';
        $matkul = MataKuliah::where('semester', $params)->get();
        return view('operator.cpmk.matkul', compact('module', 'matkul'));
    }

    public function cpmk($params)
    {
        $this->get_cpmk($params);
        $data_matkul = MataKuliah::where('uuid', $params)->first();
        $module = 'Data CPMK ' . $data_matkul->mata_kuliah;
        return view('operator.cpmk.index', compact('module'));
    }

    public function get_cpmk($params)
    {
        // Mengambil semua data pengguna
        $dataFull = IkDenganCpmk::where('uuid_matkul', $params)->get();

        $combinedData = $dataFull->map(function ($item) {
            $dataUser = User::where('uuid', $item->uuid_user)->first();
            $dataMatkul = MataKuliah::where('uuid', $item->uuid_matkul)->first();

            $item->role = $dataUser->role ?? null;
            $item->matkul = $dataMatkul->mata_kuliah ?? null;
            return $item;
        });

        // Filter data berdasarkan peran pengguna
        $userRole = auth()->user()->role;
        if ($userRole === 'operator' || $userRole === 'kajur' || $userRole === 'lpm' || $userRole === 'admin') {
            $dataCombine = $combinedData;
        } else {
            $userUuid = auth()->user()->uuid;
            $dataCombine = $combinedData->filter(function ($item) use ($userUuid, $userRole) {
                return $item->uuid_user === $userUuid || $item->role === 'operator'|| $item->role === 'admin';
            })->values();
        }

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($dataCombine, 'Get data success');
    }

    public function get()
    {
        // Mengambil semua data pengguna
        $dataFull = IkDenganCpmk::all();

        $combinedData = $dataFull->map(function ($item) {
            $dataUser = User::where('uuid', $item->uuid_user)->first();

            $item->role = $dataUser->role ?? null;
            return $item;
        });

        // Filter data berdasarkan peran pengguna
        $userRole = auth()->user()->role;
        if ($userRole === 'operator' || $userRole === 'kajur' || $userRole === 'lpm' || $userRole === 'admin') {
            $dataCombine = $combinedData;
        } else {
            $userUuid = auth()->user()->uuid;
            $dataCombine = $combinedData->filter(function ($item) use ($userUuid, $userRole) {
                return $item->uuid_user === $userUuid || $item->role === 'operator' || $item->role === 'admin';
            })->values();
        }

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($dataCombine, 'Get data success');
    }

    public function store(StoreIkDenganCpmkRequest $storeIkDenganCpmkRequest)
    {
        $data = array();
        try {
            $data = new IkDenganCpmk();
            $data->uuid_user = auth()->user()->uuid;
            $data->uuid_matkul = $storeIkDenganCpmkRequest->uuid_matkul;
            $data->kode_cpmk = $storeIkDenganCpmkRequest->kode_cpmk;
            $data->deskripsi = $storeIkDenganCpmkRequest->deskripsi;
            $data->bobot = $storeIkDenganCpmkRequest->bobot;
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
            $data = IkDenganCpmk::where('uuid', $params)->first();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Show data success');
    }

    public function update(StoreIkDenganCpmkRequest $storeIkDenganCpmkRequest, $params)
    {
        try {
            $data = IkDenganCpmk::where('uuid', $params)->first();
            $data->uuid_user = auth()->user()->uuid;
            $data->uuid_matkul = $storeIkDenganCpmkRequest->uuid_matkul;
            $data->kode_cpmk = $storeIkDenganCpmkRequest->kode_cpmk;
            $data->deskripsi = $storeIkDenganCpmkRequest->deskripsi;
            $data->bobot = $storeIkDenganCpmkRequest->bobot;
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
            $data = IkDenganCpmk::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
