@extends('layouts.app')

@section('content')
	<div class="card">
    <div class="card-body">
        <h1>{{__('crear').' '.__('menuTitulo')}}</h1>
        <div class="row">  
            @if($perm['R'])            
                <div class="col-md-12">
                    <form class="forms-sample" action="{{ url('menu') }}" method="POST" role="form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoNombre')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="50" class="form-control @error('nombre') is-invalid @else @if(old('nombre')) is-valid @endif @enderror" name="nombre" id="nombre" value="{{old('nombre')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'nombre'])
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoDescripcion')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @else @if(old('descripcion')) is-valid @endif @enderror" maxlength="120" name="descripcion">{{old('descripcion')}}</textarea>

                                        @include('layouts.partials.errorCampos',['campo' => 'descripcion'])

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoMenuPadre')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="padre" id="padre" class="form-control input-sm @error('padre') is-invalid @else @if(old('padre')) is-valid @endif @enderror">
                                            <option value="0" {{ old('padre') == 0 ? 'selected' : '' }}>/</option>
                                            @foreach($menu as $valor)
                                                <option value="{{ $valor->id }}" {{ old('padre') == $valor->id ? 'selected' : '' }}>{{ $valor->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @include('layouts.partials.errorCampos',['campo' => 'padre'])
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoRecursoEnlazado')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="optrecurso" class="form-control input-sm @error('optrecurso') is-invalid @else @if(old('optrecurso')) is-valid @endif @enderror">
                                            <option value="0" {{ old('optrecurso') == 0 ? 'selected' : '' }}>-- Seleccione --</option>
                                            @foreach($recursos as $valor)
                                                <option value="{{ $valor->id }}" {{ old('optrecurso') == $valor->id ? 'selected' : '' }}>{{ $valor->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @include('layouts.partials.errorCampos',['campo' => 'optrecurso'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoUrl')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="50" class="form-control @error('page_url_estandar') is-invalid @else @if(old('page_url_estandar')) is-valid @endif @enderror" name="page_url_estandar" id="page_url_estandar" value="{{old('url')}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'page_url_estandar'])
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoIcono')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="50" class="form-control @error('icon') is-invalid @else @if(old('icon')) is-valid @endif @enderror" name="icon" id="icon" value="{{old('icono')}}">
                                        <a href="{{route('iconos')}}" target="_blank">{{__('verIconos')}}</a>
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'icon'])

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('campoOrden')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="orderr" id="orderr" class="form-control input-sm @error('optrecurso') is-invalid @else @if(old('orderr')) is-valid @endif @enderror">
                                            <option value="0" {{ old('orderr') == 0 ? 'selected' : '' }}>-- Seleccione --</option>
                                            @for ($i = 1; $i <= 30; $i++)
                                                <option value="{{ $i }}" {{ old('orderr') == $valor->id ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @include('layouts.partials.errorCampos',['campo' => 'orderr'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-9 offset-2">
                                <div class="form-check form-check-flat form-check-primary">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="estatus" value="1" checked="">
                                        {{__("campoActivo")}}
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-right pr-3 ">
                                    <a href="{{ url('menu') }}" class="btn bg-secondary lighten-1  z-depth-3 text-light">
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

@section('script')
	<script>
	   
	</script>
@endsection