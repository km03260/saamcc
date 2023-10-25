    <div class="appendInputField" style="margin: 4px 0px">
        @switch($_model->statut_id)
            @case(1)
                @can('update', [App\Models\Commande::class, $_model])
                    <a class="im ax_get ui mini green button" data-ref="up_{{ $_model->id }}_vl" data-color="#21ba45"
                        data-message="<div style='color:#fff'><i class='ui large check circle icon'></i> Êtes-vous sûr de valider  la commande N° ({{ $_model->id }})?</div>"
                        data-url="{{ Route('commande.update', [$_model->id]) }}?statut_id=2&methode=savewhat&commande"
                        style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold">
                        <i class=" check circle icon"></i> Valider la commande
                    </a>
                    <span id="up_{{ $_model->id }}_vlstatut_id_popup"></span>
                @endcan
            @break

            @case(2)
                @can('can_back_statut', [App\Models\Commande::class, $_model])
                    <span id="up_{{ $_model->id }}_rmstatut_id_popup"></span>
                    <a class="im ax_get ui mini button" data-ref="up_{{ $_model->id }}_rm" data-color=""
                        data-message="<div style='color:#000'><i class='ui large undo alternate icon'></i> Êtes-vous sûr de remettre en saisie  la commande N° ({{ $_model->id }})?</div>"
                        data-url="{{ Route('commande.update', [$_model->id]) }}?statut_id=1&methode=savewhat&commande"
                        style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold">
                        <i class=" undo alternate icon"></i> Remettre en saisie
                    </a>
                @endcan
            @break

            @default
        @endswitch

        @can('delete', [App\Models\Commande::class, $_model])
            <a class="im ax_get ui mini red button" data-url="{{ Route('commande.destroy', [$_model->id]) }}?commande"
                data-color="rgba(239, 183, 166, 0.9)"
                data-message="<i class='ui large red trash alternate icon'></i> Êtes-vous sûr de vouloir supprimer  la commande N° ({{ $_model->id }})?"
                style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold">
                <i class=" trash alternate icon"></i> Supprimer
            </a>
        @endcan

        @php
            $sc = App\Models\Scommande::whereId($_model->statut_id + 1)->first();
        @endphp

        @if ($sc)
            @can('update', [App\Models\Commande::class, $_model])
                <a class="im ax_get ui mini button" data-ref="up_{{ $_model->id }}_vl" data-color="{{ $sc->color }}"
                    data-message="<div style='color:#{{ $sc->color }}'><i class='ui large check circle icon'></i> Êtes-vous sûr de mettre la commande N° ({{ $_model->id }}) {{ $sc->designation }}?</div>"
                    data-url="{{ Route('commande.update', [$_model->id]) }}?statut_id={{ $sc->id }}&methode=savewhat&commande"
                    style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold; background-color: {{ $sc->background }}">
                    <i class=" check circle icon"></i> {{ $sc->designation }}
                </a>
                <span id="up_{{ $_model->id }}_vlstatut_id_popup"></span>
            @endcan
        @endif

        <a class="im ui mini blue button" target="_blank"
            href="{{ Route('commande.generate', [$_model->id, 'print']) }}"
            style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold">
            <i class=" print alternate icon"></i> Imprimer
        </a>
    </div>
