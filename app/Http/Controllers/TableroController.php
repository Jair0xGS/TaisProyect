<?php

namespace App\Http\Controllers;

use App\Auditoria;
use App\Campos;
use App\Incidencia;
use App\Indicador;
use App\Tablero;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TableroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $indicador = Indicador::findOrFail($request->indicador);
        $dbNum = DB::table($indicador->tabla1->nombre)->where("empresa_id",Auth::user()->empresa_id);
        //check if denominador es cero

        //obtener condicion si campo 1 no es nulo
        if ($indicador->campo1_id !=null){

            $dbNum = $dbNum->where(Campos::findOrFail($indicador->campo1_id)->nombre,$indicador->condicion1);
        }
        //obtener condicion si campo 2 no es nulo
        if ($indicador->campo1_id !=null){
            $dbNum = $dbNum->where(Campos::findOrFail($indicador->campo2_id)->nombre,$indicador->condicion2);
        }
        //obtener los registros
        $numeradores = $dbNum->get();

       //return $numeradores->groupBy(function($d){
       //     return Carbon::parse($d->created_at)->format('y');
       // });;
        $denominadores= collect();
        if ($indicador->denominador != null){
            $dbDen = DB::table($indicador->tabla2->nombre)->where("empresa_id",Auth::user()->empresa_id);
            //check if denominador es cero

            //obtener condicion si campo 1 no es nulo
            if ($indicador->campo3_id !=null){
                $dbDen = $dbDen->where(Campos::findOrFail($indicador->campo3_id)->nombre,$indicador->condicion3);
            }
            //obtener los registros
            $denominadores = $dbDen->get();
        }

        $data = $indicador->tableros;

        foreach ($data as $elem){
            //obtener separacion por fechas de acuerdo al tipo de frecuencia

            //obtener frecuencia
            $tipoFrecuencia = "";
            if ($elem->frecuencia == "Mensual"){
                $tipoFrecuencia="Y-m";
            }else{
                $tipoFrecuencia="Y";
            }

            $grupoNumerador = $numeradores->groupBy(function($d) use ($tipoFrecuencia){
                return Carbon::parse($d->created_at)->format($tipoFrecuencia);
            });
            switch ($indicador->formula_id){
                case 1:
                    $grupoDenominador = $denominadores->groupBy(function($d) use ($tipoFrecuencia){
                        return Carbon::parse($d->created_at)->format($tipoFrecuencia);
                    });

                    //obtener array con numerode items por fecha
                    $numeradorCount = collect();
                    $keysD = $grupoDenominador->keys();

                    foreach ($keysD as $key){
                        if($grupoNumerador->get($key) == null){
                            $nc = 0;
                        }else{
                            $nc = $grupoNumerador->get($key)->count();
                            $dc = $grupoDenominador->get($key)->count();
                        }

                        $res =((1-  ($nc/$dc))*100);
                        $color= "";
                        switch ($elem->verde_operador){
                            case ">":
                                if ( $res > $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res > $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }
                                }

                                break;
                            case ">=":
                                if ( $res >= $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res >= $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }
                                }


                                break;
                            case "<":
                                if ( $res < $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res < $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }
                                }


                                break;
                            case "<=":
                                if ( $res <= $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res <= $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }

                                }

                                break;
                        }
                        $numeradorCount->push([ 'fecha' =>$key,'numero' => $res ,"color"=> $color] );
                    }
                    $elem->semaforo= $numeradorCount;
                    break;
                case 2:
                    $grupoDenominador = $denominadores->groupBy(function($d) use ($tipoFrecuencia){
                        return Carbon::parse($d->created_at)->format($tipoFrecuencia);
                    });

                    //obtener array con numerode items por fecha
                    $numeradorCount = collect();
                    $keysD = $grupoDenominador->keys();
                    foreach ($keysD as $key){
                        if($grupoNumerador->get($key) == null){
                            $nc = 0;
                        }else{
                            $nc = $grupoNumerador->get($key)->count();
                            $dc = $grupoDenominador->get($key)->count();
                        }
                        $res =(($nc/$dc)*100);
                        $color= "";
                        switch ($elem->verde_operador){
                            case ">":
                                if ( $res > $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res > $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }
                                }

                                break;
                            case ">=":
                                if ( $res >= $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res >= $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }
                                }


                                break;
                            case "<":
                                if ( $res < $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res < $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }
                                }


                                break;
                            case "<=":
                                if ( $res <= $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res <= $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }

                                }

                                break;
                        }
                        $numeradorCount->push([ 'fecha' =>$key,'numero' => $res ,"color"=> $color] );
                    }
                    $elem->semaforo= $numeradorCount;
                    break;
                case 3:
                        //obtener array con numerode items por fecha
                    $numeradorCount = collect();
                    $keys = $grupoNumerador->keys();
                    foreach ($keys as $key){
                        $nc = $grupoNumerador->get($key)->count();
                        $res = $nc;
                        $color= "";
                        switch ($elem->verde_operador){
                            case ">":
                                if ( $res > $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res > $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }
                                }

                                break;
                            case ">=":
                                if ( $res >= $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res >= $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }
                                }


                                break;
                            case "<":
                                if ( $res < $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res < $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }
                                }


                                break;
                            case "<=":
                                if ( $res <= $elem->verde){
                                    $color= "bg-success";
                                }else{
                                    if ($res <= $elem->amarillo){
                                        $color= "bg-warning";
                                    }else{

                                        $color= "bg-danger";
                                    }

                                }

                                break;
                        }
                        $numeradorCount->push([ 'fecha' =>$key,'numero' => $nc ,"color"=> $color] );
                    }
                    $elem->semaforo= $numeradorCount;


            }

        }

        return view("tablero.index",compact("data","indicador"));
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $incidencia = Indicador::findOrFail($request->indicador);

        return view("tablero.register",compact("incidencia"));
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
                'frecuencia'=>'required',
                'iniciativas'=>'required',
                'verde'=>'required',
                'verde_operador'=>'required',

            ]
        );
        $indicador = Indicador::findOrFail($request->indicador);
        $total = $indicador->tableros->count();
        DB::beginTransaction();
        try {
            $tablero = new Tablero();
            $tablero->frecuencia =$request->frecuencia;
            $tablero->iniciativas =$request->iniciativas;
            $tablero->verde =$request->verde;
            $tablero->verde_operador =$request->verde_operador;

            if ($request->verde_operador == ">"){
                $tablero->amarillo =$request->verde-$indicador->tolerancia;
            }

            if ($request->verde_operador == ">="){
                $tablero->amarillo =$request->verde-$indicador->tolerancia;
            }

            if ($request->verde_operador == "<"){
                $tablero->amarillo =$request->verde+$indicador->tolerancia;
            }

            if ($request->verde_operador == "<="){
                $tablero->amarillo =$request->verde+$indicador->tolerancia;
            }

            $tablero->rojo =0;
            $tablero->indicador_id =$indicador->id;
            $tablero->descripcion  = "Version ".$total;
            $tablero->save();

            $auditoria = new Auditoria();
            $auditoria->tabla ="tablero";
            $auditoria->accion ="crear";
            $auditoria->terminal =$request->ip();
            $auditoria->empresa_id =Auth::user()->empresa_id;
            $auditoria->user_id =Auth::id();
            $auditoria->nombre =Auth::user()->name;
            $auditoria->despues = $tablero->toJson();
            $auditoria->save();
            DB::commit();
        }catch (\Exception $exception ){

            DB::rollBack();
            return redirect()->back()->with("error","fallo al crear el tablero");
        }
        return redirect()->route("tablero.index",[$request->indicador])->with("success","tablero creado correctamente");

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
    public function edit(Request $request,$id)
    {
        $incidencia = Indicador::findOrFail($request->indicador);
        $data = Tablero::findOrFail($request->tablero);
        return view("tablero.edit",compact("incidencia","data"));
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
                'frecuencia'=>'required',
                'iniciativas'=>'required',
                'verde'=>'required',
                'verde_operador'=>'required',

            ]
        );
        DB::beginTransaction();
        try {
            $tablero = Tablero::findOrFail($request->tablero);
            $tablero->frecuencia =$request->frecuencia;
            $tablero->iniciativas =$request->iniciativas;
            $tablero->verde =$request->verde;
            $tablero->verde_operador =$request->verde_operador;
            $tablero->save();

            $auditoria = new Auditoria();
            $auditoria->tabla ="tablero";
            $auditoria->accion ="editar";
            $auditoria->terminal =$request->ip();
            $auditoria->empresa_id =Auth::user()->empresa_id;
            $auditoria->user_id =Auth::id();
            $auditoria->nombre =Auth::user()->name;
            $auditoria->despues = $tablero->toJson();
            $auditoria->save();
            DB::commit();
        }catch (\Exception $exception ){

            DB::rollBack();
            return redirect()->back()->with("error","fallo al editar el tablero");
        }
        return redirect()->route("tablero.index",[$request->indicador])->with("success","tablero editado correctamente");

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
