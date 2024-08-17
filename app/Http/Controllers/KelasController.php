<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class KelasController extends BaseController
{
    public function index()
    {
        $module = 'Kelas';
        return view('operator.kelas.index', compact('module'));
    }

    public function get(Request $request)
    {
        // Mengambil semua data pengguna
        $dataFull = Kelas::where('uuid_matkul', $request->matkul)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->where('kelas', $request->kelas)
            ->get();
        $dataFull->map(function ($item) {
            $mahasiswa = Mahasiswa::where('uuid', $item->uuid_mahasiswa)->first();
            $matkul = MataKuliah::where('uuid', $item->uuid_matkul)->first();

            $item->mahasiswa = $mahasiswa->nama;
            $item->matkul = $matkul->mata_kuliah;

            return $item;
        });

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse($dataFull, 'Get data success');
    }

    public function get_kelas(Request $request)
    {
        // Mengambil semua data kelas berdasarkan tahun ajaran
        $dataFull = Kelas::where('tahun_ajaran', $request->tahun_ajaran)
            ->get();

        // Maping data dengan informasi tambahan dari tabel MataKuliah
        $dataFull->map(function ($item) {
            $matkul = MataKuliah::where('uuid', $item->uuid_matkul)->first();

            $item->matkul = $matkul->mata_kuliah;
            $item->uuid_user = $matkul->uuid_dosen;

            return $item;
        });

        // Filter berdasarkan UUID pengguna yang sedang login
        $dataFiltered = $dataFull->where('uuid_user', auth()->user()->uuid);

        // Hilangkan duplikasi berdasarkan uuid_matkul
        $dataUnique = $dataFiltered->unique('uuid_matkul')->values();

        // Mengembalikan response berdasarkan data yang sudah disaring dan unik
        return $this->sendResponse($dataUnique, 'Get data success');
    }

    public function store(StoreKelasRequest $storeKelasRequest)
    {
        $data = array();
        try {
            $data = new Kelas();
            $data->uuid_mahasiswa = $storeKelasRequest->uuid_mahasiswa;
            $data->uuid_matkul = $storeKelasRequest->uuid_matkul;
            $data->kelas = $storeKelasRequest->kelas;
            $data->tahun_ajaran = $storeKelasRequest->tahun_ajaran;
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
            $data = Kelas::where('uuid', $params)->first();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Show data success');
    }

    public function update(StoreKelasRequest $storeKelasRequest, $params)
    {
        try {
            $data = Kelas::where('uuid', $params)->first();
            $data->uuid_mahasiswa = $storeKelasRequest->uuid_mahasiswa;
            $data->uuid_matkul = $storeKelasRequest->uuid_matkul;
            $data->kelas = $storeKelasRequest->kelas;
            $data->tahun_ajaran = $storeKelasRequest->tahun_ajaran;
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
            $data = Kelas::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
