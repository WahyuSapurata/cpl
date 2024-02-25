<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCplDenganIkRequest;
use App\Http\Requests\UpdateCplDenganIkRequest;
use App\Models\CplDenganIk;
use App\Models\CplProdi;
use App\Models\IndikatorKinerja;

class CplDenganIkController extends BaseController
{
    public function index()
    {
        $module = 'Data Pemetaan Hubungan CPL Dengan IK';
        return view('operator.cpldenganik.index', compact('module'));
    }

    public function get()
    {
        // Mengambil semua data pengguna
        $dataFull = CplDenganIk::all();

        $combinedData = $dataFull->map(function ($item) {
            $dataCpl = CplProdi::where('uuid', $item->uuid_cpl)->first();

            // Memisahkan string UUID menjadi array
            $uuidIkArray = json_decode($item->uuid_ik);

            // Menggunakan array UUID dalam whereIn()
            $dataIk = IndikatorKinerja::whereIn('uuid', $uuidIkArray)->get();

            $kodeIkArray = [];

            // Iterasi melalui setiap hasil yang cocok dari IndikatorKinerja
            foreach ($dataIk as $ik) {
                // Tambahkan kode_ik ke dalam array
                $kodeIkArray[] = $ik->kode_ik;
            }

            $item->kode_cpl = $dataCpl->kode_cpl;
            $item->kode_ik = $kodeIkArray; // Gunakan string yang berisi kode_ik yang dipisahkan koma
            return $item;
        });

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($combinedData, 'Get data success');
    }

    public function store(StoreCplDenganIkRequest $storeCplDenganIkRequest)
    {
        $data = array();
        try {
            $data = new CplDenganIk();
            $data->uuid_cpl = $storeCplDenganIkRequest->uuid_cpl;
            $data->uuid_ik = json_encode($storeCplDenganIkRequest->input('uuid_ik'));
            $data->bobot = $storeCplDenganIkRequest->bobot;
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
            $data = CplDenganIk::where('uuid', $params)->first();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Show data success');
    }

    public function update(StoreCplDenganIkRequest $storeCplDenganIkRequest, $params)
    {
        try {
            $data = CplDenganIk::where('uuid', $params)->first();
            $data->uuid_cpl = $storeCplDenganIkRequest->uuid_cpl;
            $data->uuid_ik = json_encode($storeCplDenganIkRequest->input('uuid_ik'));
            $data->bobot = $storeCplDenganIkRequest->bobot;
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
            $data = CplDenganIk::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
