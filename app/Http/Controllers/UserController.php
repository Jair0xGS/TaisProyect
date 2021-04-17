<?php

namespace App\Http\Controllers;

use App\Area;
use App\Personal;
use App\Puesto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const PAGINACION=8;
    public function index()
    {
        $empresa = Auth::user()->Empresa;
        $personal = Personal::where('empresa_id','=',$empresa->id)->paginate($this::PAGINACION);
        return view('usuarios.index', compact('personal', 'empresa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.register');
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
            'nombres'=>'required',
            'apellidos'=>'required',
            'telefono'=>'required|max:999999999|numeric',
            'correo'=>'required|email',
            'puesto_id'=>'required',
        ],
            [
                'nombres.required'=>'Ingrese el nombre del personal.',
                'apellidos.required'=>'Ingrese los apellidos del personal.',
                'telefono.required'=>'Ingrese un número de teléfono.',
                'telefono.max'=>'No sobrepase los 9 caracteres para el teléfono.',
                'telefono.numeric'=>'Todos los caracteres deben ser numéricos.',
                'correo.required'=>'Ingrese un email.',
                'correo.email'=>'Ingresar correo con estructura válida.',
                'puesto_id.required'=>'Seleccione un puesto.',
            ]
        );

        // DB::transaction(function ($request) {

        $personal= new Personal();
        $personal->nombres=$request->nombres;
        $personal->apellidos=$request->apellidos;
        $personal->telefono=$request->telefono;
        $personal->correo=$request->correo;
        $personal->empresa_id=Auth::user()->Empresa->id;
        $personal->puesto_id=$request->puesto_id;
        $personal->save();

        $puesto = Puesto::findOrFail($request->puesto_id);

        $auditoria = new Auditoria();
        $auditoria->tabla = 'PERSONAL';
        $auditoria->accion = 'REGISTRAR';
        $auditoria->terminal = gethostbyname(gethostname());
        $auditoria->user_id = Auth::user()->id;
        $auditoria->nombre = Auth::user()->name;
        $auditoria->despues = json_encode([
            'Nombres' => $request->nombres,
            'Apellidos' => $request->apellidos,
            'Telefono' => $request->telefono,
            'Correo' => $request->correo,
            'Puesto' => $puesto->nombre,
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->empresa_id = Auth::user()->Empresa->id;
        $auditoria->save();

        $user = new User();
        $user->name = $request->ruc."_user";
        $user->email= "user_".$request->correo;
        $user->password= \Illuminate\Support\Facades\Hash::make("password");
        $user->empresa_id= Auth::user()->Empresa->id;
        $user->assignRole('user');
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
            'Rol' => 'user',
            'Empresa' => $user->empresa_id
        ], JSON_UNESCAPED_UNICODE);
        $auditoriaU->empresa_id = $user->empresa_id;
        $auditoriaU->save();

        return redirect()->route('user.index')->with('datos', '¡Registro nuevo guardado!');
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
        $personal=Personal::findOrFail($id);
        return view('usuarios.edit', compact('personal'));
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
            'nombres'=>'required',
            'apellidos'=>'required',
            'telefono'=>'required|max:999999999|numeric',
            'correo'=>'required|email',
        ],
            [
                'nombres.required'=>'Ingrese el nombre del personal.',
                'apellidos.required'=>'Ingrese los apellidos del personal.',
                'telefono.required'=>'Ingrese un número de teléfono.',
                'telefono.max'=>'No sobrepase los 9 caracteres para el teléfono.',
                'telefono.numeric'=>'Todos los caracteres deben ser numéricos.',
                'correo.required'=>'Ingrese un email.',
                'correo.email'=>'Ingresar correo con estructura válida.',
            ]
        );

        // DB::transaction(function ($request) {
        $personalAntes=Personal::findOrFail($id);
        $personal=Personal::findOrFail($id);
        $personal->nombres=$request->nombres;
        $personal->apellidos=$request->apellidos;
        $personal->telefono=$request->telefono;
        $personal->correo=$request->correo;
        if($request->puesto_id !=null)
            $personal->puesto_id=$request->puesto_id;
        $personal->save();

        $auditoria = new Auditoria();
        $auditoria->tabla = 'PERSONAL';
        $auditoria->accion = 'ACTUALIZAR';
        $auditoria->terminal = gethostbyname(gethostname());
        $auditoria->user_id = Auth::user()->id;
        $auditoria->nombre = Auth::user()->name;
        $auditoria->despues = json_encode([
            'Nombres' => $request->nombres,
            'Apellidos' => $request->apellidos,
            'Telefono' => $request->telefono,
            'Correo' => $request->correo,
            'Direccion' => $request->direccion,
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->empresa_id = Auth::user()->Empresa->id;
        $auditoria->save();
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
