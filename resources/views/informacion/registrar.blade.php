@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1>{{__('crear').' '.__('Informacion')}}</h1>
        <div class="row">  
            @if($perm['R'])            
                <div class="col-md-12">
                    <form class="forms-sample" action="{{ url('informacion') }}" method="POST" role="form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Tipo de expediente')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="expediente" id="expediente" class="form-control" >
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($expedientes as $expediente => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'expediente'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Rubro')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="1500" class="form-control @error('rubro') is-invalid @else @if(old('rubro')) is-valid @endif @enderror" name="rubro" id="rubro" value="{{old('rubro')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'rubro'])
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Clave de control')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="1500" class="form-control @error('clave') is-invalid @else @if(old('clave')) is-valid @endif @enderror" name="clave" id="clave" value="{{old('clave')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'clave'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Año')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="anio" id="anio" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($anios as $anio => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'anio'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Entidad federativa')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="entidad" id="entidad" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($entidades as $entidad => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'entidad'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Organismo garante')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="organismo" id="organismo" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'organismo'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Materia')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="materia" id="materia" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($materias as $materia => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'materia'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Vínculo electrónico para descarga del documento')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="1500" class="form-control @error('vinculo') is-invalid @else @if(old('vinculo')) is-valid @endif @enderror" name="vinculo" id="vinculo" value="{{old('vinculo')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'vinculo'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Desde aqui empiezan los campos para CRITERIOS-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Presedentes')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="1500" class="form-control @error('presedentes') is-invalid @else @if(old('presedentes')) is-valid @endif @enderror" name="presedentes" id="presedentes" value="{{old('presedentes')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'presedentes'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Tipo de criterio')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="criterio" id="criterio" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($criterios as $criterio => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'criterio'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Epoca del criterio')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="epoca" id="epoca" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($epocas as $epoca => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'epoca'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Tipo de criterio')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="criterio_seccion" id="criterio_seccion" class="form-control">
                                            <option value="0">-- Seleccione --</option>
                                            @foreach($criterios_secciones as $criterio_seccion => $valor)
                                            <option value="{{$valor->id}}">{{$valor->nombre}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'criterio_seccion'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Aqui terminan los campos para CRITERIOS-->
                        <!--Desde aqui empiezan los campos para RESOLUCIONES-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Solicitud')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="1500" class="form-control @error('solicitud') is-invalid @else @if(old('solicitud')) is-valid @endif @enderror" name="solicitud" id="solicitud" value="{{old('solicitud')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'solicitud'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Respuesta')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="1500" class="form-control @error('respuesta') is-invalid @else @if(old('respuesta')) is-valid @endif @enderror" name="respuesta" id="respuesta" value="{{old('respuesta')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'respuesta'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Agravio')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="1500" class="form-control @error('agravio') is-invalid @else @if(old('agravio')) is-valid @endif @enderror" name="agravio" id="agravio" value="{{old('agravio')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'agravio'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Relevancia de la Resolución')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="1500" class="form-control @error('relevancia') is-invalid @else @if(old('relevancia')) is-valid @endif @enderror" name="relevancia" id="relevancia" value="{{old('relevancia')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'relevancia'])
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
                                    <a href="{{ url('informacion') }}" class="btn bg-secondary lighten-1  z-depth-3 text-light">
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
    $(document).ready(function(){
        $("#entidad").change(function(){
            var categoria = $(this).val();
            $.get('/organismosByentidad/'+categoria, function(data){
                console.log(data);
                $('#organismo').empty();
                    for(i = 0; i < data.length; i++){
                        $('#organismo').append('<option value="'+ data[i].id +'">'+ data[i].nombre +'</option>');
                    }
            });
        });
  });
</script>
@endsection