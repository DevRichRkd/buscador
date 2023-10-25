@if($perm['U'])
    <td>
        <a href="{{ $recurso }}/{{ $id }}/edit" class="btn btn-warning btn-rounded btn-fw text-light" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('clickEditar')}} " data-custom-class="tooltip-dark">
            <i class='mdi mdi-lead-pencil' style="font-size: 30px;"></i>
        </a>
    </td>
@endif
@if($perm['D'])
    <td>         
        <a class="btn btn-danger btn-rounded btn-fw text-light"data-toggle="modal" data-target="#modalDelete{{$id}}">
            <i class='mdi mdi mdi-delete-forever' style="font-size: 30px;" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('clickBorrar')}} " data-custom-class="tooltip-dark"></i>
        </a>
        <!-- Modal Eliminar -->
            <div class="modal fade" id="modalDelete{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h2 class="modal-title pt-0 pb-0" id="exampleModalLabel-2">
                                {{__("eliminarRegistro")}}
                            </h2>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3> {{__("mensajeEliminar",['nombre' => $nombre] )}} </h3>
                        </div>
                        <div class="modal-footer">
                            <form accept-charset="utf-8" action="{{ route ($recurso.'.destroy',$id)}}" method="POST">
                                <input name="_method" type="hidden" value="DELETE">
                                {{ csrf_field() }}

                                <input class="btn bg-primary text-white" style="font-size: 1.5rem !important;" type="submit" value="{{__("eliminar")}}">

                                <button type="button" class="btn bg-secondary text-white" data-dismiss="modal" style="font-size: 1.5rem !important;">{{__("cancelar")}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Modal -->
    </td>
@endif