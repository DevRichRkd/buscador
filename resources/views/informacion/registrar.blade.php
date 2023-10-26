@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1>{{__('crear').' '.__('Informacion')}}</h1>
        <div class="row">  
            @if($perm['R'])            
                <div class="col-md-12">
                    <form class="forms-sample" action="{{ url('informacion') }}" method="POST" role="form" id="registerForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card">
                            <div class="card-body">
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
                                                <input type="text" maxlength="1500" class="form-control" name="rubro" id="rubro" value="">
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
                                                <input type="text" maxlength="1500" class="form-control" name="palabras" id="palabras" value="">
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
                                                <input type="text" maxlength="1500" class="form-control" name="clave" id="clave" value="">
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
                                                <input type="text" maxlength="1500" class="form-control" name="vinculo" id="vinculo" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Desde aqui empiezan los campos para CRITERIOS-->
                        <div class="card hide" id="card_criterios">
                            <div class="card-body">
                                <h5 class="card-title">Campos exclusivos para los Criterios de interpretación</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">
                                                {{__('Presedentes')}}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" maxlength="1500" class="form-control" name="presedentes" id="presedentes" value="">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Aqui terminan los campos para CRITERIOS-->
                        <!--Desde aqui empiezan los campos para RESOLUCIONES-->
                        <div class="card hide" id="card_resoluciones">
                            <div class="card-body">
                                <h5 class="card-title">Campos exclusivos para las resoluciones relevantes</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">
                                                {{__('Solicitud')}}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" maxlength="1500" class="form-control" name="solicitud" id="solicitud" value="">
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
                                                <input type="text" maxlength="1500" class="form-control" name="respuesta" id="respuesta" value="">
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
                                                <input type="text" maxlength="1500" class="form-control" name="agravio" id="agravio" value="">
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
                                                <input type="text" maxlength="1500" class="form-control" name="relevancia" id="relevancia" value="">
                                            </div>
                                        </div>
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

        $("#expediente").change(function(){
            var idExpediente = $(this).val();
            console.log(idExpediente);
            if(idExpediente == 1){
                $('#card_criterios').removeClass("hide");
                $('#card_criterios').addClass("show");

                $('#card_resoluciones').removeClass("show");
                $('#card_resoluciones').addClass("hide");
            } else {
                if(idExpediente == 2){
                $('#card_criterios').removeClass("show");
                $('#card_criterios').addClass("hide");

                $('#card_resoluciones').removeClass("hide");
                $('#card_resoluciones').addClass("show");
            }
            }
        });

        $("#registerForm").validate({
            rules: {
                expediente : {
                    min:1
                },
                rubro: {
                    required: true
                },
                palabras: {
                    required: true
                },
                clave: {
                    required: true
                },
                anio : {
                    min:1
                },
                entidad : {
                    min:1
                },
                materia : {
                    min:1
                },
                vinculo: {
                    required: true
                },
                presedentes: {
                    required: true
                },
                criterio : {
                    min:1
                },
                epoca : {
                    min:1
                },
                criterio_seccion : {
                    min:1
                },
                solicitud: {
                    required: true
                },
                respuesta: {
                    required: true
                },
                agravio: {
                    required: true
                },
                relevancia: {
                    required: true
                },
            },
            messages : {
                expediente: {
                    min: "*El campo Expediente es requerido"
                },
                rubro: {
                    required: "*El campo Rubro es requerido"
                },
                palabras: {
                    required: "*El campo Palabras Clave es requerido"
                },
                clave: {
                    required: "*El campo Clave de Control es requerido"
                },
                anio : {
                    min:"*El campo Año es requerido"
                },
                entidad : {
                    min:"*El campo Entidad Federativa esrequerido"
                },
                materia : {
                    min:"*El campo Materia esrequerido"
                },
                vinculo: {
                    required: "*El campo Vinculo Electronico es requerido"
                },
                presedentes: {
                    required: "*El campo Presedentes es requerido"
                },
                criterio : {
                    min:"*El campo Tipo de Criterio es requerido"
                },
                epoca : {
                    min:"*El campo Epoca es requerido"
                },
                criterio_seccion : {
                    min:"*El campo Tipo de Criterio es requerido"
                },
                solicitud: {
                    required: "*El campo Solicitud es requerido"
                },
                respuesta: {
                    required: "*El campo Respuesta es requerido"
                },
                agravio: {
                    required: "*El campo Agravio es requerido"
                },
                relevancia: {
                    required: "*El campo Relevancia de la Resolucion es requerido"
                },
            }
        });
        
  });
</script>
@endsection