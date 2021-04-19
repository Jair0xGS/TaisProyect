<?php

namespace App\Http\Controllers;

use App\Area;
use App\Personal;
use App\Auditoria;
use App\Puesto;
use App\User;
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
    const PAGINACION=10;
    public function index(Request $request)
    {
        $empresa = Auth::user()->Empresa;
        $buscarpor=$request->get('buscarPor');

        $personal = Personal::where('empresa_id','=',$empresa->id)->where('apellidos','like','%'.$buscarpor.'%')->paginate($this::PAGINACION);
        return view('usuarios.index', compact('personal', 'buscarpor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $puestos_cubiertos = Personal::join('puestos','puestos.id','=','personals.puesto_id')->get();
        $todos_los_puestos = Puesto::get();

        $puestos_por_cubrir = $todos_los_puestos->except($puestos_cubiertos->modelKeys());
        //$puestosCubiertos = $todos_los_puestos->except($puestos_por_cubrir->modelKeys());

        return view('usuarios.register', compact('puestos_por_cubrir'));
    }
    public function intercambio($id, $id_select){
        $personal1=Personal::findOrFail($id);
        $personal12=Personal::findOrFail($id);
        $personal2=Personal::findOrFail($id_select);
        $personal22=Personal::findOrFail($id_select);

        $personal12->puesto_id=$personal2->puesto_id;
        $personal12->save();
        $personal22->puesto_id=$personal1->puesto_id;
        $personal22->save();

        $auditoria = new Auditoria();
        $auditoria->tabla = 'PERSONAL';
        $auditoria->accion = 'INTERCAMBIO DE PUESTOS';
        $auditoria->terminal = gethostbyname(gethostname());
        $auditoria->user_id = Auth::user()->id;
        $auditoria->nombre = Auth::user()->name;
        $auditoria->antes = json_encode([
            'Personal 1' => $personal1->nombres." ".$personal1->apellidos,
            'Puesto 1' => $personal1->Puesto->nombre,
            'Personal 2' => $personal2->nombres." ".$personal2->apellidos,
            'Puesto 2' =>  $personal2->Puesto->nombre,
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->despues = json_encode([
            'Personal 1' => $personal12->nombres." ".$personal12->apellidos,
            'Puesto 1' => $personal12->Puesto->nombre,
            'Personal 2' => $personal22->nombres." ".$personal22->apellidos,
            'Puesto 2' =>  $personal22->Puesto->nombre,
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->empresa_id = Auth::user()->Empresa->id;
        $auditoria->save();

        return redirect()->route('user.index')->with('datos', '¡Se ha producido un intercambio de puestos exitoso!');
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
    try{
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
        $user->name = $request->nombres;
        $user->email= "user_".$request->correo;
        $user->password= \Illuminate\Support\Facades\Hash::make("password");
        $user->empresa_id= Auth::user()->Empresa->id;
        $user->personal_id= $personal->id;
        if($request->capacitado==null)
            $user->assignRole('user');
        else
            $user->assignRole('supervisor');
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

        }catch (\Illuminate\Database\QueryException $e){
           return redirect()->route('user.create')->with('datos', '¡ERROR: El correo ingresado coincide con uno ya existente!');
        }

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
        $user = User::where('personal_id','=',$id)->first();
        $user->password= \Illuminate\Support\Facades\Hash::make("password");
        $user->save();

        $auditoriaU = new Auditoria();
        $auditoriaU->tabla = 'USER';
        $auditoriaU->accion = 'ACTUALIZAR';
        $auditoriaU->terminal = gethostbyname(gethostname());
        $auditoriaU->user_id = Auth::user()->id;
        $auditoriaU->nombre = Auth::user()->name;
        $auditoriaU->antes = json_encode([
            'Password' => 'No se muestra por protección',
        ], JSON_UNESCAPED_UNICODE);
        $auditoriaU->despues = json_encode([
            'Password' => 'Por defecto (no se muestra por protección)',
        ], JSON_UNESCAPED_UNICODE);
        $auditoriaU->empresa_id = $user->empresa_id;
        $auditoriaU->save();

        return redirect()->route('user.index')->with('datos', '¡Actualización exitosa!');
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
        $puestos_cubiertos = Personal::join('puestos','puestos.id','=','personals.puesto_id')->get();
        $todos_los_puestos = Puesto::get();

        $puestos_por_cubrir = $todos_los_puestos->except($puestos_cubiertos->modelKeys());
        return view('usuarios.edit', compact('personal','puestos_por_cubrir'));
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
        $personalAntes=Personal::findOrFail($id);
        $personal=Personal::findOrFail($id);
        $personal->nombres=$request->nombres;
        $personal->apellidos=$request->apellidos;
        $personal->telefono=$request->telefono;
        $personal->correo=$request->correo;
        $personal->puesto_id=$request->puesto_id;
        $personal->save();

        $auditoria = new Auditoria();
        $auditoria->tabla = 'PERSONAL';
        $auditoria->accion = 'ACTUALIZAR';
        $auditoria->terminal = gethostbyname(gethostname());
        $auditoria->user_id = Auth::user()->id;
        $auditoria->nombre = Auth::user()->name;
        $auditoria->antes = json_encode([
            'Nombres' => $personalAntes->nombres,
            'Apellidos' => $personalAntes->apellidos,
            'Telefono' => $personalAntes->telefono,
            'Correo' => $personalAntes->correo,
            'Puesto' => $personalAntes->Puesto->nombre,
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->despues = json_encode([
            'Nombres' => $request->nombres,
            'Apellidos' => $request->apellidos,
            'Telefono' => $request->telefono,
            'Correo' => $request->correo,
            'Puesto' => $personal->Puesto->nombre,
        ], JSON_UNESCAPED_UNICODE);
        $auditoria->empresa_id = Auth::user()->Empresa->id;
        $auditoria->save();

        return redirect()->route('user.index')->with('datos', '¡Registro actualizado con éxito!');
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
            $personalAntes=Personal::findOrFail($id);
            $personalAntes->puesto_id = null;
            $personalAntes->save();

            $auditoria = new Auditoria();
            $auditoria->tabla = 'PERSONAL';
            $auditoria->accion = 'ELIMINAR';
            $auditoria->terminal = gethostbyname(gethostname());
            $auditoria->user_id = Auth::user()->id;
            $auditoria->nombre = Auth::user()->name;
            $auditoria->antes = json_encode([
                'Nombres' => $personalAntes->nombres,
                'Apellidos' => $personalAntes->apellidos,
                'Telefono' => $personalAntes->telefono,
                'Correo' => $personalAntes->correo,
            ], JSON_UNESCAPED_UNICODE);
            $auditoria->empresa_id = Auth::user()->Empresa->id;
            $auditoria->save();


            Personal::find($id)->delete();
            return redirect()->route('user.index')->with('datos', '¡Registro Eliminado!');
        }catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('user.index')->with('datos', '¡ERROR: El usuario que quiere eliminar está en uso!');
        }
    }
}
