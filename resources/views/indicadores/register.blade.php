@role('admin')
@extends('layouts.plantilla')

@section('contenido')

    <div class="row justify-content-center ">
        <div class="color-titulo m-5" style="font-size: 30px">
            <i class="fas fa-layer-group"></i>
            <span class="font-weight-bold ml-3" > REGISTRAR INDICADOR</span>
        </div><br><br><br>

    </div>
    <div class="m-5">
        <form method="POST" action="{{route('indicador.store')}}" class="m-5">
            @csrf
            <div class="row m-3 mb-5">
                <h6 class="ml-4">Complete los campos requeridos:</h6><br><br>
                <div class="col-12 row">
                    <div class="form-group{{ $errors->has('descripcion') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Denominación</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control form-control-alternative{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" placeholder="RUC" value="{{old('descripcion')}}" >

                        @if ($errors->has('descripcion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('descripcion') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('proceso_id') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Proceso</label>
                        <select class="custom-select form-control-alternative{{ $errors->has('proceso_id') ? ' is-invalid' : '' }}"  name="proceso_id" id="proceso_id" onchange="mostrarDepartamento()">
                            <option value="0" selected>- Seleccione un proceso -</option>
                            @foreach($proceso as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('proceso_id'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('proceso_id') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('subproceso_id') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Subroceso <span class="text-main">(opcional)</span></label>
                        <select class="custom-select form-control-alternative{{ $errors->has('subproceso_id') ? ' is-invalid' : '' }}"  name="subproceso_id" id="subproceso_id" onchange="mostrarDepartamento()">
                            <option value="0" selected>- Seleccione un subproceso -</option>
                            @foreach($proceso as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group{{ $errors->has('objeto_medicion') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Objeto de medición</label>
                        <textarea rows="3" type="text" name="objeto_medicion" id="objeto_medicion" class="form-control form-control-alternative{{ $errors->has('objeto_medicion') ? ' is-invalid' : '' }}" placeholder="Objeto de medición" value="{{old('objeto_medicion')}}"></textarea>

                        @if ($errors->has('objeto_medicion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('objeto_medicion') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('mecanismo') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Mecanismos de medición</label>
                        <textarea rows="3" type="text" name="mecanismo" id="mecanismo" class="form-control form-control-alternative{{ $errors->has('mecanismo') ? ' is-invalid' : '' }}" placeholder="Mecanismo de medición" value="{{old('mecanismo')}}"></textarea>

                        @if ($errors->has('mecanismo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('mecanismo') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('objetivo') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Objetivo</label>
                        <textarea rows="3" type="text" name="objetivo" id="objetivo" class="form-control form-control-alternative{{ $errors->has('objetivo') ? ' is-invalid' : '' }}" placeholder="Objetivo" value="{{old('objetivo')}}"></textarea>

                        @if ($errors->has('objetivo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('objetivo') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('personal_id') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Responsable</label>
                        <select class="custom-select form-control-alternative{{ $errors->has('personal_id') ? ' is-invalid' : '' }}"  name="personal_id" id="personal_id">
                            @foreach($personal as $itm)
                                    <option value="{{ $itm->Personal->id }}">{{ $itm->Personal->nombres }} {{ $itm->Personal->apellidos }} - {{ $itm->Personal->Puesto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group{{ $errors->has('tolerancia') ? ' has-danger' : '' }} col-lg-2 col-md-12">
                        <label class="form-control-label" for="input-current-password">Tolerancia de desviación</label>
                        <input type="text" name="tolerancia" id="tolerancia" class="form-control form-control-alternative{{ $errors->has('tolerancia') ? ' is-invalid' : '' }}" placeholder="Tolerancia" value="{{old('tolerancia')}}" >

                        @if ($errors->has('tolerancia'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('tolerancia') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('unidad') ? ' has-danger' : '' }} col-lg-2 col-md-12">
                        <label class="form-control-label" for="input-current-password">Unidad</label>
                        <input type="text" name="unidad" id="unidad" class="form-control form-control-alternative{{ $errors->has('unidad') ? ' is-invalid' : '' }}" placeholder="Unidad" value="{{old('unidad')}}" >

                        @if ($errors->has('unidad'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('unidad') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('formula_id') ? ' has-danger' : '' }} col-lg-4 col-md-12">
                        <label class="form-control-label" for="input-current-password">Tipo de fórmula <span class="text-main">(observe modelos referenciales)</span></label>
                        <select class="custom-select form-control-alternative{{ $errors->has('formula_id') ? ' is-invalid' : '' }}"  name="formula_id" id="formula_id" onchange="mostrarParametros()">
                            <option value="0" selected>- Seleccione un tipo de formula -</option>
                            @foreach($formula as $item)
                                <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('formula_id'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('formula_id') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <img src="../../img/formulas.jpg" alt="panda" style="width: 100%; position: relative; float: right">
                    </div>
                    <div class="form-group{{ $errors->has('parametro1') ? ' has-danger' : '' }} col-lg-4 col-md-12"><br><br><br>
                        <label class="form-control-label" for="input-current-password">Parámetro 1</label>
                        <input type="text" name="parametro1" id="parametro1" class="form-control form-control-alternative{{ $errors->has('parametro1') ? ' is-invalid' : '' }}" placeholder="Denominación del parámetro 1" value="{{old('parametro1')}}" >

                        @if ($errors->has('parametro1'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('parametro1') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-lg-4 col-md-12"><br><br><br>
                        <label class="form-control-label" for="input-current-password">Parámetro 2</label>
                        <input type="text" name="parametro2" id="parametro2" class="form-control form-control-alternative" placeholder="Denominación del parámetro 2" value="{{old('parametro2')}}" >

                    </div>


                </div>


            </div><br><br><br><br>

            <div class="row">
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

</script>
@endsection
@endrole