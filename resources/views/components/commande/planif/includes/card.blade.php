<div id="ui-cardplanif_{{ str_replace('/', '_', $week) }}_{{ $commande->id }}">
    <div class="ui card drag details ui-draggable ui-draggable_{{ str_replace('/', '_', $commande->id) }}"
        id="ui-draggable_{{ str_replace('/', '_', $week) }}_{{ $commande->id }}" draggable="true"
        data-week="{{ $week }}" data-client="{{ $commande->client_id }}" data-commande="{{ $commande->id }}"
        data-usine="saam" data-baril="{{ $statut }}"
        style="margin-bottom:0;border-radius:0;border-left: 5px solid {{ $commande->statut->color }}; position: relative; z-index: 999 !important;padding: 7px 15px; background: {{ $commande->statut->background }}">
        <h3 class="details-task target-popup_{{ str_replace('/', '_', $commande->id) }}"
            style=" background: {{ $commande->statut->color }}; color: #000000" data-week="{{ $week }}"
            data-client="{{ $commande->client_id }}" data-usine="saam" data-baril="{{ $statut }}">
            N°{{ $commande->id }}
            <span id="info_{{ $commande->id }}">
                @include('components.commande.planif.includes.info')
            </span>
        </h3>
        <div class="details-uren" data-week="{{ $week }}" data-client="{{ $commande->client_id }}"
            data-usine="saam" data-baril="{{ $statut }}">
            <div style="display:flex">
                <div style="min-width:150px; font-weight: bold;text-align: right;padding-right:14px">Statut: </div>
                <span>{{ $commande->statut->designation }}</span>
            </div>
            <div style="display:flex">
                <div style="min-width:150px; font-weight: bold;text-align: right;padding-right:14px">Date livraison:
                </div>
                {{ $commande->date_livraison_confirmee ? Carbon\Carbon::parse($commande->date_livraison_confirmee)->format('d/m/Y') : '' }}
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
            <x-commande.planif.includes.statut-button :commande="$commande" />
        </div>
    </div>
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
        }
    });

    $(function() {

        $('.ui-popup_{{ str_replace('/', '_', $commande->id) }}').popup({
            on: 'click',
            target: $('.target-popup_{{ str_replace('/', '_', $commande->id) }}'),
            exclusive: true,
            hoverable: true,
            position: 'bottom center',
            html: `<i class="big spinner loading blue icon"></i>`,
            variation: 'wide',
            setFluidWidth: true,
            delay: {
                show: 400,
                hide: 2200
            },
            onShow: function(el) {

                // $('.ui.popup').hide(150);
                // $('#of-action-tab').remove();
                // $('.ui.popup').removeClass('visible');

                resizePopup();
                var popup = this;
                popup.css('width', '100% !important')
                popup.html(`<i class="big spinner loading blue icon"></i>`);

                $.ajax({
                    url: `/handle/render?com=comment-popup&model=commande&key={{ $commande->id }}&commande`
                }).done(function(result) {
                    popup.html(result.render);
                }).fail(function() {
                    popup.html(
                        '<i style="color:red;">Erreur lors du chargement les details de commande N°({{ $commande->id }}) </i>'
                    );
                });
            },
            onHide: function(el) {
                // return false;
            }
        });
    })
</script>
