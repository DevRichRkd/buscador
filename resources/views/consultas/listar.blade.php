@extends('layouts.app')

@section('content')
	<div class="card">
        <div class="card-body">
            <h1>{{__('Consultas')}}</h1>
                <div class="row">  
                    @if($perm['R'])
                        @if($perm['I'])
                            <div class="col-md-12">
                                <a href="{{ route('consultas.create') }}" class="float-right" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('clickAgregar')}} " data-custom-class="tooltip-dark">
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
                                        <th>{{__('Sector')}}</th>
                                        <th>{{__('Consulta')}}</th>
                                        <th>{{__('Nombre')}}</th>
                                        <th>{{__('Tema')}}</th>
                                        <th>{{__('Descripción')}}</th>
                                        <th>{{__('Palabras clave')}}</th>
                                        <th>{{__('Ejercicio')}}</th>
                                        {{--<th>{{__('Word')}}</th>--}}
                                        <th>{{__('Pdf')}}</th>
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
                                    @foreach($consultas as $valor)
                                        <tr>
                                            <td>{{$valor->id}}</td>
                                            <td>{{$valor->nivel}}</td>
                                            <td>{{$valor->autor}}</td>
                                            <td>{{$valor->titulo}}</td>
                                            <td>{{$valor->tema}}</td>
                                            <td>{{$valor->sintesis}}</td>
                                            <td>{{$valor->palabras_clave}}</td>
                                            <td>{{$valor->ejercicio}}</td>
                                            {{--<td>
                                                @if($valor->word)
                                                    @if($perm['DF'])
                                                        <a href="{{asset('documentos') }}/{{$valor->word}}" download="{{asset('documentos') }}/{{$valor->word}}">
                                                            <i class="mdi  mdi-file-word" style="font-size: 30px;color:green" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('activo')}} " data-custom-class="tooltip-dark"></i>
                                                        </a>
                                                    @else
                                                         <i class="mdi  mdi-file-word" style="font-size: 30px;color:red" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('activo')}} " data-custom-class="tooltip-dark"></i>
                                                    @endif
                                                @endif
                                            </td>--}}
                                            <td>
                                                @if($valor->pdf)
                                                 <a href="{{asset('documentos') }}/{{$valor->pdf}}" download="{{asset('documentos') }}/{{$valor->pdf}}">
                                                    <i class="mdi  mdi-file-pdf" style="font-size: 30px;color:green" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('activo')}} " data-custom-class="tooltip-dark"></i>
                                                </a>
                                                   
                                                @endif
                                            </td>
                                            @include("layouts.partials.estatus",['estatus' => $valor->estatus])
                                                                
                                            @include("layouts.partials.td-actualizar-eliminar",['id' => $valor->id, 'nombre' => $valor->titulo, 'recurso' => 'consultas'])                                 
                                        </tr>
                                        @php $count++; @endphp
                                    @endforeach
                                  </tbody>
                                </table>
                            </div>
                        </div>
                        <div clas="col-md-12 offset-2 text-center">
                            <div class="text-center">
                                {{ $consultas->links() }}
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
        // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );


 
    // DataTable
    var table = $('#example').DataTable({
        "scrollX": true,
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

    </script>
@endsection