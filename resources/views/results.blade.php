<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Orbiter is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, responsive, bootstrap 4, ui kits, ecommerce, web app, crm, cms, html, sass support, scss">
    <meta name="author" content="Themesbox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{env('APP_NAME')}}</title>
    <!-- Fevicon -->
    <!--link rel="shortcut icon" href="assets/images/favicon.ico"-->
    <!-- Start css -->
    <!-- Switchery css -->
    <link href="{{ asset('assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet">
    <!-- Apex css -->
    {{--<link href="{{ asset('assets/plugins/apexcharts/apexcharts.css')}}" rel="stylesheet">--}}
    <!-- Slick css -->
    {{--<link href="{{ asset('assets/plugins/slick/slick.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/slick/slick-theme.css')}}" rel="stylesheet">--}}
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
    <style>
        div.dataTables_wrapper {
        width: 80%;
        margin: 0 auto;
    }
    </style>
    <!-- End css -->
</head>
<body >
    @include("layouts.partials.navbar-website")

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-10 offset-1 text-center">
                <h1>Resultados de  @if(isset($sector) and count($sector) > 0) Sector {{$sector[0]->nombre}} @else Todos los sectores @endif</h1>
            </div>

            <div id="carga" class="col-md-10 offset-1 text-center">
                <img src="{{asset('assets/images/carga.gif')}}" alt="" class="img-fluid">
            </div>

            <div class="col-lg-12" id="divTable">
                <table id="example" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                             <th>{{__('Sector')}}</th>
                            <th>{{__('Consulta')}}</th>
                            <th>{{__('Tema')}}</th>
                            <th>{{__('Descripción')}}</th>
                            <th>{{__('Palabras clave')}}</th>
                            <th>{{__('Ejercicio')}}</th>
                            <th>{{__('Word')}}</th>
                            <th>{{__('Pdf')}}</th>
                        </tr>
                    </thead>
                    {{--<tbody>
                        @foreach($consultas as $consulta => $valor)
                            <tr>
                                <td>{{$valor->sector}}</td>
                                <td>{{$valor->numero_consulta}}</td>
                                <td>{{$valor->tema}}</td>
                                <td>{{$valor->descripcion}}</td>
                                <td>{{$valor->palabras_clave}}</td>
                                <td>{{$valor->ejercicio}}</td>
                                <td>
                                    @if($valor->word)
                                      
                                     <a href="{{asset('documentos') }}/{{$valor->word}}" download="{{asset('documentos') }}/{{$valor->word}}">
                                        <i class="mdi  mdi-file-word" style="font-size: 30px;color:green" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('activo')}} " data-custom-class="tooltip-dark"></i>
                                    </a>
                                       
                                    @endif
                                </td>
                                <td>
                                    @if($valor->pdf)
                                     <a href="{{asset('documentos') }}/{{$valor->pdf}}" download="{{asset('documentos') }}/{{$valor->pdf}}">
                                        <i class="mdi  mdi-file-pdf" style="font-size: 30px;color:green" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('activo')}} " data-custom-class="tooltip-dark"></i>
                                    </a>
                                       
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>--}}
                    <tfoot>
                        <tr>
                            <th>{{__('Sector')}}</th>
                            <th>{{__('Consulta')}}</th>
                            <th>{{__('Tema')}}</th>
                            <th>{{__('Descripción')}}</th>
                            <th>{{__('Palabras clave')}}</th>
                            <th>{{__('Ejercicio')}}</th>
                            <th>{{__('Word')}}</th>
                            <th>{{__('Pdf')}}</th>
                        </tr>
                    </tfoot>
            </table>
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
    <!-- Apex js -->
    {{--<script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts/irregular-data-series.js') }}"></script>
    <!-- Slick js -->
    <script src="{{ asset('assets/plugins/slick/slick.min.js') }}"></script>
    <!-- Custom Dashboard js -->   
    <script src="{{ asset('assets/js/custom/custom-dashboard.js') }}"></script>--}}
    <!-- Sweet-Alert js -->
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
            /*/ Setup - add a text input to each footer cell
            */
            //$("#divTable").hide()

            function pintarDatatable(dataResult, columns) {
                /*$("#example").DataTable({
                    data: dataResult,
                    columnDefs: columns,
                    aaSorting: [],
                    pageLength: 25
                });*/

                $('#example tfoot th').each( function () {
                    var title = $(this).text();
                    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
                } );

                $('#example thead th').each( function () {
                    var title = $(this).text();
                    $(this).html( '<label>'+title+'</label><input type="text" placeholder="Search '+title+'" />' );
                } );

                // DataTable
                var table = $('#example').DataTable({
                    "scrollX": true,
                    data: dataResult,
                    columnDefs: columns,
                    aaSorting: [],
                    pageLength: 10,
                    initComplete: function () {
                        // Apply the search
                        this.api().columns().every( function () {
                            var that = this;
             
                            $( 'input', this.footer() ).on( 'keyup change clear', function () {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            } );
                        } );
                    }
                });

                $("#carga").hide()
                //$("#divTable").show()
            }


            async function datos() {
                const data = await fetch("{{url('data')}}/@if(isset($sector) and count($sector) > 0) {{$sector[0]->id}}@else{{'todos'}}@endif")
                    .then(value => value.json())
                    .then(value => value)

                //ESTRUCTURA JSON QUE DEVUELVE EL API.
                /*
                [
                    {
                      "albumId": 1,
                      "id": 1,
                      "title": "accusamus beatae ad facilis cum similique qui sunt",
                      "url": "https://via.placeholder.com/600/92c952",
                      "thumbnailUrl": "https://via.placeholder.com/150/92c952"
                    },
                */

                //targets: position
                //Aquí data:"key". Ver arriba
                //En "render: callback " puedes tranformar la data.
                const columns = [
                    {
                        targets: 0,
                        title: "Sector",
                        data: "nombre"
                    },
                    {
                        targets: 1,
                        title: "Número consulta",
                        data: "numero_consulta",
                        /*render : (data,type,r,m) => {
                            return (type == "display") ? `<button class="btn btn-primary">${data}</button>` : data
                        }*/
                    },
                    {
                        targets: 2,
                        title: "Tema",
                        data: "tema",
                    },
                    {
                        targets: 3,
                        title: "Descipción",
                        data: "descripcion"
                    },
                    {
                        targets: 4,
                        title: "Palbras clave",
                        data: "palabras_clave",
                    },
                    {
                        targets: 5,
                        title: "Ejercicio",
                        data: "ejercicio",
                    },
                    {
                        targets: 6,
                        title: "Word",
                        data: "word",
                        render : (data,type,r,m) => {
                            return (type == "display") ? `<a href="{{asset('documentos') }}/`+data+`" download="`+data+`"">
                                    <i class="mdi  mdi-file-word" style="font-size: 30px;color:blue"></i>
                                </a>` : data
                        }
                    },
                    {
                        targets: 7,
                        title: "Pdf",
                        data: "pdf",
                        render : (data,type,r,m) => {
                            return (type == "display") ? `<a href="{{asset('documentos') }}/`+data+`" download="`+data+`"">
                                    <i class="mdi  mdi-file-pdf" style="font-size: 30px;color:red"></i>
                                </a>` : data
                        }
                    }
                ]
                pintarDatatable(data, columns)
            }

            datos()

         
        } );
    </script>


</body>
</html>