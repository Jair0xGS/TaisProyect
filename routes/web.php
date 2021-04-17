<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');


//***********
//proceso routes
Route::resource("/empresa/{empresa}/proceso",ProcesoController::class);
Route::resource("/empresa/{empresa}/proceso",ProcesoController::class);
Route::resource("/empresa/{empresa}/proceso/{proceso}/subproceso",SubProcesoController::class);
//Route::resource("/empresa/{empresa}/mapa_proceso",MapaProcesoController::class);
Route::resource("/empresa/{empresa}/proceso/{proceso}/mapa_estrategico",MapaEstrategicoController::class);
Route::resource("/empresa/{empresa}/proceso/{proceso}/mapa_estrategico/{mapa_estrategico}/estrategia",EstrategiaController::class);
//***********



//#####################
//empresa routes
Route::resource('/empresa', EmpresaController::class);
Route::get('cancelarEmpresa', function(){
    return redirect()->route('empresa.index')->with('datos','¡Accion cancelada!');
})->name('cancelarEmpresa');
//#####################

//#####################
//area y puesto routes
Route::resource('/area', AreaController::class);
Route::resource('/puesto', PuestoController::class);
//#####################


//#####################
//auditoria routes
Route::resource('/auditoria', AuditoriaController::class);
//#####################

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//#####################
//user routes
Route::resource('/user', UserController::class);
//#####################
