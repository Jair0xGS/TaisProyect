<?php

namespace App\Http\Controllers;

use App\Campos;
use App\Formula;
use App\Personal;
use App\Proceso;
use App\Tabla;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndicadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proceso = Proceso::where('empresa_id','=',Auth::user()->Empresa->id)->where('proceso_id','=',null)->get();
        return view('indicadores.index', compact('proceso'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proceso = Proceso::where('empresa_id','=',Auth::user()->Empresa->id)->where('proceso_id','=',null)->get();
        $personal = User::role('supervisor')->where('empresa_id','=',Auth::user()->Empresa->id)->get();
        $formula = Formula::get();
        $tabla = Tabla::get();
        return view('indicadores.register',compact('proceso','personal','formula','tabla'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ObtenerSubproceso($id){
        return Proceso::where('proceso_id','=',$id)->get();
    }
    public function ObtenerCampos1($id){
        return Campos::where('tabla_id','=',$id)->get();
    }
    public function ObtenerCampos2($id){
        return Campos::where('tabla_id','=',$id)->get();
    }

    public function store(Request $request)
    {
        $data=request()->validate([
            'descripcion'=>'required',
            'objeto_medicion'=>'required',
            'tolerancia'=>'required',
            'mecanismo'=>'required',
            'objetivo'=>'required',
            'unidad'=>'required',
            'parametro1'=>'required',
            'personal_id'=>'required',
        ],
            [
                'descripcion.required'=>'Ingrese la denominación para el indicador.',
                'objeto medición.required'=>'Responda a la pregunta: ¿Qué se mide?.',
                'tolerancia.required'=>'Indique la tolerancia que admite el indicador.',
                'mecanismo.required'=>'Ingrese el Mecanismo de medición.',
                'objetivo.required'=>'Ingrese el objetivo del indicador.',
                'unidad.required'=>'Ingrese la unidad del indicador.',
                'parametro1.required'=>'Ingresar el parámetro 1.',
                'personal_id.required'=>'Ingresar personal.',
            ]
        );

        // DB::transaction(function ($request) {
        $empresa= new Empresa();
        $empresa->ruc=$request->ruc;
        $empresa->nombre=$request->nombre;
        $empresa->descripcion=$request->descripcion;
        $empresa->telefono=$request->telefono;
        $empresa->email=$request->email;
        $empresa->direccion=$request->direccion;

        $empresa->save();

        $auditoria = new Auditoria();
        $auditoria->tabla = 'EMPRESA';
        $auditoria->accion = 'REGISTRAR';
        $auditoria->terminal = gethostbyname(gethostname());
        $auditoria->user_id = Auth::user()->id;
        $auditoria->nombre = Auth::user()->name;
        $auditoria->despues = json_encode([
            'RUC' => $request->ruc,
            'Nombre' => $request->nombre,
            'Descripcion' => $request->descripcion,
            'Telefono' => $request->telefono,
            'Email' => $request->email,
            'Direccion' => $request->direccion,
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->empresa_id = $empresa->id;
        $auditoria->save();

        $user = new User();
        $user->name = $request->ruc."_admin";
        $user->email= "admin_".$request->ruc."@bpm.com";
        $user->password= \Illuminate\Support\Facades\Hash::make("password");
        $user->empresa_id= $empresa->id;
        $user->assignRole('admin');
        $user->save();

        $auditoriaU = new Auditoria();
        $auditoriaU->tabla = 'USER';
        $auditoriaU->accion = 'REGISTRAR';
        $auditoriaU->terminal = gethostbyname(gethostname());
        $auditoriaU->user_id = Auth::user()->id;
        $auditoriaU->nombre = Auth::user()->name;
        $auditoriaU->despues = json_encode([
            'Nombre' => $user->name,
            'Email' => $user->email,
            'Rol' => 'admin',
            'Empresa' => $user->empresa_id
        ], JSON_UNESCAPED_UNICODE);
        $auditoriaU->empresa_id = $user->empresa_id;
        $auditoriaU->save();

        return redirect()->route('empresa.index')->with('datos', '¡Registro nuevo guardado!');
        //});
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
