@role('admin')
@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fas fa-layer-group"></i>
            <span class="font-weight-bold ml-3" > EDITAR INDICADOR</span>
        </div>

    </div>
    @if(session('datos'))
        <div class="col-12 mb-3 alert alert-warning alert-dismissible fade show" role="alert" style="position: relative; width:100%">
            <strong>ATENCIÓN</strong> {{session('datos')}}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="m-5">
        <form method="POST" action="{{route('indicador.update',$indicador->id)}}" class="m-5">
            @method('put')
            @csrf
            <div class="row m-3 mb-5">
                <h6 class="ml-4">Edie según convenga:</h6><br><br>
                <div class="col-12 row">
                    <div class="form-group{{ $errors->has('descripcion') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Denominación</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control form-control-alternative{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" placeholder="Nombre" value="{{$indicador->descripcion}}" >

                        @if ($errors->has('descripcion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('descripcion') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('personal_id') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Responsable</label>
                        <select class="custom-select form-control-alternative{{ $errors->has('personal_id') ? ' is-invalid' : '' }}"  name="personal_id" id="personal_id">
                            <option value="{{$indicador->personal->id}}" selected>{{$indicador->personal->nombres}} {{$indicador->personal->apellidos}}</option>
                            @foreach($personal as $itm)
                                <option value="{{ $itm->Personal->id }}">{{ $itm->Personal->nombres }} {{ $itm->Personal->apellidos }} - {{ $itm->Personal->Puesto->nombre }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('personal_id'))
                            <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('personal_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('tolerancia') ? ' has-danger' : '' }} col-lg-2 col-md-12">
                        <label class="form-control-label" for="input-current-password">Tolerancia de desviación</label>
                        <input type="number" name="tolerancia" id="tolerancia" step="0.01"  min="0" max="100" class="form-control form-control-alternative{{ $errors->has('tolerancia') ? ' is-invalid' : '' }}" placeholder="Tolerancia" value="{{$indicador->tolerancia}}" >

                        @if ($errors->has('tolerancia'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('tolerancia') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('unidad') ? ' has-danger' : '' }} col-lg-2 col-md-12">
                        <label class="form-control-label" for="input-current-password">Unidad</label>
                        <input type="text" name="unidad" id="unidad" class="form-control form-control-alternative{{ $errors->has('unidad') ? ' is-invalid' : '' }}" placeholder="Unidad" value="{{$indicador->unidad}}" >

                        @if ($errors->has('unidad'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('unidad') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('objeto_medicion') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Objeto de medición</label>
                        <textarea rows="3" type="text" name="objeto_medicion" id="objeto_medicion" class="form-control form-control-alternative{{ $errors->has('objeto_medicion') ? ' is-invalid' : '' }}" placeholder="Objeto de medición">{{$indicador->objeto_medicion}}</textarea>

                        @if ($errors->has('objeto_medicion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('objeto_medicion') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('mecanismo') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Mecanismos de medición</label>
                        <textarea rows="3" type="text" name="mecanismo" id="mecanismo" class="form-control form-control-alternative{{ $errors->has('mecanismo') ? ' is-invalid' : '' }}" placeholder="Mecanismo de medición">{{$indicador->mecanismo}}</textarea>

                        @if ($errors->has('mecanismo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('mecanismo') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('objetivo') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Objetivo</label>
                        <textarea rows="3" type="text" name="objetivo" id="objetivo" class="form-control form-control-alternative{{ $errors->has('objetivo') ? ' is-invalid' : '' }}" placeholder="Objetivo">{{$indicador->objetivo}}</textarea>

                        @if ($errors->has('objetivo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('objetivo') }}</strong>
                            </span>
                        @endif
                        <br><br>
                    </div>

                    <div class="form-group{{ $errors->has('formula_id') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Tipo de fórmula <span class="text-main">(observe modelos referenciales)</span></label>
                        <select class="custom-select form-control-alternative{{ $errors->has('formula_id') ? ' is-invalid' : '' }}"  name="formula_id" id="formula_id" onchange="mostrarParametros()">
                            <option value="{{$indicador->formula_id}}" selected>{{$indicador->formulaa->descripcion}}</option>
                            @foreach($formula as $item)
                                <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('formula_id'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('formula_id') }}</strong>
                                    </span>
                        @endif <br><br><br><br>
                        <img src="../../img/formulas2.jpg" alt="formula" style="width: 100%; position: relative; float: right">
                    </div>

                    <div class="col-lg-8 col-md-12">
                        <div class="row">
                            <div class="form-group{{ $errors->has('parametro1') ? ' has-danger' : '' }} col-6">
                                <label class="form-control-label" for="input-current-password">Parámetro 1</label>
                                <input type="text" name="parametro1" id="parametro1" class="form-control form-control-alternative{{ $errors->has('parametro1') ? ' is-invalid' : '' }}" placeholder="Denominación del parámetro 1" value="{{old('parametro1')}}" >

                                @if ($errors->has('parametro1'))
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('parametro1') }}</strong>
                            </span>
                                @endif

                            </div>
                            <div class="form-group{{ $errors->has('tabla1') ? ' has-danger' : '' }} col-6">
                                <label class="form-control-label" for="input-current-password">Tabla a considerar</label>
                                <select class="custom-select form-control-alternative{{ $errors->has('tabla1') ? ' is-invalid' : '' }}"  name="tabla1" id="tabla1" onchange="mostrarCampos1()">
                                    <option value="0" selected>- Seleccione una tabla -</option>
                                    @foreach($tabla as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('tabla1'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tabla1') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                <label class="form-control-label" for="input-current-password">Campo a condicionar <span class="text-main">(Opcional)</span></label>
                                <select class="custom-select form-control-alternative"  name="campo1" id="campo1">
                                    <option value="0" selected>- Seleccione un campo -</option>
                                </select>

                            </div>
                            <div class="form-group col-6">
                                <label class="form-control-label" for="input-current-password">Condición <span class="text-main">(Opcional)</span></label>
                                <input type="text" name="condicion1" id="condicion1" class="form-control form-control-alternative" placeholder="Campo 1" value="{{old('condición1')}}" >

                            </div>
                            <div class="form-group col-6">
                                <label class="form-control-label" for="input-current-password">Campo a condicionar <span class="text-main">(Opcional)</span></label>
                                <select class="custom-select form-control-alternative"  name="campo2" id="campo2">
                                    <option value="0" selected>- Seleccione un campo -</option>
                                </select>

                            </div>
                            <div class="form-group col-6">
                                <label class="form-control-label" for="input-current-password">Condición <span class="text-main">(Opcional)</span></label>
                                <input type="text" name="condicion2" id="condicion2" class="form-control form-control-alternative" placeholder="Campo 2" value="{{old('condición2')}}" >
                            </div>

                        </div><br>
                        <hr style="height: 1px">
                        <div class="row" id="parametro">
                            <div class="form-group{{ $errors->has('parametro2') ? ' has-danger' : '' }} col-6">
                                <label class="form-control-label" for="input-current-password">Parámetro 2</label>
                                <input type="text" name="parametro2" id="parametro2" class="form-control form-control-alternative{{ $errors->has('parametro2') ? ' is-invalid' : '' }}" placeholder="Denominación del parámetro 2" value="{{old('parametro2')}}" >

                                @if ($errors->has('parametro2'))
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('parametro2') }}</strong>
                            </span>
                                @endif

                            </div>
                            <div class="form-group{{ $errors->has('tabla2') ? ' has-danger' : '' }} col-6">
                                <label class="form-control-label" for="input-current-password">Tabla a considerar</label>
                                <select class="custom-select form-control-alternative{{ $errors->has('tabla2') ? ' is-invalid' : '' }}"  name="tabla2" id="tabla2" onchange="mostrarCampos2()">
                                    <option value="0" selected>- Seleccione una tabla -</option>
                                    @foreach($tabla as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('tabla2'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tabla2') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                <label class="form-control-label" for="input-current-password">Campo a condicionar <span class="text-main">(Opcional)</span></label>
                                <select class="custom-select form-control-alternative"  name="campo3" id="campo3">
                                    <option value="0" selected>- Seleccione un campo -</option>
                                </select>

                            </div>
                            <div class="form-group col-6">
                                <label class="form-control-label" for="input-current-password">Condición <span class="text-main">(Opcional)</span></label>
                                <input type="text" name="condicion3" id="condicion3" class="form-control form-control-alternative" placeholder="Campo" value="{{old('condición3')}}" >

                            </div>
                        </div>


                    </div>


                </div><br><br><br><br>
            </div>
            <div class="row m-3">
                <div class="col-md-10 col-sm-12">
                    <a href="{{URL::to('/indicador')}}">
                        <i class="fas fa-link color-icono icono"></i>
                        <span class="ml-2" >MOSTRAR MATRIZ DE INDICADORES</span>
                    </a>
                </div>

                <div class="col-md-2 col-sm-6 mb-2">
                    <button type="submit" class="btn btn-block font-weight-bold btn-main">
                        REGISTRAR
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function(){
            $('#proceso_id').change(function(){
                mostrarSubproceso();
            });
            $('#formula_id').change(function(){
                mostrarParametros();
            });
            $('#tabla1').change(function(){
                mostrarCampos1();
            });
            $('#tabla2').change(function(){
                mostrarCampos2();
            });
        });
        function mostrarSubproceso(){
            idProceso=$("#proceso_id").val();
            $.get('/ObtenerSubproceso/'+idProceso, function(data){

                var x = document.getElementById("subproceso_id");
                for (let i = x.options.length; i > 0; i--) {
                    x.remove(i);
                }
                var option = document.createElement("option");
                data.forEach(element => {

                    var option=document.createElement("option");
                    option.value= element.id;
                    option.text= element.nombre;
                    x.appendChild(option)
                });
            });
        }
        function mostrarParametros(){
            idFormula=$("#formula_id").val();
            $('#parametro').removeClass("d-none").addClass("parametro");
            $('#tolerancia').attr('step', 0.01);

            if(idFormula ==3) {
                $('#parametro').removeClass("parametro").addClass("d-none");
                $('#tolerancia').removeAttr('max');
            }
        }
        function mostrarCampos1(){
            idTable=$("#tabla1").val();
            $.get('/ObtenerCampos1/'+idTable, function(data){

                var x = document.getElementById("campo1");
                var y = document.getElementById("campo2");
                for (let i = x.options.length; i > 0; i--) {
                    x.remove(i);
                    y.remove(i);
                }
                var option = document.createElement("option");
                data.forEach(element => {

                    var option=document.createElement("option");
                    option.value= element.id;
                    option.text= element.nombre;
                    x.appendChild(option);
                });
                var option2 = document.createElement("option");
                data.forEach(element => {

                    var option2=document.createElement("option");
                    option2.value= element.id;
                    option2.text= element.nombre;
                    y.appendChild(option2);
                });
            });
        }
        function mostrarCampos2(){
            idTable=$("#tabla2").val();
            $.get('/ObtenerCampos2/'+idTable, function(data){

                var x = document.getElementById("campo3");
                for (let i = x.options.length; i > 0; i--) {
                    x.remove(i);
                }
                var option = document.createElement("option");
                data.forEach(element => {

                    var option=document.createElement("option");
                    option.value= element.id;
                    option.text= element.nombre;
                    x.appendChild(option)
                });
            });
        }

    </script>
@endsection
@endrole
