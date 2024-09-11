<?php

use App\Http\Controllers\JaringanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//data penyususan BA Hasil Evaluasi Awal Kesiapan OP
Route::get('/ba-awal-kesiapan-op/{id}', [JaringanController::class, 'apiPenyusunanBaEvaluasiAwal'])->name('api.ba-awal-kesiapan-op');

Route::get('api/penyusunan-ba-evaluasi-awal-history/{id}', [JaringanController::class, 'apiPenyusunanBaEvaluasiAwalHistory'])->name('api.ba-awal-kesiapan-op-history');
