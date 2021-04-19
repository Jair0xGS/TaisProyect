<?php

use Illuminate\Support\Facades\Auth;
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
//user/personal routes
Route::resource('/user', UserController::class);
Route::get('cancelarPersonal', function(){
    return redirect()->route('user.index')->with('datos','¡Accion cancelada!');
})->name('cancelarPersonal');
Route::get('rotacion/{id}', function($id) {
    $personal = \App\Personal::where('empresa_id','=',\Illuminate\Support\Facades\Auth::user()->Empresa->id)
        ->where('id','<>',$id)->get();
    return view('usuarios.rotacion', compact('personal', 'id'));
})->name('rotacion');
Route::get('intercambio/{id}/{id_select}', 'UserController@intercambio')->name('intercambio');

//#####################


//#####################
//Indicador routes
Route::resource('/indicador', IndicadorController::class);
Route::get('ObtenerSubproceso/{id}', 'IndicadorController@ObtenerSubproceso');
//#####################
