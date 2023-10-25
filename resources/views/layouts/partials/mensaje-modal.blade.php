<!-- Modal Eliminar -->
<div class="modal fade" id="mensajeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <div class="modal-header bg-{{$tipo}} text-white">
                <h2 class="modal-title pt-0 pb-0" id="exampleModalLabel-2">
                    {{$titulo}}
                </h2>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">×</span>
                </button>
            </div>
            
            <div class="modal-body text-center">
                 <i class="mdi  {{$icono}}" style="font-size: 60px;" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('activo')}} " data-custom-class="tooltip-dark"></i>
                <h3>{{$msj}}</h3>
            </div>
            
            <!--div class="modal-footer">
                <button type="button" class="btn bg-secondary text-white" data-dismiss="modal" style="font-size: 1.5rem !important;">{{__("Cerrar")}}</button>
            </div-->
        </div>
    </div>
</div>
<!-- Modal -->