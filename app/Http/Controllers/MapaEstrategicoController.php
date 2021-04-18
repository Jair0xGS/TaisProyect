<?php

namespace App\Http\Controllers;

use App\Auditoria;
use App\Empresa;
use App\MapaEstrategico;
use App\Perspectiva;
use App\Relacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MapaEstrategicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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

        return view("mapa_estrategico.register");
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
                'nombre'=>'required',

            ]
        );
        DB::beginTransaction();
            try {
                $proceso = new MapaEstrategico();
                $proceso->nombre =$request->nombre;
                $proceso->proceso_id =$request->proceso;
                $proceso->save();

                $auditoria = new Auditoria();
                $auditoria->tabla ="mapa_estrategico";
                $auditoria->accion ="crear";
                $auditoria->terminal =$request->ip();
                $auditoria->empresa_id =$request->empresa;
                $auditoria->user_id =Auth::id();
                $auditoria->nombre =Auth::user()->name;
                $auditoria->despues = $proceso->toJson();
                $auditoria->save();
                DB::commit();
            }catch (\Exception $exception ){

                DB::rollBack();
                return redirect()->back()->with("error","fallo al crear mapa estrategico");
            }
        return redirect()->route("proceso.show",[$request->empresa,$request->proceso])->with("success","mapa estrategico creado correctamente");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = MapaEstrategico::with(['estrategias.estrategias','estrategias.relacion'])->findOrFail($request->mapa_estrategico);

        return view("mapa_estrategico.show",compact("data"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $perspectivas = Perspectiva::all();
        $relaciones =  Relacion::all();
        $data = MapaEstrategico::findOrFail($request->mapa_estrategico);
        return view("mapa_estrategico.edit",compact("perspectivas","relaciones","data"));
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
                'nombre'=>'required',

            ]
        );
        DB::beginTransaction();
        try {
            $proceso = MapaEstrategico::findOrFail($request->mapa_estrategico);
            $proceso->nombre =$request->nombre;
            $proceso->save();

            $auditoria = new Auditoria();
            $auditoria->tabla ="mapa_estrategico";
            $auditoria->accion ="crear";
            $auditoria->terminal =$request->ip();
            $auditoria->empresa_id =$request->empresa;
            $auditoria->user_id =Auth::id();
            $auditoria->nombre =Auth::user()->name;
            $auditoria->despues = $proceso->toJson();
            $auditoria->save();
            DB::commit();
        }catch (\Exception $exception ){

            DB::rollBack();
            return redirect()->back()->with("error","fallo al actualizar mapa estrategico");
        }
        return redirect()->route("proceso.show",[$request->empresa,$request->proceso])->with("success","mapa estrategico actualizado correctamente");

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
            $mapa = MapaEstrategico::findOrFail($request->mapa_estrategico);

            $auditoria = new Auditoria();
            $auditoria->tabla ="mapa_estrategico";
            $auditoria->accion ="borrar";
            $auditoria->terminal =$request->ip();
            $auditoria->empresa_id =$request->empresa;
            $auditoria->user_id =Auth::id();
            $auditoria->nombre   =Auth::user()->name;
            $auditoria->antes = $mapa->toJson();
            $mapa->delete();
            $auditoria->save();
            DB::commit();
            return redirect()->route("proceso.show",[$request->empresa,$request->proceso])->with("success","mapa estrategico borrado correctamente");
        }catch (\Throwable $exception ){

            DB::rollBack();
            report($exception);
            return redirect()->route("proceso.show",[$request->empresa,$request->proceso])->with("error","fallo al borrar proceso");
        }
    }
}
