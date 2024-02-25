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

    Route::group(['prefix' => 'operator', 'middleware' => ['auth'], 'as' => 'operator.'], function () {
        Route::get('/dashboard-operator', 'Dashboard@dashboard_operator')->name('dashboard-operator');

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

        Route::get('/cpldenganik', 'CplDenganIkController@index')->name('cpldenganik');
        Route::get('/get-cpldenganik', 'CplDenganIkController@get')->name('get-cpldenganik');
        Route::get('/show-cpldenganik/{params}', 'CplDenganIkController@show')->name('show-cpldenganik');
        Route::post('/add-cpldenganik', 'CplDenganIkController@store')->name('add-cpldenganik');
        Route::post('/update-cpldenganik/{params}', 'CplDenganIkController@update')->name('update-cpldenganik');
        Route::delete('/delete-cpldenganik/{params}', 'CplDenganIkController@delete')->name('delete-cpldenganik');

        Route::get('/ikdengancpmk', 'IkDenganCpmkController@index')->name('ikdengancpmk');
        Route::get('/get-ikdengancpmk', 'IkDenganCpmkController@get')->name('get-ikdengancpmk');
        Route::get('/show-ikdengancpmk/{params}', 'IkDenganCpmkController@show')->name('show-ikdengancpmk');
        Route::post('/add-ikdengancpmk', 'IkDenganCpmkController@store')->name('add-ikdengancpmk');
        Route::post('/update-ikdengancpmk/{params}', 'IkDenganCpmkController@update')->name('update-ikdengancpmk');
        Route::delete('/delete-ikdengancpmk/{params}', 'IkDenganCpmkController@delete')->name('delete-ikdengancpmk');
    });

    Route::group(['prefix' => 'kajur', 'middleware' => ['auth'], 'as' => 'kajur.'], function () {
        Route::get('/dashboard-kajur', 'Dashboard@dashboard_kajur')->name('dashboard-kajur');
    });

    Route::group(['prefix' => 'dosen', 'middleware' => ['auth'], 'as' => 'dosen.'], function () {
        Route::get('/dashboard-dosen', 'Dashboard@dashboard_dosen')->name('dashboard-dosen');

        Route::get('/ikdengancpmk', 'IkDenganCpmkController@index')->name('ikdengancpmk');

        Route::get('/nilai', 'NilaiController@index')->name('nilai');
        Route::get('/get-nilai', 'NilaiController@get')->name('get-nilai');
        Route::get('/show-nilai/{params}', 'NilaiController@show')->name('show-nilai');
        Route::post('/add-nilai', 'NilaiController@store')->name('add-nilai');
        Route::post('/update-nilai/{params}', 'NilaiController@update')->name('update-nilai');
        Route::delete('/delete-nilai/{params}', 'NilaiController@delete')->name('delete-nilai');
    });

    Route::get('/ubahpassword', 'UbahPassword@index')->name('ubahpassword');
    Route::post('/update-password/{params}', 'UbahPassword@update')->name('update-password');

    Route::get('/logout', 'Auth@logout')->name('logout');
});
