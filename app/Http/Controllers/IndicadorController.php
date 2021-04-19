<?php

namespace App\Http\Controllers;

use App\Campos;
use App\Formula;
use App\Indicador;
use App\Parametro;
use App\Auditoria;
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
        if($request->formula_id==3)
        {
            $data=request()->validate([
                'descripcion'=>'required',
                'objeto_medicion'=>'required',
                'tolerancia'=>'required',
                'mecanismo'=>'required',
                'objetivo'=>'required',
                'unidad'=>'required',
                'parametro1'=>'required',
                'personal_id'=>'numeric|min:1',
                'proceso_id'=>'numeric|min:1',
                'formula_id'=>'numeric|min:1',
                'tabla1'=>'numeric|min:1',
            ],
                [
                    'descripcion.required'=>'Ingrese la denominación para el indicador.',
                    'objeto medición.required'=>'Responda a la pregunta: ¿Qué se mide?.',
                    'tolerancia.required'=>'Indique la tolerancia que admite el indicador.',
                    'mecanismo.required'=>'Ingrese el Mecanismo de medición.',
                    'objetivo.required'=>'Ingrese el objetivo del indicador.',
                    'unidad.required'=>'Ingrese la unidad del indicador.',
                    'parametro1.required'=>'Ingresar el parámetro 1.',
                    'personal_id.numeric'=>'número.',
                    'personal_id.min'=>'Seleccione al responsable de la medición del indicador.',
                    'proceso_id.numeric'=>'número.',
                    'proceso_id.min'=>'Seleccione un proceso.',
                    'formula_id.numeric'=>'número.',
                    'formula_id.min'=>'Seleccione un tipo de fórmula.',
                    'tabla1.numeric'=>'número.',
                    'tabla1.min'=>'Seleccione la tabla para trabajar con el parámetro 1.',
                ]
            );
        }else{
            $data=request()->validate([
                'descripcion'=>'required',
                'objeto_medicion'=>'required',
                'tolerancia'=>'required',
                'mecanismo'=>'required',
                'objetivo'=>'required',
                'unidad'=>'required',
                'parametro1'=>'required',
                'personal_id'=>'numeric|min:1',
                'proceso_id'=>'numeric|min:1',
                'formula_id'=>'numeric|min:1',
                'tabla1'=>'numeric|min:1',
                'tabla2'=>'numeric|min:1',
                'parametro2'=>'required',
            ],
                [
                    'descripcion.required'=>'Ingrese la denominación para el indicador.',
                    'objeto medición.required'=>'Responda a la pregunta: ¿Qué se mide?.',
                    'tolerancia.required'=>'Indique la tolerancia que admite el indicador.',
                    'mecanismo.required'=>'Ingrese el Mecanismo de medición.',
                    'objetivo.required'=>'Ingrese el objetivo del indicador.',
                    'unidad.required'=>'Ingrese la unidad del indicador.',
                    'parametro1.required'=>'Ingresar el parámetro 1.',
                    'personal_id.numeric'=>'número.',
                    'personal_id.min'=>'Seleccione al responsable de la medición del indicador.',
                    'proceso_id.numeric'=>'número.',
                    'proceso_id.min'=>'Seleccione un proceso.',
                    'formula_id.numeric'=>'número.',
                    'formula_id.min'=>'Seleccione un tipo de fórmula.',
                    'tabla1.numeric'=>'número.',
                    'tabla1.min'=>'Seleccione la tabla para trabajar con el parámetro 1.',
                    'tabla2.numeric'=>'número.',
                    'tabla2.min'=>'Seleccione la tabla para trabajar con el parámetro 2.',
                    'parametro2.required'=>'Ingresar el parámetro 2.',
                ]
            );
        }
        if($request->subproceso_id>0)
            $request->proceso_id = $request->subproceso_id;

        $c1 = 0;
        $c2 = 0;
        $c3 = 0;
        $mensaje = "";
        if($request->campo1>0)
            $c1=$c1+1;
        if($request->campo2>0)
            $c2=$c2+1;
        if($request->campo3>0)
            $c3=$c3+1;
        if($request->condicion1!=null)
            $c1=$c1+1;
        if($request->condicion2!=null)
            $c2=$c2+1;
        if($request->condicion3!=null)
            $c3=$c3+1;

        if($c1==1||$c2==1)
            $mensaje = $mensaje."Parámetro 1: Si desea utilizar una condición, asegúrese de seleccionar el campo e ingresar la condición. ";
        if($c3==1&&$request->formula_id!=3)
            $mensaje = $mensaje."Parámetro 2: Si desea utilizar una condición, asegúrese de seleccionar el campo e ingresar la condición";

        if($mensaje!="")
            return redirect()->route('indicador.create')->with('datos', $mensaje);
        if($request->formula_id==1)
            $formula = "[1-Σ(".$request->parametro1.")/(".$request->parametro2.")]*100%";
        else{
            if($request->formula_id==2)
                $formula = "[Σ(".$request->parametro1.")/Σ(".$request->parametro2.")]*100%";
            else
                $formula = "Σ(".$request->parametro1.")";
        }
        //});

        $indicador= new Indicador();
        $indicador->descripcion=$request->descripcion;
        $indicador->objeto_medicion=$request->objeto_medicion;
        $indicador->mecanismo=$request->mecanismo;
        $indicador->tolerancia=$request->tolerancia;
        $indicador->objetivo=$request->objetivo;
        $indicador->unidad=$request->unidad;
        $indicador->formula=$formula;
        $indicador->formula_id=$request->formula_id;
        $indicador->proceso_id=$request->proceso_id;
        $indicador->personal_id=$request->personal_id;
        $indicador->empresa_id=Auth::user()->Empresa->id;
        $indicador->numerador= $request->parametro1;
        if($request->campo1>0){
            $indicador->campo1_id= $request->campo1;
            $indicador->condicion1= $request->condicion1;
        }
        if($request->campo2>0){
            $indicador->campo2_id= $request->campo2;
            $indicador->condicion2= $request->condicion2;
        }
        $indicador->tabla1_id= $request->tabla1;

        if($request->formula_id!=3){
            $indicador->denominador= $request->parametro2;
            if($request->campo3>0){
                $indicador->campo3_id= $request->campo3;
                $indicador->condicion3= $request->condicion3;
            }
            $indicador->tabla2_id= $request->tabla2;
        }
        $indicador->save();

        $auditoria = new Auditoria();
        $auditoria->tabla = 'INDICADOR';
        $auditoria->accion = 'REGISTRAR';
        $auditoria->terminal = gethostbyname(gethostname());
        $auditoria->user_id = Auth::user()->id;
        $auditoria->nombre = Auth::user()->name;
        $auditoria->despues = json_encode([
            'Indicador' => $request->descripcion,
            'Mecanismo' => $request->mecanismo,
            'Tolerancia' => $request->tolerancia,
            'Objetivo' => $request->objetivo,
            'Unidad' => $request->unidad,
            'Formula' => $request->formula,
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->empresa_id = Auth::user()->Empresa->id;
        $auditoria->save();

        return redirect()->route('indicador.index')->with('datos', '¡Registro guardado con éxito!');
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
        $proceso = Proceso::where('empresa_id','=',Auth::user()->Empresa->id)->where('proceso_id','=',null)->get();
        $personal = User::role('supervisor')->where('empresa_id','=',Auth::user()->Empresa->id)->get();
        $formula = Formula::get();
        $tabla = Tabla::get();
        $indicador=Indicador::findOrFail($id);
        //return $indicador->formulaa;
        return view('indicadores.edit',compact('proceso','personal','formula','tabla','indicador'));
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
