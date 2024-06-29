<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCpmkRequest;
use App\Http\Requests\UpdateCpmkRequest;
use App\Models\CplProdi;
use App\Models\Cpmk;
use App\Models\IndikatorKinerja;
use App\Models\MataKuliah;
use App\Models\User;

class CpmkController extends BaseController
{
    public function index()
    {
        $module = 'CPMK';
        return view('dosen.cpmk.index', compact('module'));
    }

    public function operator()
    {
        $module = 'CPMK';
        return view('operator.cpmk.index', compact('module'));
    }

    public function get()
    {
        // Mengambil semua data pengguna
        $dataFull = Cpmk::all();

        $combinedData = $dataFull->map(function ($item) {
            $dataUser = User::where('uuid', $item->uuid_user)->first();
            $dataMatkul = MataKuliah::where('uuid', $item->uuid_matkul)->first();
            $dataCpl = CplProdi::where('uuid', $item->uuid_cpl)->first();

            $item->role = $dataUser->role ?? null;
            $item->cpl = $dataCpl->kode_cpl ?? null;
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
                return $item->uuid_user === $userUuid || $item->role === 'operator' || $item->role === 'admin';
            })->values();
        }

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($dataCombine, 'Get data success');
    }

    public function get_cpmk_by_uuid_matkul($params)
    {
        // Mengambil semua data pengguna
        $dataFull = Cpmk::where('uuid_matkul', $params)->get();

        $combinedData = $dataFull->map(function ($item) {
            $dataUser = User::where('uuid', $item->uuid_user)->first();
            $dataMatkul = MataKuliah::where('uuid', $item->uuid_matkul)->first();
            $dataCpl = CplProdi::where('uuid', $item->uuid_cpl)->first();

            $item->role = $dataUser->role ?? null;
            $item->cpl = $dataCpl->kode_cpl ?? null;
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
                return $item->uuid_user === $userUuid || $item->role === 'operator' || $item->role === 'admin';
            })->values();
        }

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($dataCombine, 'Get data success');
    }

    public function get_cpmk_by_matkul($params)
    {
        $data = Cpmk::where('uuid_matkul', $params)->get();
        return $this->sendResponse($data, 'Get data success');
    }

    public function store(StoreCpmkRequest $storeCpmkRequest)
    {
        $data = array();
        try {
            $data = new Cpmk();
            $data->uuid_user = auth()->user()->uuid;
            $data->uuid_matkul = $storeCpmkRequest->uuid_matkul;
            $data->uuid_cpl = $storeCpmkRequest->uuid_cpl;
            $data->kode_cpmk = $storeCpmkRequest->kode_cpmk;
            $data->deskripsi = $storeCpmkRequest->deskripsi;
            $data->bobot = $storeCpmkRequest->bobot;
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
            $data = Cpmk::where('uuid', $params)->first();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Show data success');
    }

    public function update(StoreCpmkRequest $storeCpmkRequest, $params)
    {
        try {
            $data = Cpmk::where('uuid', $params)->first();
            $data->uuid_user = auth()->user()->uuid;
            $data->uuid_matkul = $storeCpmkRequest->uuid_matkul;
            $data->uuid_cpl = $storeCpmkRequest->uuid_cpl;
            $data->kode_cpmk = $storeCpmkRequest->kode_cpmk;
            $data->deskripsi = $storeCpmkRequest->deskripsi;
            $data->bobot = $storeCpmkRequest->bobot;
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
            $data = Cpmk::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
