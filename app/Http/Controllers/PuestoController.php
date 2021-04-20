<?php

namespace App\Http\Controllers;

use App\Area;
use App\Puesto;
use App\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PuestoController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'nombre'=>'required'
        ],
            [
                'nombre.required'=>'Ingrese un NOMBRE para continuar'
            ]
        );

        $puesto= new Puesto();
        $puesto->nombre=$request->nombre;
        $puesto->area_id=$request->area_id;
        $puesto->save();

        $auditoria = new Auditoria();
        $auditoria->tabla = 'PUESTO';
        $auditoria->accion = 'REGISTRAR';
        $auditoria->terminal = gethostbyname(gethostname());
        $auditoria->user_id = Auth::user()->id;
        $auditoria->nombre = Auth::user()->name;
        $auditoria->despues = json_encode([
            'Puesto' => $puesto->nombre,
            'Empresa' => Auth::user()->Empresa->nombre
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->empresa_id = Auth::user()->Empresa->id;
        $auditoria->save();

        return redirect()->route('area.index')->with('datos', '¡Puesto registrado con éxito!');
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
        $data=request()->validate([
            'nombre'=>'required'
        ],
            [
                'nombre.required'=>'Ingrese un NOMBRE para continuar'
            ]
        );
        $puestoAntes=Puesto::findOrFail($id);
        $puesto=Puesto::findOrFail($id);
        $puesto->nombre=$request->nombre;
        $puesto->save();

        $auditoria = new Auditoria();
        $auditoria->tabla = 'PUESTO';
        $auditoria->accion = 'EDITAR';
        $auditoria->terminal = gethostbyname(gethostname());
        $auditoria->user_id = Auth::user()->id;
        $auditoria->nombre = Auth::user()->name;
        $auditoria->antes = json_encode([
            'Puesto' => $puestoAntes->nombre,
            'Empresa' => Auth::user()->Empresa->nombre
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->despues = json_encode([
            'Puesto' => $puesto->nombre,
            'Empresa' => Auth::user()->Empresa->nombre,
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->empresa_id = Auth::user()->Empresa->id;
        $auditoria->save();

        return redirect()->route('area.index')->with('datos', '¡Puesto editado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $puestoAntes=Puesto::findOrFail($id);

            $auditoria = new Auditoria();
            $auditoria->tabla = 'PUESTO';
            $auditoria->accion = 'ELIMINAR';
            $auditoria->terminal = gethostbyname(gethostname());
            $auditoria->user_id = Auth::user()->id;
            $auditoria->nombre = Auth::user()->name;
            $auditoria->antes = json_encode([
                'Puesto' => $puestoAntes->nombre,
                'Empresa' =>Auth::user()->Empresa->nombre,
            ], JSON_UNESCAPED_UNICODE);
            $auditoria->empresa_id = Auth::user()->Empresa->id;
            $auditoria->save();

            Puesto::find($id)->forceDelete();
            return redirect()->route('area.index')->with('datos', '¡Puesto Eliminado con éxito!');
        }catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('area.index')->with('datos', '¡ERROR: El puesto que quiere eliminar está en uso!');
        }
    }
}
