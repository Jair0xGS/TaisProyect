<?php

namespace App\Http\Controllers;

use App\Auditoria;
use App\Empresa;
use App\Personal;
use App\Proceso;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubProcesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $empresa = Empresa::findOrFail($request->empresa);
        $personals =$empresa->personals;
        return view("subproceso.register",compact("personals"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
                'personal_id'=>'required|exists:personals,id',
                'nombre'=>'required',

            ]
        );
        DB::beginTransaction();
            try {
                $proceso = new Proceso();
                $proceso->empresa_id =$request->empresa;
                $proceso->personal_id =$request->personal_id;
                $proceso->proceso_id =$request->proceso;
                $proceso->nombre =$request->nombre;
                $proceso->save();

                $auditoria = new Auditoria();
                $auditoria->tabla ="sub_proceso";
                $auditoria->accion ="crear";
                $auditoria->terminal =$request->ip();
                $auditoria->empresa_id =$request->empresa;
                $auditoria->user_id =Auth::id();
                $auditoria->nombre =Auth::user()->name;
                $auditoria->save();
                $auditoria->despues = $proceso->toJson();
                DB::commit();
            }catch (\Exception $exception ){

                DB::rollBack();
                return redirect()->back()->with("error","fallo al crear sub proceso");
            }
        return redirect()->route("proceso.show",[$request->empresa,$request->proceso])->with("success","sub proceso creado correctamente");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $empresa = Empresa::findOrFail($request->empresa);
        $personals =$empresa->personals;
        $data = Proceso::findOrFail($request->subproceso);

        return view("subproceso.edit",compact("personals","data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
                'personal_id'=>'required|exists:personals,id',
                'empresa_id'=>'required|exists:empresas,id',
                'proceso_id'=>'required|exists:procesos,id',
                'nombre'=>'required',

            ]
        );
        DB::beginTransaction();
            try {
                $proceso = Proceso::findOrFail($request->subproceso);
                $proceso->personal_id =$request->personal_id;
                $proceso->nombre =$request->nombre;
                $proceso->save();

                $auditoria = new Auditoria();
                $auditoria->tabla ="sub_proceso";
                $auditoria->accion ="crear";
                $auditoria->terminal =$request->ip();
                $auditoria->empresa_id =$request->empresa;
                $auditoria->user_id =Auth::id();
                $auditoria->nombre =Auth::user()->name;
                $auditoria->save();
                $auditoria->despues = $proceso->toJson();
                DB::commit();
            }catch (\Exception $exception ){

                DB::rollBack();
                return redirect()->back()->with("error","fallo al editar sub proceso");
            }

        return redirect()->route("proceso.show",[$request->empresa,$request->proceso])->with("success","sub proceso editar correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $proceso = Proceso::findOrFail($request->subproceso);

            $auditoria = new Auditoria();
            $auditoria->tabla ="sub_proceso";
            $auditoria->accion ="borrar";
            $auditoria->terminal =$request->ip();
            $auditoria->empresa_id =$request->empresa;
            $auditoria->user_id =Auth::id();
            $auditoria->nombre =Auth::user()->name;
            $auditoria->antes = $proceso->toJson();
            $proceso->delete();
            $auditoria->save();
            DB::commit();
            return redirect()->route("proceso.show",[$request->empresa,$request->proceso])->with("success","sub proceso borrado correctamente");
        }catch (\Throwable $exception ){

            DB::rollBack();
            return redirect()->route("proceso.show",[$request->empresa,$request->proceso])->with("error","fallo al borrar sub proceso");
        }
    }
}
