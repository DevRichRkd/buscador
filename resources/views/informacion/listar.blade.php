@extends('layouts.app')

@section('content')
	<div class="card">
        <div class="card-body">
            <h1>{{__('Informacion')}}</h1>
                <div class="row">  
                    @if($perm['R'])
                        @if($perm['I'])
                            <div class="col-md-12">
                                <a href="{{ route('informacion.create') }}" class="float-right" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('clickAgregar')}} " data-custom-class="tooltip-dark">
                                    <button type="button" class="btn  btn-rounded btn-social-icon btn-inverse-success btn-fw">
                                        <i class="mdi mdi mdi-plus-circle" style="font-size: 30px;"></i>
                                    </button>
                                </a>
                            </div>
                        @endif
                        
                        <div class="col-md-12 pt-3">
                            <div class="table-responsive">
                                <table id="example2" class="table">
                                  <thead>
                                    <tr>
                                        <th>{{__('Id')}}</th>
                                        <th>{{__('Expediente')}}</th>
                                        <th>{{__('Rubro')}}</th>
                                        <th>{{__('Palabras clave')}}</th>
                                        <th>{{__('Clave de control')}}</th>
                                        <th>{{__('Año')}}</th>
                                        <th>{{__('Entidad federativa')}}</th>
                                        <th>{{__('Organismo garante')}}</th>
                                        <th>{{__('Materia')}}</th>
                                        <th>{{__('Vínculo electrónico')}}</th>
                                         <!--<th>{{__('Precedentes')}}</th>
                                        <th>{{__('Tipo de criterio')}}</th>
                                        <th>{{__('Epoca del criterio')}}</th>
                                        <th>{{__('Tipo de criterio')}}</th>
                                       <th>{{__('Solicitud')}}</th>
                                        <th>{{__('Respuesta')}}</th>
                                        <th>{{__('Agravio')}}</th>
                                        <th>{{__('Relevancia de la Resolución')}}</th>-->
                                        <th>{{__('activo')}}</th>
                                        @if($perm['U'])
                                            <th>{{__('editar')}}</th>
                                        @endif
                                        @if($perm['D'])
                                            <th>{{__('borrar')}}</th>
                                        @endif
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @php $count = 1; @endphp
                                    @foreach($informacion as $valor)
                                        <tr>
                                            <td>{{$valor->id}}</td>
                                            <td>{{$valor->expediente}}</td>
                                            <td>{{$valor->rubro}}</td>
                                            <td>{{$valor->palabras_clave}}</td>
                                            <td>{{$valor->clave_de_control}}</td>
                                            <td>{{$valor->anio}}</td>
                                            <td>{{$valor->entidad}}</td>
                                            <td>{{$valor->organismo}}</td>
                                            <td>{{$valor->materia}}</td>
                                            <td>{{$valor->vinculo}}</td>
                                            <!--<td>{{$valor->presedentes}}</td>
                                            <td>{{$valor->criterio}}</td>
                                            <td>{{$valor->epoca}}</td>
                                            <td>{{$valor->criterio_seccion}}</td>
                                            <td>{{$valor->solicitud}}</td>
                                            <td>{{$valor->respuesta}}</td>
                                            <td>{{$valor->agravio}}</td>
                                            <td>{{$valor->relevancia}}</td>-->
                                            @include("layouts.partials.estatus",['estatus' => $valor->estatus])
                                                                
                                            @include("layouts.partials.td-actualizar-eliminar",['id' => $valor->id, 'nombre' => $valor->clave_de_control, 'recurso' => 'informacion'])                                 
                                        </tr>
                                        @php $count++; @endphp
                                    @endforeach
                                  </tbody>
                                </table>
                            </div>
                        </div>
                        <div clas="col-md-12 offset-2 text-center">
                            <div class="text-center">
                                {{ $informacion->links() }}
                            </div>
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
   
    </script>
@endsection