@if($errors->has($campo))
    <span style="color:red;font-size:11px">
        {{ '* '.$errors->first($campo)}}
    </span>
@endif