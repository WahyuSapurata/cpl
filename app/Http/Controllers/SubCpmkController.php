<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubCpmkRequest;
use App\Http\Requests\UpdateSubCpmkRequest;
use App\Models\Cpmk;
use App\Models\IkDenganCpmk;
use App\Models\MataKuliah;
use App\Models\SubCpmk;
use App\Models\User;

class SubCpmkController extends BaseController
{
    public function index()
    {
        $module = 'Sub CPMK';
        return view('dosen.subcpmk.index', compact('module'));
    }

    public function operator()
    {
        $module = 'Sub CPMK';
        return view('operator.subcpmk.index', compact('module'));
    }

    public function get($params)
    {
        // Mengambil semua data sub cpmk
        $dataFull = SubCpmk::where('uuid_matkul', $params)->get();

        $combinedData = $dataFull->map(function ($item) {
            $dataUser = User::where('uuid', $item->uuid_user)->first();
            $dataCpmk = Cpmk::where('uuid', $item->uuid_cpmk)->first();

            $item->role = $dataUser->role ?? null;
            $item->kode_cpmk = $dataCpmk->kode_cpmk ?? null;
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

    public function store(StoreSubCpmkRequest $storeSubCpmkRequest)
    {
        $data = array();
        try {
            $data = new SubCpmk();
            $data->uuid_user = auth()->user()->uuid;
            $data->uuid_matkul = $storeSubCpmkRequest->uuid_matkul;
            $data->uuid_cpmk = $storeSubCpmkRequest->uuid_cpmk;
            $data->nama_sub = $storeSubCpmkRequest->nama_sub;
            $data->deskripsi = $storeSubCpmkRequest->deskripsi;
            $data->teknik_penilaian = $storeSubCpmkRequest->teknik_penilaian;
            $data->bobot = $storeSubCpmkRequest->bobot;
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
            $data = SubCpmk::where('uuid', $params)->first();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Show data success');
    }

    public function update(StoreSubCpmkRequest $storeSubCpmkRequest, $params)
    {
        try {
            $data = SubCpmk::where('uuid', $params)->first();
            $data->uuid_user = auth()->user()->uuid;
            $data->uuid_matkul = $storeSubCpmkRequest->uuid_matkul;
            $data->uuid_cpmk = $storeSubCpmkRequest->uuid_cpmk;
            $data->nama_sub = $storeSubCpmkRequest->nama_sub;
            $data->deskripsi = $storeSubCpmkRequest->deskripsi;
            $data->teknik_penilaian = $storeSubCpmkRequest->teknik_penilaian;
            $data->bobot = $storeSubCpmkRequest->bobot;
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
            $data = SubCpmk::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
