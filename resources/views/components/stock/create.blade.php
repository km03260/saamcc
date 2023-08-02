<div style="margin: 17px;">
    <form class="ui small form" id="stock_new_form-{{ $vdata }}">
        <input type="hidden" name="prospect_id" value="{{ $client_id }}">

        <div class="field fieldControl article_id_F">
            <div class="two fields">
                <div class="three wide field" style="margin-top: auto;margin-bottom: auto;">
                    <label>Article</label>
                </div>
                <div class="fourteen wide fieldControl field article_id_F">
                    <x-includes.search-drop name="article_id" classes="" value=""
                        placeholder="Sélectionner l'article" :vdata="$vdata" :push="false"
                        url="{{ Route('handle.select', 'article') }}?{{ isset($client_id) ? 'prospect_id=' . $client_id : '' }}&sources" />
                    <div class="msgError article_id_M"></div>
                </div>
            </div>
        </div>

        <div class="field fieldControl zone_id_F">
            <div class="two fields">
                <div class="three wide field" style="margin-top: auto;margin-bottom: auto;">
                </div>
                <div class="fourteen wide fieldControl field zone_id_F">
                    <table class="ui celled table">
                        <thead>
                            <tr>
                                <th style="padding: 4px 11px">
                                    Zones
                                </th>
                                <th class="center aligned" style="padding: 4px 11px">
                                    Quantité
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($zones as $zone)
                                <tr>
                                    <td>
                                        {{ $zone->libelle }}
                                    </td>
                                    <td class="center aligned p-0">
                                        <div>
                                            <input name="zones[{{ $zone->id }}]" type="number"
                                                placeholder="Quantité" style="max-width: 150px; padding:4px 11px" />
                                            <div class="msgError zones_{{ $zone->id }}_M"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="msgError zone_id_M"></div>
                </div>
            </div>
        </div>




        <h1></h1>
        <h1></h1>

        <div style="position: fixed; bottom:10px; text-align: center; margin-top:17px;width: 100%">
            <button class="ui mini button green submit_form  bradius-0" data-form="#stock_new_form-{{ $vdata }}"
                data-action="new" data-url="{{ Route('stock.store') }}" type="button" style="padding: 4px 11px"><i
                    class="save outline icon"></i>
                Enregistrer puis Nouveau</button>

            <button class="ui mini button green submit_form  bradius-0" data-form="#stock_new_form-{{ $vdata }}"
                data-url="{{ Route('stock.store') }}" type="button" style="padding: 4px 11px"><i
                    class="save icon"></i>
                Enregistrer et fermer</button>

            <button class="ui mini button grey" type="button" style="width: 110px; padding: 4px 11px"
                data-izimodal-close="" data-izimodal-transitionout="bounceOutDown"> Annuler</button>
        </div>

    </form>
</div>
