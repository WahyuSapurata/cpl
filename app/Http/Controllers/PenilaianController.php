<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenilaianRequest;
use App\Http\Requests\UpdatePenilaianRequest;
use App\Models\Cpmk;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
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
        $module = 'Penilaian';

        $matkul_user = MataKuliah::where('uuid_dosen', auth()->user()->uuid)->get();
        $cpmk = Cpmk::where('uuid_matkul', $request->uuid_matkul)->get();

        $subCpmks = SubCpmk::where('uuid_matkul', $request->uuid_matkul)
            ->where('uuid_cpmk', $request->uuid_cpmk)
            ->get();

        $teknikPenilaian = $subCpmks->map(function ($subCpmk) {
            return [
                'uuid' => $subCpmk->uuid,
                'teknik_penilaian' => $subCpmk->teknik_penilaian
            ];
        })->unique('teknik_penilaian')->values();

        $kelas = Kelas::where('uuid_matkul', $request->uuid_matkul)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->get();
        $mahasiswa_list = $kelas->map(function ($item) {
            $mahasiswa = Mahasiswa::where('uuid', $item->uuid_mahasiswa)->first();

            $item->uuid_mahasiswa = $mahasiswa->uuid;
            $item->mahasiswa = $mahasiswa->nama;

            return $item;
        });

        return view('dosen.penilaian.nilai', compact('module', 'matkul_user', 'cpmk', 'teknikPenilaian', 'mahasiswa_list'));
    }

    public function update(Request $request)
    {
        $uuid_mahasiswa = $request->uuid_mahasiswa;
        $uuid_sub_cpmks = $request->uuid_sub_cpmks;
        $data_nilai = $request->nilai;
        $tahun_ajaran = $request->tahun_ajaran;

        // Asumsi bahwa jumlah elemen di $uuid_mahasiswa sama dengan $uuid_sub_cpmks dan $data_nilai
        $jumlah_mahasiswa = count($uuid_mahasiswa);

        for ($i = 0; $i < $jumlah_mahasiswa; $i++) {
            for ($j = 0; $j < count($uuid_sub_cpmks) / $jumlah_mahasiswa; $j++) {
                $index = $i * (count($uuid_sub_cpmks) / $jumlah_mahasiswa) + $j;

                // Periksa apakah penilaian sudah ada untuk kombinasi UUID mahasiswa dan UUID sub CPMK
                $data = Penilaian::where('uuid_mahasiswa', $uuid_mahasiswa[$i])
                    ->where('uuid_sub_cpmks', $uuid_sub_cpmks[$index])
                    ->where('tahun_ajaran', $tahun_ajaran)
                    ->first();

                if (!$data) {
                    $data = new Penilaian();
                    $data->uuid_mahasiswa = $uuid_mahasiswa[$i];
                    $data->uuid_sub_cpmks = $uuid_sub_cpmks[$index];
                    $data->tahun_ajaran = $tahun_ajaran;
                }

                $data->nilai = $data_nilai[$index];
                $data->save();
            }
        }

        return redirect()->back()->with('success', 'Data penilaian berhasil diperbarui.');
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
