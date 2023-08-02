<div style="padding: 3px; width:100%; text-align: center" class="action_di-{{ $vdata }}-{{ $key }}">

    @if (isset($E))
        <i class="ui c-pointer large blue edit icon load-model" data-url='{{ Route("$model.edit", $key) }}'
            data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;'>
                    &nbsp;Modifier {{ Str::singular($model) != 'suivi' ? Str::singular($model) : 'la note' }}</span>"
            data-color="rgb(112, 142, 164) none repeat scroll 0% 0%"
            data-width="@if (isset($width))
{{ $width }}
@else
400
@endif"></i>
    @endif

    @if (isset($D))
        <i class="ui c-pointer large red trash alternate icon ax_get" data-url='{{ Route("$model.destroy", $key) }}'
            data-color="rgba(239, 183, 166, 0.9)" data-classes='inline' data-transitionOut='bounceInUp'
            data-target=".action_di-{{ $vdata }}-{{ $key }}"
            data-message="<i class='ui large red trash alternate icon'></i> Êtes-vous sûr de vouloir supprimer ?"></i>
    @endif

    @if (isset($V))
        <i class="large folder yellow icon c-pointer open_child_{{ $vdata }}" data-position="top right"
            data-id="{{ $key }}" data-content="Afficher les détails"></i>
    @endif
</div>
