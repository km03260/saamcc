<div class="appendInputField">
    @can('delete', [App\Models\Commande::class, $commande])
        <div class="ui mini compact inverted red menu" style="margin-right: 7px">
            <a class="item im ax_get ui button" data-url="{{ Route('commande.destroy', [$commande->id]) }}?commande"
                data-color="rgba(239, 183, 166, 0.9)"
                data-message="<i class='ui large red trash alternate icon'></i> Êtes-vous sûr de vouloir supprimer  la commande N° ({{ $commande->id }})?"
                style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold">
                <i class=" trash alternate icon"></i> Supprimer
            </a>
        </div>
    @endcan

    <div class="ui mini compact inverted blue menu" style="margin-right: 7px">
        <a class="item im"
            style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold">
            <i class=" print alternate icon"></i> Imprimer
        </a>
    </div>

    @switch($commande->statut_id)
        @case(1)
            @can('update', [App\Models\Commande::class, $commande])
                <div class="ui mini compact inverted green menu" style="margin-right: 7px">
                    <span id="up_statut_id_popup"></span>
                    <a class="item im ax_get ui button" data-ref="up_" data-color="#21ba45"
                        data-message="<div style='color:#fff'><i class='ui large check circle icon'></i> Êtes-vous sûr de valider  la commande N° ({{ $commande->id }})?</div>"
                        data-url="{{ Route('commande.update', [$commande->id]) }}?statut_id=2&methode=savewhat&commande"
                        style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold">
                        <i class=" check circle icon"></i> Valider la commande
                    </a>
                </div>
            @endcan
        @break

        @case(2)
            @can('can_back_statut', [App\Models\Commande::class, $commande])
                <div class="ui mini compact inverted grey menu" style="margin-right: 7px">
                    <span id="up_statut_id_popup"></span>
                    <a class="item im ax_get ui button" data-ref="up_" data-color=""
                        data-message="<div style='color:#000'><i class='ui large undo alternate icon'></i> Êtes-vous sûr de remettre en saisie  la commande N° ({{ $commande->id }})?</div>"
                        data-url="{{ Route('commande.update', [$commande->id]) }}?statut_id=1&methode=savewhat&commande"
                        style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold">
                        <i class=" undo alternate icon"></i> Remettre en saisie
                    </a>
                </div>
            @endcan
        @break

        @default
    @endswitch
</div>
