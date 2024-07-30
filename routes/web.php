<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JaringanController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Assign\AssignController;
use App\Http\Controllers\DependantDropdownController;
use App\Http\Controllers\Assign\AssignToUserController;
use App\Http\Controllers\AssignRole\AssignRoleController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Assign\PermissionToRoleController;
use App\Http\Controllers\EvaluasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome')
    return redirect()->route('login');
});

Route::get('provinces', [DependantDropdownController::class, 'provinces'])->name('provinces');
Route::get('cities', [DependantDropdownController::class, 'cities'])->name('cities');
Route::get('districts', [DependantDropdownController::class, 'districts'])->name('districts');
Route::get('villages', [DependantDropdownController::class, 'villages'])->name('villages');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
  Route::resource('users', UserController::class);

  Route::resource('/permissions', PermissionController::class)->except('show');
  Route::resource('/roles', RoleController::class)->except('show');

  
  // Route::get('/assign-permissions', [PermissionToRoleController::class, 'PermissionToRoleindex'])->name('assign.permissions.index');
  // Route::post('/assign-permissions', [PermissionToRoleController::class, 'PermissionToRolestore'])->name('assign.permissions.store');

  Route::get('assign-permissions', [AssignController::class, 'create'])->name('assign.permissions.create');
  Route::post('assign-permissions', [AssignController::class, 'store'])->name('assign.permissions.store');

  Route::get('assign-users', [AssignToUserController::class, 'create'])->name('assign.users.create');
  Route::post('assign-users', [AssignToUserController::class, 'store'])->name('assign.users.store');


  //route jaringan
  Route::get('jaringan-atab', [JaringanController::class, 'index'])->name('jaringan-atab.index');
  Route::get('jaringan-atab/create', [JaringanController::class, 'create'])->name('jaringan-atab.create');
  Route::post('jaringan-atab', [JaringanController::class, 'store'])->name('jaringan-atab.store');
  Route::get('jaringan-atab/{jaringan}', [JaringanController::class, 'edit'])->name('jaringan-atab.edit');
  Route::put('jaringan-atab/{jaringan}', [JaringanController::class, 'update'])->name('jaringan-atab.update');
  Route::delete('jaringan-atab/{jaringan}', [JaringanController::class, 'destroy'])->name('jaringan-atab.destroy');
  Route::get('jaringan-atab/{jaringan}/show', [JaringanController::class, 'show'])->name('jaringan-atab.show');

  //----------ROUTE PROSES POP-----------------//
  Route::get('jaringan-atab/{jaringan}/pembentukan-tim', [JaringanController::class, 'pembentukanTimContent'])->name('pembentukan-tim.content');
  Route::post('jaringan-atab/{jaringan}/pembentukan-tim', [JaringanController::class, 'pembentukanTim'])->name('pembentukan-tim.store');
  Route::post('/jaringan-atab/{jaringan}/pembentukan-tim-update', [JaringanController::class, 'updatePembentukanTim'])->name('pembentukan-tim.update');

  Route::get('jaringan-atab/{jaringan}/penyusunan-rencana-kerja', [JaringanController::class, 'penyusunanRencanaKerjaContent'])->name('penyusunan-rencana-kerja.content');
  Route::post('jaringan-atab/{jaringan}/penyusunan-rencana-kerja', [JaringanController::class, 'penyusunanRencanaKerja'])->name('penyusunan-rencana-kerja.store');
  Route::post('/jaringan-atab/{jaringan}/penyusunan-rencana-kerja-update', [JaringanController::class, 'updatePenyusunanRencanaKerja'])->name('penyusunan-rencana-kerja.update');

  Route::get('jaringan-atab/{jaringan}/sosialisasi-koordinasi', [JaringanController::class, 'sosialisasiKoordinasiContent'])->name('sosialisasi-koordinasi.content');
  Route::post('jaringan-atab/{jaringan}/sosialisasi-koordinasi', [JaringanController::class, 'sosialisasiKoordinasi'])->name('sosialisasi-koordinasi.store');
  Route::post('/jaringan-atab/{jaringan}/sosialisasi-koordinasi-update', [JaringanController::class, 'updateSosialisasiKoordinasi'])->name('sosialisasi-koordinasi.update');

  Route::get('/evaluasi-awal/{jaringan}', [EvaluasiController::class, 'evaluasiAwal'])->name('evaluasi-awal');
});
    