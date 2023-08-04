@switch($_model->statut_id)
    @case(1)
        <div class="ui mini button yellow ax_get"
            style="box-shadow: 0px 0px 0px 1px #ffdf05 !important; min-width:100px; padding: 5px 11px"
            data-url="{{ Route('commande.update', [$_model->id]) }}?statut_id=2&methode=savewhat&suivi=true&commande">Valider
        </div>
    @break

    @case(2)
        <div class="ui mini button olive ax_get"
            style="box-shadow: 0px 0px 0px 1px #d8ea5c !important; min-width:100px; padding: 5px 11px"
            data-url="{{ Route('commande.update', [$_model->id]) }}?statut_id=3&methode=savewhat&suivi=true&commande">Prise
            en
            compte</div>
    @break

    @case(3)
        <div class="ui mini button green ax_get"
            style="box-shadow: 0px 0px 0px 1px #22be34 !important; min-width:100px; padding: 5px 11px"
            data-url="{{ Route('commande.update', [$_model->id]) }}?statut_id=4&methode=savewhat&suivi=true&commande">Traiter
        </div>
    @break

    @case(4)
        <div class="ui mini button blue ax_get"
            style="box-shadow: 0px 0px 0px 1px #3ac0ff !important; min-width:100px; padding: 5px 11px"
            data-url="{{ Route('commande.update', [$_model->id]) }}?statut_id=5&methode=savewhat&suivi=true&commande">Terminer
        </div>
    @break

    @case(5)
        <span style="color: green">
            Terminée
        </span>
    @break

    @default
@endswitch
