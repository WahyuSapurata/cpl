<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function () {

    Route::get('/', 'Dashboard@index')->name('home.index');

    Route::group(['prefix' => 'login', 'middleware' => ['guest'], 'as' => 'login.'], function () {
        Route::get('/login-akun', 'Auth@show')->name('login-akun');
        Route::post('/login-proses', 'Auth@login_proses')->name('login-proses');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function () {
        Route::get('/dashboard-admin', 'Dashboard@dashboard_admin')->name('dashboard-admin');

        Route::get('/data-operator', 'DataUser@index')->name('data-operator');
        Route::get('/get-data-operator', 'DataUser@get')->name('get-data-operator');
        Route::get('/show-data-operator/{params}', 'DataUser@show')->name('show-data-operator');
        Route::post('/add-data-operator', 'DataUser@store')->name('add-data-operator');
        Route::post('/update-data-operator/{params}', 'DataUser@update')->name('update-data-operator');
        Route::delete('/delete-data-operator/{params}', 'DataUser@delete')->name('delete-data-operator');

        Route::get('/data-dosen', 'DataDosen@index')->name('data-dosen');
        Route::get('/get-data-dosen', 'DataDosen@get')->name('get-data-dosen');
        Route::get('/show-data-dosen/{params}', 'DataDosen@show')->name('show-data-dosen');
        Route::post('/add-data-dosen', 'DataDosen@store')->name('add-data-dosen');
        Route::post('/update-data-dosen/{params}', 'DataDosen@update')->name('update-data-dosen');
        Route::delete('/delete-data-dosen/{params}', 'DataDosen@delete')->name('delete-data-dosen');

        Route::get('/mata-kuliah', 'MataKuliahController@index')->name('mata-kuliah');
        Route::get('/get-mata-kuliah', 'MataKuliahController@get')->name('get-mata-kuliah');
        Route::get('/show-mata-kuliah/{params}', 'MataKuliahController@show')->name('show-mata-kuliah');
        Route::post('/add-mata-kuliah', 'MataKuliahController@store')->name('add-mata-kuliah');
        Route::post('/update-mata-kuliah/{params}', 'MataKuliahController@update')->name('update-mata-kuliah');
        Route::delete('/delete-mata-kuliah/{params}', 'MataKuliahController@delete')->name('delete-mata-kuliah');

        Route::get('/cpl', 'CplProdiController@index')->name('cpl');
        Route::get('/get-cpl', 'CplProdiController@get')->name('get-cpl');
        Route::get('/show-cpl/{params}', 'CplProdiController@show')->name('show-cpl');
        Route::post('/add-cpl', 'CplProdiController@store')->name('add-cpl');
        Route::post('/update-cpl/{params}', 'CplProdiController@update')->name('update-cpl');
        Route::delete('/delete-cpl/{params}', 'CplProdiController@delete')->name('delete-cpl');

        Route::get('/indikator-kinerja', 'IndikatorKinerjaController@index')->name('indikator-kinerja');
        Route::get('/get-indikator-kinerja', 'IndikatorKinerjaController@get')->name('get-indikator-kinerja');
        Route::get('/show-indikator-kinerja/{params}', 'IndikatorKinerjaController@show')->name('show-indikator-kinerja');
        Route::post('/add-indikator-kinerja', 'IndikatorKinerjaController@store')->name('add-indikator-kinerja');
        Route::post('/update-indikator-kinerja/{params}', 'IndikatorKinerjaController@update')->name('update-indikator-kinerja');
        Route::delete('/delete-indikator-kinerja/{params}', 'IndikatorKinerjaController@delete')->name('delete-indikator-kinerja');

        // Route::get('/cpldenganik', 'CplDenganIkController@index')->name('cpldenganik');
        // Route::get('/get-cpldenganik', 'CplDenganIkController@get')->name('get-cpldenganik');
        // Route::get('/show-cpldenganik/{params}', 'CplDenganIkController@show')->name('show-cpldenganik');
        // Route::post('/add-cpldenganik', 'CplDenganIkController@store')->name('add-cpldenganik');
        // Route::post('/update-cpldenganik/{params}', 'CplDenganIkController@update')->name('update-cpldenganik');
        // Route::delete('/delete-cpldenganik/{params}', 'CplDenganIkController@delete')->name('delete-cpldenganik');

        Route::get('/ikdengancpmk', 'IkDenganCpmkController@index')->name('ikdengancpmk');
        Route::get('/get-ikdengancpmk', 'IkDenganCpmkController@get')->name('get-ikdengancpmk');
        Route::get('/show-ikdengancpmk/{params}', 'IkDenganCpmkController@show')->name('show-ikdengancpmk');
        Route::post('/add-ikdengancpmk', 'IkDenganCpmkController@store')->name('add-ikdengancpmk');
        Route::post('/update-ikdengancpmk/{params}', 'IkDenganCpmkController@update')->name('update-ikdengancpmk');
        Route::delete('/delete-ikdengancpmk/{params}', 'IkDenganCpmkController@delete')->name('delete-ikdengancpmk');

        Route::get('/subcpmk', 'SubCpmkController@index')->name('subcpmk');

        Route::get('/nilaicpl', 'NilaiCpl@index')->name('nilaicpl');
        Route::get('/nilai', 'NilaiController@index')->name('nilai');
    });

    Route::group(['prefix' => 'operator', 'middleware' => ['auth'], 'as' => 'operator.'], function () {
        Route::get('/dashboard-operator', 'Dashboard@dashboard_operator')->name('dashboard-operator');

        Route::prefix('data-master')->group(function () {
            Route::get('/data-dosen', 'DataDosen@index')->name('data-dosen');
            Route::get('/get-data-dosen', 'DataDosen@get')->name('get-data-dosen');
            Route::get('/show-data-dosen/{params}', 'DataDosen@show')->name('show-data-dosen');
            Route::post('/add-data-dosen', 'DataDosen@store')->name('add-data-dosen');
            Route::post('/update-data-dosen/{params}', 'DataDosen@update')->name('update-data-dosen');
            Route::delete('/delete-data-dosen/{params}', 'DataDosen@delete')->name('delete-data-dosen');

            Route::get('/mata-kuliah', 'MataKuliahController@index')->name('mata-kuliah');
            Route::get('/get-mata-kuliah', 'MataKuliahController@get')->name('get-mata-kuliah');
            Route::get('/show-mata-kuliah/{params}', 'MataKuliahController@show')->name('show-mata-kuliah');
            Route::post('/add-mata-kuliah', 'MataKuliahController@store')->name('add-mata-kuliah');
            Route::post('/update-mata-kuliah/{params}', 'MataKuliahController@update')->name('update-mata-kuliah');
            Route::delete('/delete-mata-kuliah/{params}', 'MataKuliahController@delete')->name('delete-mata-kuliah');

            Route::get('/mahasiswa', 'MahasiswaController@index')->name('mahasiswa');
            Route::get('/get-mahasiswa', 'MahasiswaController@get')->name('get-mahasiswa');
            Route::get('/show-mahasiswa/{params}', 'MahasiswaController@show')->name('show-mahasiswa');
            Route::post('/add-mahasiswa', 'MahasiswaController@store')->name('add-mahasiswa');
            Route::post('/update-mahasiswa/{params}', 'MahasiswaController@update')->name('update-mahasiswa');
            Route::delete('/delete-mahasiswa/{params}', 'MahasiswaController@delete')->name('delete-mahasiswa');

            Route::get('/kurikulum', 'KurikulumController@index')->name('kurikulum');
            Route::get('/get-kurikulum', 'KurikulumController@get')->name('get-kurikulum');
            Route::get('/show-kurikulum/{params}', 'KurikulumController@show')->name('show-kurikulum');
            Route::post('/add-kurikulum', 'KurikulumController@store')->name('add-kurikulum');
            Route::post('/update-kurikulum/{params}', 'KurikulumController@update')->name('update-kurikulum');
            Route::delete('/delete-kurikulum/{params}', 'KurikulumController@delete')->name('delete-kurikulum');

            Route::get('/kelas', 'KelasController@index')->name('kelas');
            Route::get('/get-kelas', 'KelasController@get')->name('get-kelas');
            Route::get('/show-kelas/{params}', 'KelasController@show')->name('show-kelas');
            Route::post('/add-kelas', 'KelasController@store')->name('add-kelas');
            Route::post('/update-kelas/{params}', 'KelasController@update')->name('update-kelas');
            Route::delete('/delete-kelas/{params}', 'KelasController@delete')->name('delete-kelas');
        });

        Route::get('/cpl', 'CplProdiController@index')->name('cpl');
        Route::get('/get-cpl', 'CplProdiController@get')->name('get-cpl');
        Route::get('/show-cpl/{params}', 'CplProdiController@show')->name('show-cpl');
        Route::post('/add-cpl', 'CplProdiController@store')->name('add-cpl');
        Route::post('/update-cpl/{params}', 'CplProdiController@update')->name('update-cpl');
        Route::delete('/delete-cpl/{params}', 'CplProdiController@delete')->name('delete-cpl');

        Route::get('/cpmk', 'CpmkController@operator')->name('cpmk');
        Route::get('/subcpmk', 'SubCpmkController@operator')->name('subcpmk');

        Route::get('/nilaicpl', 'NilaiCpl@operator')->name('nilaicpl');
        Route::get('/nilai', 'NilaiController@index')->name('nilai');

        Route::get('/get-cpl-operator', 'NilaiCpl@get_operator')->name('get-cpl-operator');

        Route::get('/get-cpl-dashboard', 'Dashboard@get_nilai_cpl_operator')->name('get-cpl-dashboard');

        Route::get('/extract-pdf/{params}', 'NilaiCpl@extract_pdf')->name('extract-pdf');
    });

    Route::group(['prefix' => 'kajur', 'middleware' => ['auth'], 'as' => 'kajur.'], function () {
        Route::get('/dashboard-kajur', 'Dashboard@dashboard_kajur')->name('dashboard-kajur');

        Route::get('/cpl', 'CplProdiController@index')->name('cpl');
        Route::get('/indikator-kinerja', 'IndikatorKinerjaController@index')->name('indikator-kinerja');
        Route::get('/ikdengancpmk', 'IkDenganCpmkController@index')->name('ikdengancpmk');
        Route::get('/nilai', 'NilaiController@index')->name('nilai');
        Route::get('/nilaicpl', 'NilaiCpl@index')->name('nilaicpl');
    });

    Route::group(['prefix' => 'lpm', 'middleware' => ['auth'], 'as' => 'lpm.'], function () {
        Route::get('/dashboard-lpm', 'Dashboard@dashboard_lpm')->name('dashboard-lpm');

        Route::get('/cpl', 'CplProdiController@index')->name('cpl');
        Route::get('/indikator-kinerja', 'IndikatorKinerjaController@index')->name('indikator-kinerja');
        Route::get('/ikdengancpmk', 'IkDenganCpmkController@index')->name('ikdengancpmk');
        Route::get('/nilai', 'NilaiController@index')->name('nilai');
        Route::get('/nilaicpl', 'NilaiCpl@index')->name('nilaicpl');
    });

    Route::group(['prefix' => 'dosen', 'middleware' => ['auth'], 'as' => 'dosen.'], function () {
        Route::get('/dashboard-dosen', 'Dashboard@dashboard_dosen')->name('dashboard-dosen');
        Route::get('/get-nilai-cpl-user', 'Dashboard@get_nilai_cpl_user')->name('get-nilai-cpl-user');

        Route::get('/dashboard/{params}', 'Dashboard@dashboard')->name('dashboard');

        Route::get('/get-kelas', 'KelasController@get_kelas')->name('get-kelas');

        Route::get('/cpmk/{params}', 'CpmkController@index')->name('cpmk');
        Route::get('/get-cpmk', 'CpmkController@get')->name('get-cpmk');
        Route::get('/get-cpmk-by-uuid-matkul/{params}', 'CpmkController@get_cpmk_by_uuid_matkul')->name('get-cpmk-by-uuid-matkul');
        Route::get('/show-cpmk/{params}', 'CpmkController@show')->name('show-cpmk');
        Route::post('/add-cpmk', 'CpmkController@store')->name('add-cpmk');
        Route::post('/update-cpmk/{params}', 'CpmkController@update')->name('update-cpmk');
        Route::delete('/delete-cpmk/{params}', 'CpmkController@delete')->name('delete-cpmk');

        Route::get('/subcpmk/{params}', 'SubCpmkController@index')->name('subcpmk');
        Route::get('/get-subcpmk/{params}', 'SubCpmkController@get')->name('get-subcpmk');
        Route::get('/show-subcpmk/{params}', 'SubCpmkController@show')->name('show-subcpmk');
        Route::post('/add-subcpmk', 'SubCpmkController@store')->name('add-subcpmk');
        Route::post('/update-subcpmk/{params}', 'SubCpmkController@update')->name('update-subcpmk');
        Route::delete('/delete-subcpmk/{params}', 'SubCpmkController@delete')->name('delete-subcpmk');

        Route::get('/penilaian', 'PenilaianController@index')->name('penilaian');
        Route::get('/get-penilaian', 'PenilaianController@get')->name('get-penilaian');
        Route::get('/show-penilaian', 'PenilaianController@show')->name('show-penilaian');
        Route::post('/add-penilaian', 'PenilaianController@store')->name('add-penilaian');
        Route::post('/update-penilaian', 'PenilaianController@update')->name('update-penilaian');
        Route::delete('/delete-penilaian/{params}', 'PenilaianController@delete')->name('delete-penilaian');

        Route::get('/nilai-cpmk', 'NilaiCpmk@index')->name('nilai-cpmk');
        Route::get('/get-nilai-cpmk', 'NilaiCpmk@get')->name('get-nilai-cpmk');

        Route::get('/nilaicpl', 'NilaiCpl@index')->name('nilaicpl');
        Route::get('/get-nilaicpl', 'NilaiCpl@get')->name('get-nilaicpl');

        Route::get('/get-matkul-by-user', 'MataKuliahController@get_by_user')->name('get-matkul-by-user');
        Route::get('/get-cpmk-by-matkul/{params}', 'CpmkController@get_cpmk_by_matkul')->name('get-cpmk-by-matkul');

        Route::get('/extract-pdf', 'NilaiCpl@extract_pdf')->name('extract-pdf');
    });

    Route::get('/ubahpassword', 'UbahPassword@index')->name('ubahpassword');
    Route::post('/update-password/{params}', 'UbahPassword@update')->name('update-password');

    Route::get('/logout', 'Auth@logout')->name('logout');
});
