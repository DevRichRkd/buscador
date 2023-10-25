@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1>{{__('crear').' '.__('Consultas')}}</h1>
        <div class="row">  
            @if($perm['R'])            
                <div class="col-md-12">
                    <form class="forms-sample" action="{{ url('consultas') }}" method="POST" role="form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Nivel')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="nivel" id="nivel" class="form-control" >
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($niveles as $nivel => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'nivel'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Institución de pertenencia')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="pertenencia" id="pertenencia" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($pertenencias as $pertenencia => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'pertenencia'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Institución de procedencia')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="procedencia" id="procedencia" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($procedencias as $procedencia => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'procedencia'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Tema')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="tema" id="tema" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($temas as $tema => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'tema'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('País')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="pais" id="pais" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($paises as $pais => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'pais'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Año de publicación')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="ejercicio" id="ejercicio" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($ejercicios as $ejercicio => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'ejercicio'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Título')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="1500" class="form-control @error('titulo') is-invalid @else @if(old('titulo')) is-valid @endif @enderror" name="titulo" id="titulo" value="{{old('titulo')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'titulo'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Autor')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="1500" class="form-control @error('nombre') is-invalid @else @if(old('nombre')) is-valid @endif @enderror" name="nombre" id="nombre" value="{{old('nombre')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'nombre'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoDescripcion')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea id="descripcion" maxlength="5000" class="form-control @error('descripcion') is-invalid @else @if(old('descripcion')) is-valid @endif @enderror" name="descripcion">{{old('descripcion')}} </textarea>

                                        @include('layouts.partials.errorCampos',['campo' => 'descripcion'])

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Palabras clave')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="1500" class="form-control @error('palabras') is-invalid @else @if(old('palabras')) is-valid @endif @enderror" name="palabras" id="palabras" value="{{old('palabras')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'palabras'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Word')}}
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="file" class="form-control" name="word" accept="application/msword">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'word'])
                                    </div>

                                </div>
                            </div>
                        </div-->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Pdf')}}
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="file" class="form-control" name="pdf" accept="application/pdf">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'pdf'])
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9 offset-3">
                                <div class="form-check form-check-flat form-check-primary">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="estatus" value="1" checked="checked">
                                        {{__("campoActivo")}}
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-right pr-3 ">
                                    <a href="{{ url('consultas') }}" class="btn bg-secondary lighten-1  z-depth-3 text-light">
                                        {{__('cancelar')}}
                                    </a>
                                </div>      
                                <div class="float-right pr-3">
                                     <input type="submit" value="{{__('guardar')}}" class="btn bg-primary mr-2 text-light">
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            @else
                @include("layouts.partials.sinPermisos")
            @endif
        </div>
    </div>
</div>
@endsection

@section('script-custom')
<script>
$('#nombre, #descripcion').maxlength({
    alwaysShow: true,
    threshold: 10,
    warningClass: "badge mt-1 badge-success",
    limitReachedClass: "badge mt-1 badge-danger",
    separator: ' {{__('de')}} ',
    preText: '{{__('teQueda')}} ',
    postText: ' {{__('caracteres')}}.',
    validate: true
  });
</script>
@endsection