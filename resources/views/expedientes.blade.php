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

    <div style="background-color: #fff;">
        <div class="container pt-5">
            <div class="row  justify-content-around text-center pt-5">
                <?php
                    $classActiveHistoricos = "";
                    $classActiveVigentes = "";
                    $classActiveAll = "";
                    $classActiveAcceso = "";
                    $classActiveProteccion = "";
                    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                    if ((false !== strpos($url,'/expedientes/1')) or (false !== strpos($url,'/expedientes/2'))) {
                            $classActiveAll = "classActive";
                    } else {
                        if (false !== strpos($url,'filters/0/1')) {
                            $seccion = substr($url, -1);
                            if($seccion == "0"){
                                $classActiveAll = "classActive";
                            }else{
                                if($seccion == "1"){
                                    $classActiveVigentes = "classActive";
                                }else{
                                    if($seccion == "2"){
                                        $classActiveHistoricos = "classActive";
                                    }
                                }
                            }
                        }else{
                            if (false !== strpos($url,'filters/0/2')) {
                                $seccion2 = substr($url, -3);
                                if($seccion2 == "0/0"){
                                    $classActiveAll = "classActive";
                                }else{
                                    if($seccion2 == "1/0"){
                                        $classActiveAcceso = "classActive";
                                    }else{
                                        if($seccion2 == "2/0"){
                                            $classActiveProteccion = "classActive";
                                        }
                                    }
                                }
                            }
                        }
                    }
                ?>
                <div class="col-md-9 offset-md-3 d-flex menu-secciones" >
                    <div class="col-md-4 {{$classActiveAll}}"><a href="{{ url('expedientes')}}/{{$idExpediente}}/">TODO</a></div>
                    @if($idExpediente == 1)
                    <div class="col-md-4 {{$classActiveVigentes}}"><a href="{{url('filters')}}/{{$request}}/{{$idExpediente}}/0/0/0/0/0/1">VIGENTE</a></div>
                    <div class="col-md-4 {{$classActiveHistoricos}}"><a href="{{url('filters')}}/{{$request}}/{{$idExpediente}}/0/0/0/0/0/2">HISTORICO</a></div>
                    @endif
                    @if($idExpediente == 2)
                    <div class="col-md-4 {{$classActiveAcceso}}"><a href="{{url('filters')}}/{{$request}}/{{$idExpediente}}/0/0/0/0/1/0">ACCESO A LA<br>INFORMACION</a></div>
                    <div class="col-md-4 {{$classActiveProteccion}}"><a href="{{url('filters')}}/{{$request}}/{{$idExpediente}}/0/0/0/0/2/0">PROTECCION DE<br>DATOS PERSONALES</a></div>
                    @endif
                </div>

                <div class="col-md-3 text-left pt-5">
                    <!--Aqui se colocara el campo de clave de control-->
                    <div class="p-3">
                        <p class=" h5 bold color-title">Clave de control</p>
                        <input type="text" id="clave_de_control" name="clave_de_control" class="w-100">
                        <input type="hidden" value="{{$idExpediente}}" id="idExpediente">
                        <select id="display" class="form-select w-100" multiple style="display:none">
                        </select>
                    </div> 
                    <!--Aqui se colocara el campo de clave de control-->
                    <div class="p-3">
                        <p class=" h5 bold color-title">Entidades</p>
                        <ul class="listFilters">
                            @if(count($totalEntidades) > 0)
                                @foreach($totalEntidades as $entidad => $valor)
                                    <li><a href="{{url('filters')}}/{{$request}}/{{$idExpediente}}/{{$valor->id}}/{{$idAnio}}/{{$idTipo}}/{{$idEpoca}}/{{$idMateria}}/{{$idSeccion}}">{{$valor->nombre}} ({{$valor->total}})</li></a>
                                @endforeach
                            @else
                                <li>Sin resultados</li>
                            @endif
                        </ul>
                   </div>

                   <div class="p-3">
                        <p class=" h5 bold color-title">Años</p>
                        <ul class="listFilters">
                            @if(count($totalAnios) > 0)
                                @foreach($totalAnios as $anios => $valor)
                                    <li><a href="{{url('filters')}}/{{$request}}/{{$idExpediente}}/{{$idEntidad}}/{{$valor->id}}/{{$idTipo}}/{{$idEpoca}}/{{$idMateria}}/{{$idSeccion}}">{{$valor->nombre}} ({{$valor->total}})</li></a>
                                @endforeach
                            @else
                                <li>Sin resultados</li>
                            @endif
                        </ul>
                    </div>
                    @if($idExpediente == 1)
                        <div class="p-3">
                            <p class=" h5 bold color-title">Tipo</p>
                            <ul class="listFilters">
                                @if(count($totalCriterios) > 0)
                                    @foreach($totalCriterios as $criterio => $valor)
                                        <li><a href="{{url('filters')}}/{{$request}}/{{$idExpediente}}/{{$idEntidad}}/{{$idAnio}}/{{$valor->id}}/{{$idEpoca}}/{{$idMateria}}/{{$idSeccion}}">{{$valor->nombre}} ({{$valor->total}})</li></a>
                                    @endforeach
                                @else
                                    <li>Sin resultados</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    
                    @if($idExpediente == 1)
                        <div class="p-3">
                            <p class=" h5 bold color-title">Epoca</p>
                            <ul class="listFilters">
                                @if(count($totalEpocas) > 0)
                                    @foreach($totalEpocas as $epoca => $valor)
                                        <li><a href="{{url('filters')}}/{{$request}}/{{$idExpediente}}/{{$idEntidad}}/{{$idAnio}}/{{$idTipo}}/{{$valor->id}}/{{$idMateria}}/{{$idSeccion}}">{{$valor->nombre}} ({{$valor->total}})</li></a>
                                    @endforeach
                                @else
                                    <li>Sin resultados</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    <div class="p-3">
                        <p class=" h5 bold color-title">Materia</p>
                        <ul class="listFilters">
                            @if(count($totalMaterias) > 0)
                                @foreach($totalMaterias as $materia => $valor)
                                    <li><a href="{{url('filters')}}/{{$request}}/{{$idExpediente}}/{{$idEntidad}}/{{$idAnio}}/{{$idTipo}}/{{$idEpoca}}/{{$valor->id}}/{{$idSeccion}}">{{$valor->nombre}} ({{$valor->total}})</li></a>
                                @endforeach
                            @else
                                <li>Sin resultados</li>
                            @endif
                        </ul>
                    </div>
               </div>
                <div class="col-md-9 pt-5">
                    <div class="row">
                        <?php $cont = 0 ?>
                        @if(count($expedientes) >  0)
                            @foreach($expedientes as $expediente => $valor)
                            <?php 
                                $cont++;
                                if (($cont % 2) == 0) {
                                    $classZebra = 'zebra-2';
                                } else {
                                    $classZebra = 'zebra-1';
                                }
                             ?>
                                <div class="col-md-12 text-left mt-0 {{$classZebra}} pt-4 pb-3">
                                    <div class="d-flex">
                                        <div class="col-md-10">
                                            <span class="h6 bold box-title-color">{{$valor->rubro}}</span><br>
                                            <p>Clave de control : {{$valor->clave_de_control}}</p>
                                            <p>Entidad : {{$valor->entidad}}</p>
                                            <p>Oganismo : {{$valor->organismo}}</p>
                                            <p>Palabras clave : {{$valor->palabras_clave}}</p>
                                            <p class="text-right">
                                                <button type="button" class="btn btn-primary btn-view-more" data-toggle="modal" data-target="#Modal{{$valor->clave_de_control}}">
                                                Ver mas
                                                </button>
                                            </p>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{$valor->vinculo}}" class="float-right p-3" target="_blank"><i class="mdi mdi-package-down box-icon-download"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="Modal{{$valor->clave_de_control}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <a type="button" class="icon-close" data-dismiss="modal"><i class="mdi mdi-window-close"></i></a>
                                        <div class="modal-body">
                                            @if($idExpediente == 1)
                                                <p><span class="titles-modal">Año de emision</span><br>{{$valor->anio}}</p>
                                                <p><span class="titles-modal">Epoca</span><br>{{$valor->epoca}}</p>
                                                <p><span class="titles-modal">Materia</span><br> {{$valor->materia}}</p>
                                                <p><span class="titles-modal">Tipo</span><br>{{$valor->criterio_seccion}}</p>
                                                <p><span class="titles-modal">Resolucion o presedente</span><br>{{$valor->presedentes}}</p>
                                                <p><span class="titles-modal">Tipo de criterio</span><br>{{$valor->criterio}}</p>
                                            @endif
                                            @if($idExpediente == 2)
                                                <p><span class="titles-modal">Año de emision</span><br>{{$valor->anio}}</p><br>
                                                <p><span class="titles-modal">Solicitud</span><br>{{$valor->solicitud}}</p><br>
                                                <p><span class="titles-modal">Respuesta</span><br>{{$valor->respuesta}}</p><br>
                                                <p><span class="titles-modal">Agravio</span><br>{{$valor->agravio}}</p><br>
                                                <p><span class="titles-modal">Relevancia</span><br>{{$valor->relevancia}}</p><br>     
                                            @endif
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                            @endforeach
                            <div class="col-md-12 float-right mt-5">
                                <div class="float-right bbb">
                                   @if($request != 0)
                                        {{$expedientes->appends(['search' => $request ])->links()}}
                                    @else
                                    {{$expedientes->appends(['request' => $request,
                                                        'expediente' =>$idExpediente,
                                                        'entidad' => $idEntidad,
                                                        'anio' => $idAnio,
                                                        'tipo' => $idTipo,
                                                        'epoca' => $idEpoca,
                                                        'procedencia' => $idMateria,
                                                        'pertenencia' => $idSeccion, ])->links()}}
                                    @endif
                                </div>
                            </div>
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
    <script>
        $(document).ready(function() {
            var idExpediente = $('#idExpediente').val();
            $("#clave_de_control").keyup(function() {
                var clave = $('#clave_de_control').val();
                if(clave == ''){
                    $('#display').hide();
                }else{
                    $.get('/expedientesByClave/'+clave+'/'+idExpediente, function(data){
                            $('#display').empty();
                            if(data.length > 0){
                                $('#display').show();
                            }else{
                                $('#display').hide();
                            }
                                for(i = 0; i < data.length; i++){
                                    $('#display').append('<option value="'+ data[i].id +'">'+ data[i].clave_de_control +'</option>');
                                }
                        });
                }
            });

            $(".form-select").change(function(){
                var idInformacion = $(this).val();
                window.location.href = '/expediente/'+idExpediente+'/'+idInformacion;
            });
        });
    </script>


</body>
</html>