<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Auditoria;
use App\Empresa;
use App\Http\Controllers\DB;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const PAGINACION=8;

     public function index(Request $request)
    {
        $buscarpor=$request->get('buscarPor');
        $empresa = Empresa::where('nombre','like','%'.$buscarpor.'%')->paginate($this::PAGINACION);
        return view('empresas.index', compact('empresa','buscarpor'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empresas.register');
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
            'descripcion'=>'required',
            'ruc'=>'required|numeric',
            'nombre'=>'required',
            'telefono'=>'required|max:999999999|numeric',
            'email'=>'required|email',
            'direccion'=>'required'
            ],
            [
                'descripcion.required'=>'Ingrese una descripción.',
                'ruc.required'=>'Ingrese el RUC de la empresa.',
                'ruc.numeric'=>'El RUC solo acepta valores numéricos.',
                'nombre.required'=>'Ingrese el Nombre de la empresa.',
                'telefono.required'=>'Ingrese un número de teléfono.',
                'telefono.max'=>'No sobrepase los 9 caracteres para el teléfono.',
                'telefono.numeric'=>'Todos los caracteres deben ser numéricos.',
                'email.required'=>'Ingrese un email.',
                'email.email'=>'Ingresar correo con estructura válida.',
                'direccion.required'=>'Ingrese una dirección.'
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
            $user->name = $request->ruc."_user";
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresa=Empresa::findOrFail($id);
        return view('empresas.edit', compact('empresa'));
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
            'descripcion'=>'required',
            'ruc'=>'required|numeric',
            'nombre'=>'required',
            'telefono'=>'required|max:999999999|numeric',
            'email'=>'required|email',
            'direccion'=>'required'
        ],
            [
                'descripcion.required'=>'Ingrese una descripción.',
                'ruc.required'=>'Ingrese el RUC de la empresa.',
                'ruc.numeric'=>'El RUC solo acepta valores numéricos.',
                'nombre.required'=>'Ingrese el Nombre de la empresa.',
                'telefono.required'=>'Ingrese un número de teléfono.',
                'telefono.max'=>'No sobrepase los 9 caracteres para el teléfono.',
                'telefono.numeric'=>'Todos los caracteres deben ser numéricos.',
                'email.required'=>'Ingrese un email.',
                'email.email'=>'Ingresar correo con estructura válida.',
                'direccion.required'=>'Ingrese una dirección.'
            ]
        );

        //DB::transaction(function ($request, $id) {

            $empresaAntes=Empresa::findOrFail($id);
            $empresa=Empresa::findOrFail($id);
            $empresa->ruc=$request->ruc;
            $empresa->nombre=$request->nombre;
            $empresa->descripcion=$request->descripcion;
            $empresa->telefono=$request->telefono;
            $empresa->email=$request->email;
            $empresa->direccion=$request->direccion;

            $empresa->save();

            $auditoria = new Auditoria();
            $auditoria->tabla = 'EMPRESA';
            $auditoria->accion = 'ACTUALIZAR';
            $auditoria->terminal = gethostbyname(gethostname());
            $auditoria->user_id = Auth::user()->id;
            $auditoria->nombre = Auth::user()->name;
            $auditoria->antes = json_encode([
                'RUC' => $empresaAntes->ruc,
                'Nombre' => $empresaAntes->nombre,
                'Descripcion' => $empresaAntes->descripcion,
                'Telefono' => $empresaAntes->telefono,
                'Email' => $empresaAntes->email,
                'Direccion' => $empresaAntes->direccion,
            ], JSON_UNESCAPED_UNICODE);
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

            return redirect()->route('empresa.index')->with('datos', '¡Registro actualizado con éxito!');
        //});
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
            $empresaAntes=Empresa::findOrFail($id);

            $auditoria = new Auditoria();
            $auditoria->tabla = 'EMPRESA';
            $auditoria->accion = 'ELIMINAR';
            $auditoria->terminal = gethostbyname(gethostname());
            $auditoria->user_id = Auth::user()->id;
            $auditoria->nombre = Auth::user()->name;
            $auditoria->antes = json_encode([
                'RUC' => $empresaAntes->ruc,
                'Nombre' => $empresaAntes->nombre,
                'Descripcion' => $empresaAntes->descripcion,
                'Telefono' => $empresaAntes->telefono,
                'Email' => $empresaAntes->email,
                'Direccion' => $empresaAntes->direccion,
            ], JSON_UNESCAPED_UNICODE);
            $auditoria->save();
            $auditoria->empresa_id = $empresaAntes->id;

            Empresa::find($id)->forceDelete();
            return redirect()->route('empresa.index')->with('datos', '¡Registro Eliminado!');
        }catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('empresa.index')->with('datos', '¡ERROR: La empresa que quiere eliminar está en uso!');
        }
    }
}
