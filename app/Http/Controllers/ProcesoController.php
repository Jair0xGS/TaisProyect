<?php

namespace App\Http\Controllers;

use App\Auditoria;
use App\Empresa;
use App\Proceso;
use App\TipoProceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProcesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $empresa = Empresa::findOrfail($request->empresa) ;
        $data = $empresa->procesos;
        return view("proceso.index",compact("data"));
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipo_procesos = TipoProceso::all();
        return view("proceso.register",compact("tipo_procesos"));
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
            'empresa_id'=>'required|exists:empresas,id',
            'tipo_proceso_id'=>'required|exists:tipo_procesos,id',
            'nombre'=>'required',

        ]
        );
        DB::transaction(function () use ($request){
            try {
                $proceso = new Proceso();
                $proceso->empresa_id =$request->empresa_id;
                $proceso->tipo_proceso_id =$request->tipo_proceso_id;
                $proceso->nombre =$request->nombre;
                $proceso->save();

                $auditoria = new Auditoria();
                $auditoria->tabla ="proceso";
                $auditoria->accion ="crear";
                $auditoria->terminal =$request->ip();
                $auditoria->user_id =Auth::id();
                $auditoria->nombre =Auth::user()->name;
                $auditoria->antes ="{}";
                $auditoria->despues = $proceso->toJson();
                $auditoria->save();
            }catch (\Exception $exception ){

                DB::rollBack();
                return redirect()->back()->with("error","fallo al crear proceso");
            }
        });
        return redirect()->route("proceso.index",$request->empresa)->with("success","proceso creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $proceso = Proceso::where("empresa_id",$request->empresa)->where("id",$request->proceso)->first() ;
        $data = $proceso;
        return view("proceso.show",compact("data"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
