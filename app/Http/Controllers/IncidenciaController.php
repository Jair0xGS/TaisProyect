<?php

namespace App\Http\Controllers;

use App\Auditoria;
use App\Empresa;
use App\Incidencia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Empresa::findOrFail(Auth::user()->empresa_id)->incidencias;
        return view("incidencias.index",compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("incidencias.register");
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
                'descripcion'=>'required',
                'categoria'=>'required',

            ]
        );
        DB::beginTransaction();
        try {
                $incidencia = new Incidencia();
                $incidencia->descripcion =$request->descripcion;
                $incidencia->categoria =$request->categoria;
                $incidencia->estado ="Por Atender";
                $incidencia->empresa_id =Auth::user()->empresa_id;
                $incidencia->save();

                $auditoria = new Auditoria();
                $auditoria->tabla ="incidencia";
                $auditoria->accion ="crear";
                $auditoria->terminal =$request->ip();
                $auditoria->empresa_id =Auth::user()->empresa_id;
                $auditoria->user_id =Auth::id();
                $auditoria->nombre =Auth::user()->name;
                $auditoria->despues = $incidencia->toJson();
                $auditoria->save();
            DB::commit();
        }catch (\Exception $exception ){

            DB::rollBack();
            return redirect()->back()->with("error","fallo al editar incidencia");
        }
        return redirect()->route("incidencia.index")->with("success","incidencia creado correctamente");
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
    public function edit($id)
    {
        $data = Incidencia::findOrFail($id);
        return view("incidencias.edit",compact("data"));
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
                'estado'=>'required',

            ]
        );
        if ($request->estado !="Sin Solucionar"){
            if (! isset($request->solucion)){
                return back()->with("error","Debe ingresar una solucion");
            }
        }
        DB::beginTransaction();
        try {
            $incidencia = Incidencia::findOrFail($id);
            $incidencia->estado =$request->estado;

            if ($request->estado =="Solucionado"){
                $incidencia->solucion =$request->solucion;
            }
            $incidencia->save();

            $auditoria = new Auditoria();
            $auditoria->tabla ="incidencia";
            $auditoria->accion ="editar";
            $auditoria->terminal =$request->ip();
            $auditoria->empresa_id =Auth::user()->empresa_id;
            $auditoria->user_id =Auth::id();
            $auditoria->nombre =Auth::user()->name;
            $auditoria->despues = $incidencia->toJson();
            $auditoria->save();
            DB::commit();
        }catch (\Exception $exception ){

            DB::rollBack();
            return redirect()->back()->with("error","fallo al editar incidencia");
        }
        return redirect()->route("incidencia.index")->with("success","incidencia editado correctamente");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
