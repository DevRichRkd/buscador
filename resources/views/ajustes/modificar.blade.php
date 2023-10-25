@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1>{{__('editar').' '.__('Ajustes')}}</h1>
        <div class="row">  
            @if($perm['R'])            
                <div class="col-md-12">
                    <form class="forms-sample" action="{{ route('ajustes.update', $ajustes->id) }}" method="POST" role="form" enctype="multipart/form-data">
                        <input type="hidden" class="form-control"  name="_method" value="PUT"></input>
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Imagen uno * Solo si desea cambiar la imagen')}}
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="file" class="form-control" name="imagenUno" accept="application/png">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'imagenUno'])
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Imagen dos * Solo si desea cambiar la imagen')}}
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="file" class="form-control" name="imagenDos" accept="application/png">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'imagenDos'])
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Bóton Uno')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('boton_uno') is-invalid @else @if(old('boton_uno')) is-valid @endif @enderror" name="boton_uno" id="boton_uno" value="{{$ajustes->boton_uno}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'boton_uno'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Link Uno')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('link_uno') is-invalid @else @if(old('link_uno')) is-valid @endif @enderror" name="link_uno" id="link_uno" value="{{$ajustes->link_uno}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'link_uno'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Bóton Dos')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('boton_dos') is-invalid @else @if(old('boton_dos')) is-valid @endif @enderror" name="boton_dos" id="boton_dos" value="{{$ajustes->boton_dos}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'boton_dos'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Link Dos')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('link_dos') is-invalid @else @if(old('link_dos')) is-valid @endif @enderror" name="link_dos" id="link_dos" value="{{$ajustes->link_dos}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'link_dos'])
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
                                        <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @else @if(old('descripcion')) is-valid @endif @enderror" name="descripcion">{{$ajustes->texto}} </textarea>

                                        @include('layouts.partials.errorCampos',['campo' => 'descripcion'])

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Dirección')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('direccion') is-invalid @else @if(old('direccion')) is-valid @endif @enderror" name="direccion" id="direccion" value="{{$ajustes->direccion}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'direccion'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Facebook')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('facebook') is-invalid @else @if(old('facebook')) is-valid @endif @enderror" name="facebook" id="facebook" value="{{$ajustes->facebook}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'facebook'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Twitter')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('twitter') is-invalid @else @if(old('twitter')) is-valid @endif @enderror" name="twitter" id="twitter" value="{{$ajustes->twitter}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'twitter'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Instagram')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('instagram') is-invalid @else @if(old('instagram')) is-valid @endif @enderror" name="instagram" id="instagram" value="{{$ajustes->instagram}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'instagram'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Youtube')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('youtube') is-invalid @else @if(old('youtube')) is-valid @endif @enderror" name="youtube" id="youtube" value="{{$ajustes->youtube}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'youtube'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Imagen tres * Solo si desea cambiar la imagen')}}
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="file" class="form-control" name="imagenTres" accept="application/png">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'imagenTres'])
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Imagen cuatro * Solo si desea cambiar la imagen')}}
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="file" class="form-control" name="imagenCuatro" accept="application/png">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'imagenCuatro'])
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        {{__('Derechos')}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('derechos') is-invalid @else @if(old('derechos')) is-valid @endif @enderror" name="derechos" id="derechos" value="{{$ajustes->derechos}}">
                                        
                                        @include('layouts.partials.errorCampos',['campo' => 'derechos'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-right pr-3 ">
                                    <a href="{{ url('home') }}" class="btn bg-secondary lighten-1  z-depth-3 text-light">
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

</script>
@endsection