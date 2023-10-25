<div style="background-color: #E3E4ec;">
        <div class="container">
            <div class="row text-center pt-5">
                <div class="col-sm-12">
                    <img src="{{asset('imagenes')}}/{{$ajustes->logo_tres}}">
                </div>
                <div class="col-sm-12 pt-3">
                    <img src="{{asset('imagenes')}}/{{$ajustes->logo_cuatro}}">
                </div>

                <div class="col-sm-12 pt-5">
                    <span style="color: #666666;">{!!$ajustes->direccion !!}</span>
                </div>

                <div class="col-sm-6 offset-md-3 text-center pt-3">
                     @if($ajustes->facebook != '')
                        <a href="{{$ajustes->facebook}}" target="__blank">
                            <img src="{{asset('images/Footer/Icono-FB.png')}}">
                        </a>
                    @endif

                    @if($ajustes->twitter != '')
                        <a href="{{$ajustes->twitter}}" target="__blank">
                            <img src="{{asset('images/Footer/Icono-TW.png')}}">
                        </a>
                    @endif

                    @if($ajustes->instagram != '')
                        <a href="{{$ajustes->instagram}}" target="__blank">
                            <img src="{{asset('images/Footer/Icono-IG.png')}}">
                        </a>
                    @endif

                    @if($ajustes->youtube != '')
                        <a href="{{$ajustes->youtube}}" target="__blank">
                            <img src="{{asset('images/Footer/Icono-YB.png')}}">
                        </a>
                    @endif
                </div>
                <!--div class="col-sm-1 offset-md-4 pt-5">
                    <img src="{{asset('images/Footer/Icono-FB.png')}}">
                </div>

                <div class="col-sm-1 pt-5">
                    <img src="{{asset('images/Footer/Icono-TW.png')}}">
                </div>

                <div class="col-sm-1 pt-5">
                    <img src="{{asset('images/Footer/Icono-IG.png')}}">
                </div>

                <div class="col-sm-1 pt-5">
                    <img src="{{asset('images/Footer/Icono-YB.png')}}">
                </div-->

                <div class="col-sm-12 pt-3">
                    <img src="{{asset('images/Footer/Line-footer.png')}}" class="img-fluid">
                </div>

                <div class="col-sm-12 pt-3 pb-5">
                    <span style="color: #666666;">{{$ajustes->derechos}} </span>
                </div>

            </div>
        </div>
    </div>