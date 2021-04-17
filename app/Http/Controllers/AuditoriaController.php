<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auditoria;
use Illuminate\Support\Facades\Auth;

class AuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const PAGINACION = 10;
    public function index(Request $request)
    {
        $buscarpor=$request->get('buscarPor');
        $inicio=$request->get('dateInicio');
        $fin=$request->get('dateFin');
        $error = 0;
        if($inicio>$fin){
            return redirect()->route('auditoria.index')->with('mensaje', '¡Rango de fechas no válido!');
        }
        if($inicio ==null)
        {
            $primerRegistro = Auditoria::orderBy('created_at', 'asc')->first();
            if($primerRegistro!=null)
                $inicio = date("Y-m-d", strtotime($primerRegistro->created_at));
            else
                $inicio = date("Y-m-d");
        }
        if($fin == null)
        {
            $ultimoRegistro = Auditoria::orderBy('created_at', 'desc')->first();
            if($ultimoRegistro!=null)
                $fin = date("Y-m-d", strtotime($ultimoRegistro->created_at));
            else
                $inicio = date("Y-m-d");
        }

        $auditoria= Auditoria::where('nombre','like','%'.$buscarpor.'%')->where('created_at','>=',$inicio)->where('created_at','<=',date("Y-m-d",strtotime($fin."+ 1 days")))->orderBy('id', 'desc')->paginate($this::PAGINACION);

        return view('auditorias.general', compact('auditoria','buscarpor','inicio', 'fin'));

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$empresa_id)
    {
        $buscarpor=$request->get('buscarPor');
        $inicio=$request->get('dateInicio');
        $fin=$request->get('dateFin');
        $error = 0;
        if($inicio>$fin){
            return redirect()->route('auditoria.show',$empresa_id)->with('mensaje', '¡Rango de fechas no válido!');
        }
        if($inicio ==null)
        {
            $primerRegistro = Auditoria::where('empresa_id','=',$empresa_id)->orderBy('created_at', 'asc')->first();
            if($primerRegistro!=null)
                $inicio = date("Y-m-d", strtotime($primerRegistro->created_at));
            else
                $inicio = date("Y-m-d");
        }
        if($fin == null)
        {
            $ultimoRegistro = Auditoria::where('empresa_id','=',$empresa_id)->orderBy('created_at', 'desc')->first();
            if($ultimoRegistro!=null)
                $fin = date("Y-m-d", strtotime($ultimoRegistro->created_at));
            else
                $fin = date("Y-m-d");
        }

        $auditoria= Auditoria::where('nombre','like','%'.$buscarpor.'%')->where('created_at','>=',$inicio)->where('created_at','<=',date("Y-m-d",strtotime($fin."+ 1 days")))
            ->where('empresa_id','=',$empresa_id)->orderBy('id', 'desc')->paginate($this::PAGINACION);

        return view('auditorias.particular', compact('auditoria','buscarpor','inicio', 'fin'));
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
