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
        $module = 'Data Pemetaan Hubungan IK Dengan CPMK';
        return view('operator.ikdengancpmk.index', compact('module'));
    }

    public function get()
    {
        // Mengambil semua data pengguna
        $dataFull = IkDenganCpmk::all();

        $combinedData = $dataFull->map(function ($item) {
            $dataUser = User::where('uuid', $item->uuid_user)->first();

            $item->role = $dataUser->role;
            return $item;
        });

        if (auth()->user()->role === 'operator' || auth()->user()->role === 'kajur') {
            $dataCombine = $combinedData;
        } else {
            $dataCombine = $combinedData->filter(function ($item) {
                return $item->uuid_user === auth()->user()->uuid || $item->role === 'operator';
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
