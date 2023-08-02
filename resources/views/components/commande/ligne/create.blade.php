<div style="margin: 17px;">
    <form class="ui small form" id="lcommmande_new_form-{{ $vdata }}">
        <input type="hidden" name="commande_id" value="{{ $commande->id }}">
        <div class="msgError commande_id_M"></div>

        <table class="ui celled striped table">
            <thead>
                <tr>
                    <th colspan="3" style="padding: 4px 11px;">
                        Articles de commande <div class="ui mini blue icon button right floated ax_get"
                            data-url="{{ Route('commande.ligne.row') }}?target=.{{ $vdata }}_lcmd_rows&client={{ $commande->client_id }}&ressourc">
                            <i class="add icon"></i>&nbsp;Ajouter
                            article
                        </div>
                    </th>
                </tr>
                <tr>
                    <th style="padding: 4px 11px;">Article</th>
                    <th style="padding: 4px 11px;">Quantité</th>
                    <th style="padding: 4px 11px;"></th>
                </tr>
            </thead>
            <tbody class="{{ $vdata }}_lcmd_rows">
                <x-commande.ligne.create-rows :client="$commande->client_id" />
            </tbody>
        </table>

        <h1></h1>
        <h1></h1>

        <div style="position: fixed; bottom:10px; text-align: center; margin-top:17px;width: 100%">
            <button class="ui mini button green submit_form  bradius-0"
                data-form="#lcommmande_new_form-{{ $vdata }}" data-action="new"
                data-url="{{ Route('commande.ligne.store') }}" type="button" style="padding: 4px 11px"><i
                    class="save outline icon"></i>
                Enregistrer puis Nouveau</button>

            <button class="ui mini button green submit_form  bradius-0"
                data-form="#lcommmande_new_form-{{ $vdata }}" data-url="{{ Route('commande.ligne.store') }}"
                type="button" style="padding: 4px 11px"><i class="save icon"></i>
                Enregistrer et fermer</button>

            <button class="ui mini button grey" type="button" style="width: 110px;padding: 4px 11px"
                data-izimodal-close="" data-izimodal-transitionout="bounceOutDown"> Annuler</button>
        </div>

    </form>
</div>
