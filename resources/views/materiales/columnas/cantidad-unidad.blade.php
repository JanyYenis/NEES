@php
    $color = $concepto?->color ?? '';
    $icono = $concepto?->icono ?? '';
    $nombreConcepto = $concepto?->nombre ?? '';
@endphp
<div class="d-flex align-items-center gap-2">
    <strong>{{ $cantidad ?? 0 }}</strong>
    <div class="text-lg-center">
        <span class="badge badge-light-{{$color}} py-5 px-5">
            @if ($icono)
                <i class="{{$icono}} text-{{$color}}"></i>&nbsp;
            @endif
            @if ($concepto?->codigo == 8)
                {{ initcap($unidad_personalizada) }}
            @else
                {{ initcap($nombreConcepto) }}
            @endif
        </span>
    </div>
</div>
