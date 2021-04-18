<?php

namespace App\Http\Controllers;

use App\Auditoria;
use App\Estrategia;
use App\MapaEstrategico;
use App\Perspectiva;
use App\Relacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstrategiaController extends Controller
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
        $perspectivas = Perspectiva::all();
        $relaciones =  Relacion::all();
        $mp =  MapaEstrategico::findOrFail($request->mapa_estrategico);
        $estrategias = $mp->estrategias;
        return view("estrategia.register",compact("perspectivas","relaciones","estrategias"));
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
            'perspectiva_id'=>'required|exists:perspectivas,id',
            'relacion_id'=>'required|exists:relacions,id',
            'nombre'=>'required',

        ]
    );
        if ($request->perspectiva_id != 1){
            if ( !isset($request->estrategia_id )){
                    return redirect()->back()->with("error","Se necesita una estrategia a referenciar");
            }
        }
        DB::beginTransaction();
            try {
                $estrategia = new Estrategia();
                $estrategia->perspectiva_id = $request->perspectiva_id;
                $estrategia->mapa_estrategico_id = $request->mapa_estrategico;
                $estrategia->relacion_id = $request->relacion_id;
                $estrategia->nombre = $request->nombre;
                if ($request->perspectiva_id != 1) {

                    $estrategia->estrategia_id = $request->estrategia_id;
                }
                $estrategia->save();

                $auditoria = new Auditoria();
                $auditoria->tabla = "estrategia";
                $auditoria->accion = "crear";
                $auditoria->terminal = $request->ip();
                $auditoria->empresa_id = $request->empresa;
                $auditoria->user_id = Auth::id();
                $auditoria->nombre = Auth::user()->name;
                $auditoria->despues = $estrategia->toJson();
                $auditoria->save();
                DB::commit();
            }catch (\Exception $exception ){

                DB::rollBack();
                return redirect()->back()->with("error","fallo al crear proceso");
            }
        return redirect()->route("mapa_estrategico.show",[$request->empresa,$request->proceso,$request->mapa_estrategico])->with("success","proceso creado correctamente");

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
        $perspectivas = Perspectiva::all();
        $relaciones =  Relacion::all();
        $mp =  MapaEstrategico::findOrFail($request->mapa_estrategico);
        $estrategias = $mp->estrategias;
        $data = Estrategia::findOrFail($request->estrategium);
        return view("estrategia.edit",compact("perspectivas","relaciones","estrategias","data"));
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
                'perspectiva_id'=>'required|exists:perspectivas,id',
                'relacion_id'=>'required|exists:relacions,id',
                'nombre'=>'required',

            ]
        );
        if ($request->perspectiva_id != 1){
            if ( !isset($request->estrategia_id )){
                return redirect()->back()->with("error","Se necesita una estrategia a referenciar");
            }
        }
        DB::beginTransaction();
        try {
            $estrategia = Estrategia::findOrFail($request->estrategium);
            $estrategia->perspectiva_id = $request->perspectiva_id;
            $estrategia->relacion_id = $request->relacion_id;
            $estrategia->nombre = $request->nombre;
            if ($request->perspectiva_id != 1) {

                $estrategia->estrategia_id = $request->estrategia_id;
            }
            $estrategia->save();

            $auditoria = new Auditoria();
            $auditoria->tabla = "estrategia";
            $auditoria->accion = "actualizar";
            $auditoria->terminal = $request->ip();
            $auditoria->empresa_id = $request->empresa;
            $auditoria->user_id = Auth::id();
            $auditoria->nombre = Auth::user()->name;
            $auditoria->despues = $estrategia->toJson();
            $auditoria->save();
            DB::commit();
        }catch (\Exception $exception ){

            DB::rollBack();
            return redirect()->back()->with("error","fallo al crear estrategia");
        }
        return redirect()->route("mapa_estrategico.show",[$request->empresa,$request->estrategia,$request->mapa_estrategico])->with("success","estrategia creado correctamente");

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
            $mapa = Estrategia::findOrFail($request->estrategium);

            $auditoria = new Auditoria();
            $auditoria->tabla ="estrategia";
            $auditoria->accion ="borrar";
            $auditoria->terminal =$request->ip();
            $auditoria->empresa_id =$request->empresa;
            $auditoria->user_id =Auth::id();
            $auditoria->nombre   =Auth::user()->name;
            $auditoria->antes = $mapa->toJson();
            $mapa->delete();
            $auditoria->save();
            DB::commit();
            return redirect()->route("mapa_estrategico.show",[$request->empresa,$request->proceso,$request->mapa_estrategico])->with("success","estrategia borrado correctamente");
        }catch (\Throwable $exception ){

            DB::rollBack();
            report($exception);
            return redirect()->route("mapa_estrategico.show",[$request->empresa,$request->proceso,$request->mapa_estrategico])->with("error","fallo al borrar la estrategia");
        }
    }
}
