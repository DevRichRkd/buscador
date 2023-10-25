@include('layouts/partials/header')
        <div class="contentbar">
            @yield('content')
            @if (session('msj'))
                        @include("layouts.partials.mensaje-modal",['titulo' => session('titulo') ,'msj' => session('msj'), 'tipo' => session('tipo'), 'icono' => session('icono')])
                        @endif
        </div>
@include('layouts/partials/footer')