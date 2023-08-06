<div id="ui-cardplanif_{{ str_replace('/', '_', $week) }}_{{ $commande->id }}">
    <div class="ui card drag details ui-draggable ui-draggable_{{ str_replace('/', '_', $commande->id) }}"
        id="ui-draggable_{{ str_replace('/', '_', $week) }}_{{ $commande->id }}" draggable="true"
        data-week="{{ $week }}" data-client="{{ $commande->client_id }}" data-commande="{{ $commande->id }}"
        data-usine="saam" data-baril="{{ $statut }}"
        style="margin-bottom:0;border-radius:0;border-left: 5px solid {{ $commande->statut->color }}; position: relative; z-index: 999 !important;padding: 7px 15px; background: {{ $commande->statut->background }}">
        <h3 class="details-task" style=" background: {{ $commande->statut->color }}; color: #000000"
            data-week="{{ $week }}" data-client="{{ $commande->client_id }}" data-usine="saam"
            data-baril="{{ $statut }}">N°{{ $commande->id }}
        </h3>
        <div class="details-uren" data-week="{{ $week }}" data-client="{{ $commande->client_id }}"
            data-usine="saam" data-baril="{{ $statut }}">
            <div style="display:flex">
                <div style="min-width:150px; font-weight: bold;text-align: right;padding-right:14px">Statut: </div>
                <span>{{ $commande->statut->designation }}</span>
            </div>
            <div style="display:flex">
                <div style="min-width:150px; font-weight: bold;text-align: right;padding-right:14px">Liv Souhaitée:
                </div>
                {{ Carbon\Carbon::parse($commande->date_livraison_souhaitee)->format('d/m/Y') }}
            </div>
            <div style="display:flex">
                <div style="min-width:150px; font-weight: bold;text-align: right;padding-right:14px">Quantité: </div>
                {{ $commande->articles->sum('qty') }}
            </div>
            <div style="display:flex">
                <div style="min-width:150px; font-weight: bold;text-align: right;padding-right:14px">Nmbr d'articles:
                </div>
                {{ $commande->articles->count() }}
            </div>
            <div style="display:flex">
                <div style="min-width:150px; font-weight: bold;text-align: right;padding-right:14px">Liv Confirmée:
                </div>
                {{ $commande->date_livraison_confirmee ? Carbon\Carbon::parse($commande->date_livraison_confirmee)->format('d/m/Y') : '' }}
            </div>

            @switch($commande->statut_id)
                @case(2)
                    <div class="ui mini" style="margin-top: 7px">
                        <span id="up_statut_id_popup"></span>
                        <a class="item im ax_get ui button" data-ref="up_" data-color=""
                            data-message="<div style='color:#000'><i class='ui large check circle green icon'></i> Êtes-vous sûr de confirmer la commande N° ({{ $commande->id }})?</div>"
                            data-url="{{ Route('commande.update', [$commande->id]) }}?statut_id=3&week={{ $week }}&methode=savewhat&planif=true&commande"
                            data-color="#d8ea5c"
                            style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold; background: #d8ea5c; color: #000">
                            <i class=" check circle green icon"></i> Confirmer la date
                        </a>
                    </div>
                @break

                @default
            @endswitch
        </div>
    </div>
    @if ($commande->commentaire)
        <div class="ui fluid flowing popup bottom left transition hidden">
            <div class="ui middle aligned">
                {!! $commande->commentaire !!}
            </div>
        </div>
    @endif
</div>

<script>
    var targetInBox = document.querySelectorAll('.ui-draggable_{{ str_replace('/', '_', $commande->id) }}')[0];

    targetInBox.addEventListener("dragend", (event) => {
        var $__tar = document.elementFromPoint(event.x, event.y);
        var __tar_td = $__tar.closest('td');
        if (__tar_td != undefined) {
            var new_week = __tar_td.getAttribute("data-week");
            var commande = event.target.getAttribute('data-commande');
            var old_week = event.target.getAttribute('data-week');
            if (new_week != old_week && new_week != null) {
                confirm_popup(
                    `<div style='color:#000'><i class='ui large check circle green icon'></i> Êtes-vous sûr de passer la commande N° (${commande})?</div>`,
                    "", res => {
                        $(`#${old_week.replaceAll('/', '_')}_box`).html(
                            `<i class="spinner huge blue loading icon" style="margin:17px"></i>`
                        );
                        $(`#${new_week.replaceAll('/', '_')}_box`).html(
                            `<i class="spinner huge blue loading icon" style="margin:17px"></i>`
                        );

                        $(`#${old_week.replaceAll('/', '-')}_qty`).text("");
                        $(`#${new_week.replaceAll('/', '-')}_qty`).text("");
                        $(`#${old_week.replaceAll('/', '-')}_qty`).hide();
                        $(`#${new_week.replaceAll('/', '-')}_qty`).hide();

                        var client = event.target.getAttribute('data-client');
                        var usine = event.target.getAttribute('data-usine');
                        var baril = event.target.getAttribute('data-baril');
                        var _params = {
                            week: old_week,
                            new_week: new_week,
                            selfBaril: baril,
                            client: `${client}`,
                            Usine: `${usine}`
                        };
                        $.loadWeekData(_params, `/commande/planif/week/mouvement/${commande}`);
                    }
                );
            }
        }
    });
    $(function() {

        $('.ui-draggable.ui-draggable_{{ str_replace('/', '_', $commande->id) }}').popup({
            inline: true,
            hoverable: true,
            on: 'hover',
            position: 'bottom center'
        });
    })
</script>
