<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Area;
use App\Auditoria;
use Illuminate\Support\Facades\Auth;


class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const PAGINACION=3;
    public function index(Request $request)
    {
        $em = Auth::user()->Empresa;
        $area = Area::where('empresa_id','=',$em->id)->paginate($this::PAGINACION);
        return view('areas.index', compact('area', 'em'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=request()->validate([
            'nombre'=>'required'
        ],
            [
                'nombre.required'=>'Ingrese un NOMBRE para continuar'
            ]
        );

        $area= new Area();
        $area->nombre=$request->nombre;
        $area->empresa_id=Auth::user()->Empresa->id;
        $area->save();

        $auditoria = new Auditoria();
        $auditoria->tabla = 'AREA';
        $auditoria->accion = 'REGISTRAR';
        $auditoria->terminal = gethostbyname(gethostname());
        $auditoria->user_id = Auth::user()->id;
        $auditoria->nombre = Auth::user()->name;
        $auditoria->despues = json_encode([
            'Area' => $area->nombre,
            'Empresa' => Auth::user()->Empresa->nombre
        ], JSON_UNESCAPED_UNICODE);

        $auditoria->save();

        return redirect()->route('area.index')->with('datos', '¡Área registrada con éxito!');
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
        $areaAntes=Area::findOrFail($id);
        $area=Area::findOrFail($id);
        $area->nombre=$request->nombre;
        $area->save();

        $auditoria = new Auditoria();
        $auditoria->tabla = 'AREA';
        $auditoria->accion = 'EDITAR';
        $auditoria->terminal = gethostbyname(gethostname());
        $auditoria->user_id = Auth::user()->id;
        $auditoria->nombre = Auth::user()->name;
        $auditoria->antes = json_encode([
            'Area' => $areaAntes->nombre,
            'Empresa' => Auth::user()->Empresa->nombre
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->despues = json_encode([
            'Area' => $area->nombre,
            'Empresa' => Auth::user()->Empresa->nombre,
        ], JSON_UNESCAPED_UNICODE);

        $auditoria->save();

        return redirect()->route('area.index')->with('datos', '¡Área editada con éxito!');
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
            $areaAntes=Area::findOrFail($id);

            $auditoria = new Auditoria();
            $auditoria->tabla = 'AREA';
            $auditoria->accion = 'ELIMINAR';
            $auditoria->terminal = gethostbyname(gethostname());
            $auditoria->user_id = Auth::user()->id;
            $auditoria->nombre = Auth::user()->name;
            $auditoria->antes = json_encode([
                'Área' => $areaAntes->nombre,
                'Empresa' =>Auth::user()->Empresa->nombre,
            ], JSON_UNESCAPED_UNICODE);
            $auditoria->save();

            Area::find($id)->forceDelete();
            return redirect()->route('area.index')->with('datos', '¡Área Eliminada con éxito!');
        }catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('area.index')->with('datos', '¡ERROR: El área que quiere eliminar está en uso!');
        }
    }
}
