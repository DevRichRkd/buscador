<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
         <title>{{env('APP_NAME')}}</title>
        <!-- Fevicon -->
        <!--link rel="shortcut icon" href="assets/images/favicon.ico"-->
        
        <!-- Start css -->
        <link href="{{ asset('assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/flag-icon.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('hotspot') }}/jquery.hotspot.css">
        <!-- End css -->
    </head>
    <style>
        .selector-for-some-widget {
            box-sizing: content-box;
        }

        body {
            overflow-x: hidden; /* Hide horizontal scrollbar */
        }

        label{
            color: #e3e4ec;
        }

        .form-control-fondo {
            background-color: #4a4a57;
            font-size: 15px;
            color: #e3e4ec;
            border: 1px solid rgb(227 228 236);
            border-radius: 3px;
        }
    </style>
<body >

    <div style="background-color: #F7F7F7;">
        <div class="container pt-5">
            <div class="row  justify-content-around text-center pt-5">
                <div class="col-sm-12">
                    <span class="h5">Resultados</span>
                </div>

                <div class="col-md-3 text-left pt-5">
                    <div class="p-3">
                        <p class=" h6 bold">Entidades</p>
                        @if(count($totalEntidades) > 0)
                            @foreach($totalEntidades as $entidad => $valor)
                                <p><a href="{{url('filters')}}/{{$idExpediente}}/{{$valor->id}}/{{$idAnio}}/{{$idTipo}}/{{$idEpoca}}/{{$idMateria}}">{{$valor->nombre}} ({{$valor->total}})</p></a>
                            @endforeach 
                        @else
                            <p>Sin resultados</p>
                        @endif
                   </div>

                   <div class="p-3">
                        <p class=" h6 bold">Años</p>
                        @if(count($totalAnios) > 0)
                            @foreach($totalAnios as $anios => $valor)
                            <p><a href="{{url('filters')}}/{{$idExpediente}}/{{$idEntidad}}/{{$valor->id}}/{{$idTipo}}/{{$idEpoca}}/{{$idMateria}}">{{$valor->nombre}} ({{$valor->total}})</p></a>
                            @endforeach 
                        @else
                            <p>Sin resultados</p>
                        @endif
                    </div>

                    <div class="p-3">
                        <p class=" h6 bold">Tipo</p>
                        @if(count($totalCriterios) > 0)
                            @foreach($totalCriterios as $criterio => $valor)
                            <p><a href="{{url('filters')}}/{{$idExpediente}}/{{$idEntidad}}/{{$idAnio}}/{{$valor->id}}/{{$idEpoca}}/{{$idMateria}}">{{$valor->nombre}} ({{$valor->total}})</p></a>
                            @endforeach 
                        @else
                            <p>Sin resultados</p>
                        @endif
                    </div>

                    <!--Aqui se colocara el campo de clave de control-->
                    <!--Aqui se colocara el campo de clave de control-->

                    <div class="p-3">
                        <p class=" h6 bold">Epoca</p>
                        @if(count($totalEpocas) > 0)
                            @foreach($totalEpocas as $epoca => $valor)
                            <p><a href="{{url('filters')}}/{{$idExpediente}}/{{$idEntidad}}/{{$idAnio}}/{{$idTipo}}/{{$valor->id}}/{{$idMateria}}">{{$valor->nombre}} ({{$valor->total}})</p></a>
                            @endforeach 
                        @else
                            <p>Sin resultados</p>
                        @endif
                    </div>

                    <div class="p-3">
                        <p class=" h6 bold">Materia</p>
                        @if(count($totalMaterias) > 0)
                            @foreach($totalMaterias as $materia => $valor)
                            <p><a href="{{url('filters')}}/{{$idExpediente}}/{{$idEntidad}}/{{$idAnio}}/{{$idTipo}}/{{$idEpoca}}/{{$valor->id}}">{{$valor->nombre}} ({{$valor->total}})</p></a>
                            @endforeach 
                        @else
                            <p>Sin resultados</p>
                        @endif
                    </div>


               </div>
                <div class="col-md-9 pt-5">
                    <div class="row">
                        @if(count($expedientes) >  0)
                            @foreach($expedientes as $expediente => $valor)
                                <div class="col-md-12 text-left mt-3">
                                    <div style="background-color: white; border-radius: 10px;" class="p-3 shadow">
                                        <span style="color:#0054DB" class="h6 bold">{{$valor->rubro}}</span><br><br>
                                        <p>{{$valor->clave_de_control}}</p><br>
                                        <p style="color:#0054DB">{{$valor->palabras_clave}}</p>
                                        <p>{{$valor->presedentes}} / <a href="{{$valor->vinculo}}" class="float-right p-3"><span style="color:#0054DB" class="text-right pl-5">Descargar</span></a></p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <p class="h3 text-center text-danger mt-3">No se encontraron resultados.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Start js -->        
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.js" integrity="sha256-FYpdV7ChCZtW4xZWtO5QNyY5ynaAm843CE8jjyJzCAw=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.24.1/dist/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/detect.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/vertical-menu.js') }}"></script>
    <!-- Switchery js -->
    <script src="{{ asset('assets/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script src="{{ asset('assets/js/custom/custom-sweet-alert.js')}}"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="{{ asset('hotspot')}}/jquery.hotspot.js"></script>


</body>
</html>