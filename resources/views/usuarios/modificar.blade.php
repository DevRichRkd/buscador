@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1>{{__('editar').' '.__('usuarioTitulo')}}</h1>
        <div class="row">  
            @if($perm['R'])            
                <div class="col-md-12">
                    <form  class="col-sm-12" action="{{ route('usuarios.update', $usuario->id) }}" method="POST" role="form" enctype="multipart/form-data">
                                <input type="hidden" class="form-control"  name="_method" value="PUT"></input>
                                    {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoNombre')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="50" class="form-control @error('name') is-invalid @else @if(old('name')) is-valid @endif @enderror" name="name" id="name" value="{{$usuario->name}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'name'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoEmail')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="emailOriginal" id="emailOriginal" value="{{$usuario->email}}">
                                        <input type="text" maxlength="50" class="form-control @error('email') is-invalid @else @if(old('email')) is-valid @endif @enderror" name="email" id="email" value="{{$usuario->email}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'email'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoPassword')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="50" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'password'])
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoConfirmarPassword')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="50" class="form-control" name="password_confirmation" id="password-confirm">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'password-confirm'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-9 offset-3">
                                <div class="form-check form-check-flat form-check-primary">
                                    @php 
                                        $check = ($usuario->estatus == 1) ? 'checked="checked"' : '' ;
                                    @endphp
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="estatus" value="1" {{$check}}>
                                        {{__("campoActivo")}}
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h2> {{__('asignarModulos')}} </h2>
                            </div>
                            @php
                                $readonly  = '';
                                if (!$perm['I']) {
                                    $readonly  = 'disabled';
                                }
                            @endphp
                            <div class="col-sm-12 table-responsive" style="margin-top: 20px;">
                                <table class="table table-striped table-bordered " width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th class="text-center">
                                                <b>{{__('modulo')}} </b><br>
                                                <div class="switch">
                                                    <label>
                                                        <input type="checkbox" name="todos" id="todos" {{$readonly}}>
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th class="text-center">
                                                <b> {{__('leer')}} </b><br>
                                                <div class="switch">
                                                    <label>
                                                        <input type="checkbox" name="lectura" id="lectura" {{$readonly}}>
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th class="text-center">
                                                <b> {{__('insertar')}} </b><br>
                                                <div class="switch">
                                                    <label>
                                                        <input type="checkbox" name="insertar" id="insertar" {{$readonly}}>
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th class="text-center">
                                                <b> {{__('actualizar')}} </b><br>
                                                <div class="switch">
                                                    <label>
                                                        <input type="checkbox" name="actualizar" id="actualizar" {{$readonly}}>
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th class="text-center">
                                                <b> {{__('eliminar')}} </b><br>
                                                <div class="switch">
                                                    <label>
                                                         <input type="checkbox" name="eliminar" id="eliminar" {{$readonly}}>
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th class="text-center">
                                                <b> {{__('subirArchivo')}} </b><br>
                                                <div class="switch">
                                                    <label>
                                                         <input type="checkbox" name="subirArchivo" id="subirArchivo" {{$readonly}}>
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th class="text-center">
                                                <b> {{__('descargarArchivo')}} </b><br>
                                                <div class="switch">
                                                    <label>
                                                         <input type="checkbox" name="descargarArchivo" id="descargarArchivo" {{$readonly}}>
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i=0; $i < count($data['rows']); $i++)
                                            @php 
                                                $checkedR  = ($data['rows'][$i]->R == 1) ? 'checked' : '' ;
                                                $checkedI  = ($data['rows'][$i]->I == 1) ? 'checked' : '' ;
                                                $checkedU  = ($data['rows'][$i]->U == 1) ? 'checked' : '' ;
                                                $checkedD  = ($data['rows'][$i]->D == 1) ? 'checked' : '' ;
                                                $checkedSF = ($data['rows'][$i]->SF == 1) ? 'checked' : '' ;
                                                $checkedDF = ($data['rows'][$i]->DF == 1) ? 'checked' : '' ;
                                                $id_recurso = $data['rows'][$i]->id_recursos;
                                                $nombre_recurso = $data['rows'][$i]->nombre;
                                                //echo "recursos ". $id_recurso;
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" onchange="modulo('{{$id_recurso}}')" id="{{$nombre_recurso}}" name="{{$nombre_recurso}}" {{$readonly}} >
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <th class="text-center"  scope="row">{{ $data['rows'][$i]->nombre }}</th>
                                                <td class="text-center" >
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" name="R[]" id="R{{ $id_recurso }}" value="{{ $id_recurso }}" class="input-sm validaCheck" idRecurso="{{ $id_recurso }}" {{ $checkedR }} {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center" >
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" name="I[]" id="I{{ $id_recurso }}" value="{{ $id_recurso }}" class="input-sm" {{ $checkedI }} {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center" >
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" name="U[]" id="U{{$id_recurso }}" value="{{ $id_recurso }}" class="input-sm" {{ $checkedU }} {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center" >
                                                     <div class="switch">
                                                        <label>
                                                           <input type="checkbox" name="D[]" id="D{{ $id_recurso }}" value="{{ $id_recurso }}" class="input-sm" {{ $checkedD }}  {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center" >
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" name="SF[]" id="SF{{ $id_recurso }}" value="{{ $id_recurso }}" class="input-sm" {{ $checkedSF }} {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center" >
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" name="DF[]" id="DF{{ $id_recurso }}" value="{{ $id_recurso }}" class="input-sm" {{ $checkedDF }} {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endfor

                                        @for($i=0; $i < count($faltantes); $i++)
                                            @php 
                                                $id_recurso = $faltantes[$i]->id;
                                                $nombre_recurso = $faltantes[$i]->nombre;
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" onchange="modulo('{{$id_recurso}}')" id="{{$nombre_recurso}}" name="{{$nombre_recurso}}" {{$readonly}} >
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>

                                                </td>
                                                <th class="text-center"  scope="row">{{ $faltantes[$i]->nombre }}</th>
                                                <td class="text-center" >
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" name="R[]" id="R{{ $faltantes[$i]->id }}" value="{{ $faltantes[$i]->id }}" class="input-sm validaCheck" idRecurso="{{ $faltantes[$i]->id }}" {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center" >
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" name="I[]" id="I{{ $faltantes[$i]->id }}" value="{{ $faltantes[$i]->id }}" class="input-sm" {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center" >
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" name="U[]" id="U{{$faltantes[$i]->id }}" value="{{ $faltantes[$i]->id }}" class="input-sm" {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center" >
                                                     <div class="switch">
                                                        <label>
                                                           <input type="checkbox" name="D[]" id="D{{ $faltantes[$i]->id }}" value="{{ $faltantes[$i]->id }}" class="input-sm"  {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center" >
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" name="SF[]" id="SF{{ $faltantes[$i]->id }}" value="{{ $faltantes[$i]->id }}" class="input-sm" {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center" >
                                                    <div class="switch">
                                                        <label>
                                                            <input type="checkbox" name="DF[]" id="DF{{ $faltantes[$i]->id }}" value="{{ $faltantes[$i]->id }}" class="input-sm"  {{ $readonly }}>
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-right pr-3 ">
                                    <a href="{{ url('usuarios') }}" class="btn bg-secondary lighten-1  z-depth-3 text-light">
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
        $(document).ready(function () {
            $('#insertar').attr( "disabled", "true" );
            $('#actualizar').attr( "disabled", "true" );
            $('#eliminar').attr( "disabled", "true" );
            $('#subirArchivo').attr( "disabled", "true" );
            $('#descargarArchivo').attr( "disabled", "true" );

            var faltantes = <?php print_r(json_encode($faltantes)) ?>;
            $.each(faltantes,function(index, el) {
                console.log(el.id)
                $( "#I"+el.id ).attr( "disabled", "true" );
                $( "#U"+el.id ).attr( "disabled", "true" );
                $( "#D"+el.id ).attr( "disabled", "true" );
                $( "#SF"+el.id ).attr( "disabled", "true" );
                $( "#DF"+el.id ).attr( "disabled", "true" );
            });

            var seleccionados = <?php print_r(json_encode($data['rows'])) ?>;
            $.each(seleccionados,function(index, el) {
                $( "#I"+el.id ).attr( "disabled", "true" );
                $( "#U"+el.id ).attr( "disabled", "true" );
                $( "#D"+el.id ).attr( "disabled", "true" );
                $( "#SF"+el.id ).attr( "disabled", "true" );
                $( "#DF"+el.id ).attr( "disabled", "true" );
            });

            $('#todos').change(function () {
                $('#lectura').prop('checked', $(this).prop("checked"));
                $('#insertar').prop('checked', $(this).prop("checked"));
                $('#actualizar').prop('checked', $(this).prop("checked"));
                $('#eliminar').prop('checked', $(this).prop("checked"));
                $('#subirArchivo').prop('checked', $(this).prop("checked"));
                $('#descargarArchivo').prop('checked', $(this).prop("checked"));

                $("[name='R[]']").prop('checked', $(this).prop("checked"));
                $("[name='I[]']").prop('checked', $(this).prop("checked"));
                $("[name='U[]']").prop('checked', $(this).prop("checked"));
                $("[name='D[]']").prop('checked', $(this).prop("checked"));
                $("[name='SF[]']").prop('checked', $(this).prop("checked"));
                $("[name='DF[]']").prop('checked', $(this).prop("checked"));

                if( $(this).prop('checked') == false) {
                    $('#insertar').attr( "disabled", "true" );
                    $('#actualizar').attr( "disabled", "true" );
                    $('#eliminar').attr( "disabled", "true" );
                    $('#subirArchivo').attr( "disabled", "true" );
                    $('#descargarArchivo').attr( "disabled", "true" );

                    $("[name='I[]']").attr( "disabled", "true" );
                    $("[name='U[]']").attr( "disabled", "true" );
                    $("[name='D[]']").attr( "disabled", "true" );
                    $("[name='SF[]']").attr( "disabled", "true" );
                    $("[name='DF[]']").attr( "disabled", "true" );
                }else{
                    $('#lectura').removeAttr("disabled");
                    $('#insertar').removeAttr("disabled");
                    $('#actualizar').removeAttr("disabled");
                    $('#eliminar').removeAttr("disabled");
                    $('#subirArchivo').removeAttr("disabled");
                    $('#descargarArchivo').removeAttr("disabled");

                    $("[name='I[]']").removeAttr("disabled");
                    $("[name='U[]']").removeAttr("disabled");
                    $("[name='D[]']").removeAttr("disabled");
                    $("[name='SF[]']").removeAttr("disabled");
                    $("[name='DF[]']").removeAttr("disabled");
                }
            });

            $('#lectura').change(function(){
                $("[name='R[]']").prop('checked', $(this).prop("checked"));
                if( $(this).prop('checked') == false) {
                    $('#insertar').attr( "disabled", "true" );
                    $('#actualizar').attr( "disabled", "true" );
                    $('#eliminar').attr( "disabled", "true" );
                    $('#subirArchivo').attr( "disabled", "true" );
                    $('#descargarArchivo').attr( "disabled", "true" );

                    $( "input[name='I[]']" ).attr( "disabled", "true" );
                    $( "input[name='U[]']" ).attr( "disabled", "true" );
                    $( "input[name='D[]']" ).attr( "disabled", "true" );
                    $( "input[name='SF[]']" ).attr( "disabled", "true" );
                    $( "input[name='DF[]']" ).attr( "disabled", "true" );
                }else{
                    $('#insertar').removeAttr("disabled");
                    $('#actualizar').removeAttr("disabled");
                    $('#eliminar').removeAttr("disabled");
                    $('#subirArchivo').removeAttr("disabled");
                    $('#descargarArchivo').removeAttr("disabled");

                    $( "input[name='I[]']" ).removeAttr("disabled");
                    $( "input[name='U[]']" ).removeAttr("disabled");
                    $( "input[name='D[]']" ).removeAttr("disabled");
                    $( "input[name='SF[]']" ).removeAttr("disabled");
                    $( "input[name='DF[]']" ).removeAttr("disabled");
                }
                
            });

            $('#insertar').change(function(){
                $("[name='I[]']").prop('checked', $(this).prop("checked"));
            });

            $('#actualizar').change(function(){
                $("[name='U[]']").prop('checked', $(this).prop("checked"));
            });

            $('#eliminar').change(function(){
                $("[name='D[]']").prop('checked', $(this).prop("checked"));
            });
            $('#subirArchivo').change(function(){
                $("[name='SF[]']").prop('checked', $(this).prop("checked"));
            });
            $('#descargarArchivo').change(function(){
                $("[name='DF[]']").prop('checked', $(this).prop("checked"));
            });

            $('.validaCheck').change(function() {
                var id = $(this).attr("idRecurso");
                if( $(this).prop('checked') == false) {
                    $("#I"+id).prop('checked', false);
                    $("#U"+id).prop('checked', false);
                    $("#D"+id).prop('checked', false);
                    $("#SF"+id).prop('checked', false);
                    $("#DF"+id).prop('checked', false);
                    $( "#I"+id ).attr( "disabled", "true" );
                    $( "#U"+id ).attr( "disabled", "true" );
                    $( "#D"+id ).attr( "disabled", "true" );
                    $( "#SF"+id ).attr( "disabled", "true" );
                    $( "#DF"+id ).attr( "disabled", "true" );
                }else{
                    $( "#I"+id ).removeAttr("disabled");
                    $( "#U"+id ).removeAttr("disabled");
                    $( "#D"+id ).removeAttr("disabled");
                    $( "#SF"+id ).removeAttr("disabled");
                    $( "#DF"+id ).removeAttr("disabled");            
                }
                //$("#I"+id).removeAttr('checked');
            });
        });

        function modulo(id){
                var modulos = <?php print_r(json_encode($recursos)) ?>;
                $.each(modulos, function(index , value){
                    if(value.id == id){
                        $('#'+value.nombre).change(function(){
                            if( $(this).prop('checked') == false) {
                                $( "#I"+id ).attr( "disabled", "true" );
                                $( "#U"+id ).attr( "disabled", "true" );
                                $( "#D"+id ).attr( "disabled", "true" );
                                $( "#SF"+id ).attr( "disabled", "true" );
                                $( "#DF"+id ).attr( "disabled", "true" );
                            }else{
                                $( "#I"+id ).removeAttr("disabled");
                                $( "#U"+id ).removeAttr("disabled");
                                $( "#D"+id ).removeAttr("disabled");
                                $( "#SF"+id ).removeAttr("disabled");
                                $( "#DF"+id ).removeAttr("disabled");
                            }
                            $("#R"+id).prop('checked', $(this).prop("checked"));
                            $("#I"+id).prop('checked', $(this).prop("checked"));
                            $("#U"+id).prop('checked', $(this).prop("checked"));
                            $("#D"+id).prop('checked', $(this).prop("checked"));
                            $("#SF"+id).prop('checked', $(this).prop("checked"));
                            $("#DF"+id).prop('checked', $(this).prop("checked"));
                        });
                        
                    };
                });
            }
</script>
@endsection
