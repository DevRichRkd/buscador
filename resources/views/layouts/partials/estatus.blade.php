<td>
    @if($estatus == 1)
        <i class="mdi mdi-checkbox-marked-circle-outline" style="font-size: 30px;color:green" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('activo')}} " data-custom-class="tooltip-dark"></i>
    @else
        <i class='mdi mdi-close-circle-outline' style="font-size: 30px;color:#f83e37;" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{__('inactivo')}} " data-custom-class="tooltip-dark"></i>
    @endif
</td>