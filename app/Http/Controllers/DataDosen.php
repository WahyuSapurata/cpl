<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestDataDosen;
use App\Http\Requests\UpdateRequestDataDosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataDosen extends BaseController
{
    public function index()
    {
        $module = 'Data Dosen';
        return view('operator.datadosen.index', compact('module'));
    }

    public function get()
    {
        // Mengambil semua data pengguna
        $dataFull = User::where('role', 'dosen')->get();

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($dataFull, 'Get data success');
    }

    public function store(StoreRequestDataDosen $storeRequestDataDosen)
    {
        $data = array();
        try {
            $data = new User();
            $data->kode_dosen = $storeRequestDataDosen->kode_dosen;
            $data->name = $storeRequestDataDosen->name;
            $data->nip = $storeRequestDataDosen->nip;
            $data->username = $storeRequestDataDosen->username;
            $data->role = 'dosen';
            $data->password = Hash::make('<>password');
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
            $data = User::where('uuid', $params)->first();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Show data success');
    }

    public function update(UpdateRequestDataDosen $updateRequestDataDosen, $params)
    {
        try {
            $data = User::where('uuid', $params)->first();
            $data->kode_dosen = $updateRequestDataDosen->kode_dosen;
            $data->name = $updateRequestDataDosen->name;
            $data->nip = $updateRequestDataDosen->nip;
            $data->username = $updateRequestDataDosen->username;
            $data->role = 'dosen';
            $data->password = $updateRequestDataDosen->password ? $updateRequestDataDosen->password : $data->password;
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
            $data = User::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
