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


  Route::resource('jaringan-atab', JaringanController::class);
  Route::get('jaringan-atab/{jaringan}/edit', [JaringanController::class, 'edit'])->name('jaringan-atab.edit');
Route::put('jaringan-atab/{jaringan}', [JaringanController::class, 'update'])->name('jaringan-atab.update');


});
    