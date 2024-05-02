<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubCpmkRequest;
use App\Http\Requests\UpdateSubCpmkRequest;
use App\Models\IkDenganCpmk;
use App\Models\MataKuliah;
use App\Models\SubCpmk;
use App\Models\User;

class SubCpmkController extends BaseController
{
    public function index()
    {
        $module = 'Sub CPMK';
        return view('operator.subcpmk.index', compact('module'));
    }

    public function matkulcpmk($params)
    {
        $module = 'Mata Kuliah Sub CPMK';
        $matkul = MataKuliah::where('semester', $params)->get();
        return view('operator.subcpmk.matkul', compact('module', 'matkul'));
    }

    public function subcpmk($params)
    {
        $this->get_sub_cpmk($params);
        $data_matkul = MataKuliah::where('uuid', $params)->first();
        $module = 'Data Sub CPMK ' . $data_matkul->mata_kuliah;
        return view('operator.subcpmk.subcpmk', compact('module'));
    }

    public function get_sub_cpmk($params)
    {
        // Mengambil semua data pengguna
        $dataFull = SubCpmk::where('uuid_matkul', $params)->get();

        $combinedData = $dataFull->map(function ($item) {
            $dataUser = User::where('uuid', $item->uuid_user)->first();
            $dataMatkul = MataKuliah::where('uuid', $item->uuid_matkul)->first();
            $dataCpmk = IkDenganCpmk::where('uuid', $item->uuid_cpmk)->first();

            $item->role = $dataUser->role;
            $item->matkul = $dataMatkul->mata_kuliah;
            $item->kode_cpmk = $dataCpmk->kode_cpmk;
            return $item;
        });

        if (auth()->user()->role === 'operator' || auth()->user()->role === 'kajur' || auth()->user()->role === 'admin') {
            $dataCombine = $combinedData;
        } else {
            $dataCombine = $combinedData->filter(function ($item) {
                return $item->uuid_user === auth()->user()->uuid || $item->role === 'operator';
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
            $data->nilai_sub = $storeSubCpmkRequest->nilai_sub;
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
            $data->nilai_sub = $storeSubCpmkRequest->nilai_sub;
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
