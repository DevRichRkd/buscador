@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Dashboard</div>
        <div class="card-body">
            <h1>{{__('usuarioTitulo')}}</h1>
                <div class="row">  
                    @if($perm['R'])
                        @if($perm['I'])
                            <div class="col-md-12">
                                <a href="{{ route('usuarios.create') }}" class="float-right" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('clickAgregar')}} " data-custom-class="tooltip-dark">
                                    <button type="button" class="btn  btn-rounded btn-social-icon btn-inverse-success btn-fw">
                                        <i class="mdi mdi mdi-plus-circle" style="font-size: 30px;"></i>
                                    </button>
                                </a>
                            </div>
                        @endif
                        
                        <div class="col-md-12 pt-3">
                            <div class="table-responsive">
                                <table id="order-listing" class="table">
                                  <thead>
                                    <tr>
                                        <th>{{__('numero')}}</th>
                                        <th>{{__('nombre')}}</th>
                                        <th>{{__('email')}}</th>
                                        <th>{{__('Tipo')}}</th>
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
                                    @foreach($usuarios as $valor)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{$valor->name}}</td>
                                            <td>{{$valor->email}}</td>
                                            <td>
                                                @if($valor->id_tipo_users == 1)
                                                    Administrador
                                                @else
                                                    Conductor
                                                @endif
                                            </td>
                                            @include("layouts.partials.estatus",['estatus' => $valor->estatus])
                                                                
                                            @include("layouts.partials.td-actualizar-eliminar",['id' => $valor->id, 'nombre' => $valor->name, 'recurso' => 'usuarios'])
                                        </tr>
                                        @php $count++; @endphp
                                    @endforeach
                                  </tbody>
                                </table>
                            </div>

                        </div>
                    @else
                        @include("layouts.partials.sinPermisos")
                    @endif
                </div>
        </div>
    </div>
@endsection