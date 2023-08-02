<div style="margin: 17px;">
    <form class="ui small form" id="article_new_form-{{ $vdata }}">
        @if ($client_id)
            <input type="hidden" name="prospect_id" value="{{ $client_id }}">
        @else
            <div class="two fields">
                <div class="three wide field" style="margin-top: auto;margin-bottom: auto;">
                    <label>Client</label>
                </div>
                <div class="ten wide fieldControl field prospect_id_F">
                    <x-includes.search-drop name="prospect_id" classes="" value=""
                        placeholder="Sélectionner le client" :vdata="$vdata" :push="false"
                        url="{{ Route('handle.select', 'Client') }}" />
                </div>
            </div>
        @endif
        <div class="msgError prospect_id_M"></div>
        <div class="field fieldControl ref_F">
            <div class="two fields">
                <div class="three wide field" style="margin-top: auto;margin-bottom: auto;">
                    <label>Référence</label>
                </div>
                <div class="ten wide field">
                    <input type="text" name="ref" placeholder="Référence">
                    <div class="msgError ref_M"></div>
                </div>
            </div>
        </div>

        <div class="two fields">
            <div class="three wide field" style="margin-top: auto;margin-bottom: auto;">
                <label>Désignation</label>
            </div>
            <div class="thirteen wide fieldControl field designation_F">
                <input type="text" name="designation" placeholder="Désignation">
                <div class="msgError designation_M"></div>
            </div>
        </div>

        <div class="two fields">
            <div class="three wide field" style="margin-top: auto;margin-bottom: auto;">
                <label>Prix HT</label>
            </div>
            <div class="four wide fieldControl field puht_F">
                <input type="number" step="0.01" name="puht" placeholder="Prix HT">
                <div class="msgError puht_M"></div>
            </div>
        </div>

        <h1></h1>
        <h1></h1>

        <div style="position: fixed; bottom:10px; text-align: center; margin-top:17px;width: 100%">
            <button class="ui mini button green submit_form  bradius-0"
                data-form="#article_new_form-{{ $vdata }}" data-action="new"
                data-url="{{ Route('article.store') }}" type="button" style="padding: 4px 11px"><i
                    class="save outline icon"></i>
                Enregistrer puis Nouveau</button>

            <button class="ui mini button green submit_form  bradius-0"
                data-form="#article_new_form-{{ $vdata }}" data-url="{{ Route('article.store') }}" type="button"
                style="padding: 4px 11px"><i class="save icon"></i>
                Enregistrer et fermer</button>

            <button class="ui mini button grey" type="button" style="width: 110px;padding: 4px 11px"
                data-izimodal-close="" data-izimodal-transitionout="bounceOutDown"> Annuler</button>
        </div>

    </form>
</div>
