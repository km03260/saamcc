<div style="margin: 17px;">
    <form class="ui small form" id="variation_new_form-{{ $vdata }}">

        @if ($client_id)
            <div class="msgError client_id_M"></div>
            <input type="hidden" name="client_id" class="{{ $vdata }}_client_value" value="{{ $client_id }}">
        @else
            <div class="field fieldControl client_id_F">
                <div class="two fields">
                    <div class="four wide field" style="margin-top: auto;margin-bottom: auto;">
                        <label>Client</label>
                    </div>
                    <div class="ten wide fieldControl field client_id_F {{ $vdata }}_client_selected">
                        <x-includes.search-drop name="client_id" classes="{{ $vdata }}_input_val" value=""
                            placeholder="Sélectionner le client" :vdata="$vdata" :push="false"
                            url="{{ Route('handle.select', 'Client') }}" />
                        <div class="msgError client_id_M"></div>
                    </div>
                </div>
            </div>
        @endif

        <div class="two fields fieldControl label_F">
            <div class="two wide field" style="margin: auto">
                <label>Libellé </label>
            </div>
            <div class="fourteen wide field">
                <input type="text" name="label" placeholder="Libellé...">
                <div class="msgError label_M"></div>
            </div>
        </div>

        <div class="two fields fieldControl value_F">
            <div class="two wide field" style="margin: auto">
                <label>Options </label>
            </div>
            <div class="fourteen wide field">
                <x-includes.dropdown name="value" classes="{{ $vdata }}_value" value=""
                    placeholder="Options possibles" :vdata="$vdata" :push="false"
                    url="{{ Route('handle.select', 'empty') }}" :allowAdditions="true" styles="" :multiple="true" />
                <div class="msgError value_M"></div>
            </div>
        </div>


    </form>
</div>

<h1></h1>
<h1></h1>

<div style="position: fixed; bottom:10px; text-align: center; margin-top:17px;width: 100%">

    <button class="ui mini button green submit_form  bradius-0" data-form="#variation_new_form-{{ $vdata }}"
        data-action="new" data-url="{{ Route('variation.store') }}" type="button" style="padding: 4px 11px"><i
            class="save outline icon"></i>
        Enregistrer puis Nouveau</button>

    <button class="ui mini button green submit_form  bradius-0" data-form="#variation_new_form-{{ $vdata }}"
        data-url="{{ Route('variation.store') }}" type="button" style="padding: 4px 11px"><i class="save icon"></i>
        Enregistrer et fermer</button>


    <button class="ui mini button grey" type="button" style="width: 110px;padding: 4px 11px" data-izimodal-close=""
        data-izimodal-transitionout="bounceOutDown"> Annuler</button>
</div>
