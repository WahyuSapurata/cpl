<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenilaianRequest;
use App\Http\Requests\UpdatePenilaianRequest;
use App\Models\Mahasiswa;
use App\Models\Penilaian;
use App\Models\SubCpmk;
use Illuminate\Http\Request;

class PenilaianController extends BaseController
{
    public function index()
    {
        $module = 'Penilaian';
        return view('dosen.penilaian.index', compact('module'));
    }

    public function get(Request $request)
    {
        // Mendapatkan tahun ajaran dari permintaan
        $tahun_ajaran = $request->tahun_ajaran;

        // Mengambil data SubCpmk berdasarkan uuid_matkul dan uuid_cpmk dari request
        $subCpmks = SubCpmk::where('uuid_matkul', $request->matkul)
            ->where('uuid_cpmk', $request->cpmk)
            ->get();

        // Mendapatkan teknik_penilaian dan uuid_sub_cpmk
        $teknikPenilaian = $subCpmks->map(function ($subCpmk) {
            return [
                'uuid' => $subCpmk->uuid,
                'teknik_penilaian' => $subCpmk->teknik_penilaian
            ];
        })->unique('teknik_penilaian')->values();

        // Mengambil uuid_sub_cpmks untuk query Penilaian
        $subCpmkUuids = $subCpmks->pluck('uuid');

        // Mengambil data penilaian yang sesuai dengan uuid_sub_cpmks dan tahun ajaran
        $penilaian = Penilaian::whereIn('uuid_sub_cpmks', $subCpmkUuids)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get()
            ->groupBy('uuid_sub_cpmks');

        // Memproses setiap item dalam koleksi data SubCpmk
        $dataCombined = $subCpmks->map(function ($subCpmk) use ($penilaian) {
            $uuid = $subCpmk->uuid;

            // Mengambil data penilaian yang sesuai dengan uuid_sub_cpmks
            $penilaianForSubCpmk = $penilaian->get($uuid, collect());

            // Membuat array dengan teknik_penilaian, nama_mahasiswa, dan nilai
            $results = $penilaianForSubCpmk->map(function ($item) use ($subCpmk) {
                $mahasiswa = Mahasiswa::where('uuid', $item->uuid_mahasiswa)->first();
                // Periksa apakah nilai null sebelum menambahkannya ke array
                if ($item->nilai !== null) {
                    return [
                        'uuid' => $item->uuid,
                        'nama_mahasiswa' => $mahasiswa ? $mahasiswa->nama : null,
                        $subCpmk->teknik_penilaian => $item->nilai,
                    ];
                }
            })->filter(); // Filter hasil untuk menghapus nilai null

            return $results->isEmpty() ? null : $results;
        })->filter(); // Filter hasil untuk menghapus nilai null

        // Mengembalikan response berdasarkan data yang sudah disaring
        return $this->sendResponse([
            'data' => $dataCombined->flatten(1), // Menggabungkan hasil ke dalam satu larik
            'teknik_penilaian' => $teknikPenilaian,
        ], 'Get data success');
    }

    public function store(StorePenilaianRequest $storePenilaianRequest)
    {
        $uuid_sub_cpmks = $storePenilaianRequest->uuid_sub_cpmks;
        $data_nilai = $storePenilaianRequest->nilai;
        try {
            foreach ($uuid_sub_cpmks as $index => $uuid) {
                $data = new Penilaian();
                $data->uuid_mahasiswa = $storePenilaianRequest->uuid_mahasiswa;
                $data->uuid_sub_cpmks = $uuid;
                $data->nilai = $data_nilai[$index];
                $data->tahun_ajaran = $storePenilaianRequest->tahun_ajaran;
                $data->save();
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse('success', 'Added data success');
    }

    public function show(Request $request)
    {
        try {
            // Temukan Penilaian berdasarkan uuid yang diberikan dalam request
            $penilaian = Penilaian::where('uuid', $request->uuid)->first();

            // Jika Penilaian tidak ditemukan, kembalikan respons error
            if (!$penilaian) {
                return $this->sendError('Penilaian not found', 'Penilaian with the specified UUID does not exist', 404);
            }

            // Temukan Mahasiswa berdasarkan uuid yang terkait dengan Penilaian
            $mahasiswa = Mahasiswa::where('uuid', $penilaian->uuid_mahasiswa)->first();

            // Jika Mahasiswa tidak ditemukan, kembalikan respons error
            if (!$mahasiswa) {
                return $this->sendError('Mahasiswa not found', 'Mahasiswa with the specified UUID does not exist', 404);
            }

            // Temukan data penilaian berdasarkan uuid_sub_cpmks dan uuid_mahasiswa
            $dataFull = Penilaian::whereIn('uuid_sub_cpmks', $request->uuid_sub_cpmks)
                ->where('uuid_mahasiswa', $mahasiswa->uuid)
                ->get();

            // Menggabungkan nilai berdasarkan uuid_mahasiswa
            $groupedData = $dataFull->groupBy('uuid_mahasiswa')->map(function ($group) {
                return [
                    'uuid_mahasiswa' => $group->first()->uuid_mahasiswa,
                    'nilai' => $group->pluck('nilai')->toArray(),
                ];
            })->first(); // Ambil data pertama karena hanya ingin satu data

            // Contoh respons, sesuaikan dengan kebutuhan Anda
            return $this->sendResponse($groupedData, 'Show data success');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
    }

    public function update(StorePenilaianRequest $storePenilaianRequest)
    {
        try {
            // Ambil data dari request
            $data = $storePenilaianRequest->all();

            // Temukan data penilaian berdasarkan UUID mahasiswa dan UUID sub cpmks
            $penilaian = Penilaian::where('uuid_mahasiswa', $data['uuid_mahasiswa'])
                ->whereIn('uuid_sub_cpmks', $data['uuid_sub_cpmks'])
                ->get();

            // Perbarui nilai pada data penilaian
            foreach ($penilaian as $key => $value) {
                $value->nilai = $data['nilai'][$key];
                $value->save();
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }

        return $this->sendResponse($data, 'Update data success');
    }

    public function delete($params)
    {
        $uuid = explode(',', $params);
        try {
            Penilaian::whereIn('uuid', $uuid)->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse(null, 'Delete data success');
    }
}
