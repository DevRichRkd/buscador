@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1>{{__('editar').' '.__('recursosTitulo')}}</h1>
        <div class="row">  
            @if($perm['R'])            
                <div class="col-md-12">
                    <form class="forms-sample" action="{{ route('recursos.update', $recursos->id) }}" method="POST" role="form" enctype="multipart/form-data">
                        <input type="hidden" class="form-control"  name="_method" value="PUT"></input>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoNombre')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input id="nombre" type="hidden" data-length="50" name="nombreOriginal" value="{{$recursos->nombre}}">
                                        <input type="text" maxlength="50" class="form-control @error('nombre') is-invalid @else @if(old('nombre')) is-valid @endif @enderror" name="nombre" id="nombre" value="{{$recursos->nombre}}">
                                        
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
                                        <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @else @if(old('descripcion')) is-valid @endif @enderror" maxlength="120" name="descripcion">{{$recursos->descripcion}} </textarea>

                                        @include('layouts.partials.errorCampos',['campo' => 'descripcion'])

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-9 offset-3">
                                <div class="form-check form-check-flat form-check-primary">
                                    @php
                                        $check = null;
                                        $check = ($recursos->estatus == 1) ?  'checked="checked"': '' ;
                                    @endphp
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="estatus" value="1" {{$check}}>
                                        {{__("campoActivo")}}
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-right pr-3 ">
                                    <a href="{{ url('recursos') }}" class="btn bg-secondary lighten-1  z-depth-3 text-light">
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