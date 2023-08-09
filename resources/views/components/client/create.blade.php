<div style="margin: 17px;">
    <form class="ui small form" id="client_new_form-{{ $vdata }}">

        <div class="field fieldControl raison_sociale_F">
            <div class="two fields">
                <div class="two wide field" style="margin-top: auto;margin-bottom: auto;">
                    <label>Raison sociale</label>
                </div>
                <div class="twelve wide field">
                    <input type="text" style="text-transform:uppercase" name="raison_sociale"
                        placeholder="Raison sociale">
                    <div class="msgError raison_sociale_M"></div>
                </div>
            </div>
        </div>

        <div class="two fields fieldControl field code_magisoft_F">
            <div class="two wide field">
                <label>Code Magisoft</label>
            </div>
            <div class="twelve wide field">
                <input type="text" name="code_magisoft" placeholder="Code Magisoft">
                <div class="msgError code_magisoft_M"></div>
            </div>
        </div>

        <h1></h1>
        <h1></h1>

        <div style="position: fixed; bottom:10px; text-align: center; margin-top:17px;width: 100%">

            <button class="ui mini button green submit_form  bradius-0" data-form="#client_new_form-{{ $vdata }}"
                data-action="new" data-url="{{ Route('client.store') }}" type="button" style="padding: 4px 11px"><i
                    class="save outline icon"></i>
                Enregistrer puis Nouveau</button>

            <button class="ui mini button green submit_form  bradius-0" data-form="#client_new_form-{{ $vdata }}"
                data-url="{{ Route('client.store') }}" type="button" style="padding: 4px 11px"><i
                    class="save icon"></i>
                Enregistrer et fermer</button>

            <button class="ui mini button grey" type="button" style="width: 110px;padding: 4px 11px"
                data-izimodal-close="" data-izimodal-transitionout="bounceOutDown"> Annuler</button>
        </div>

    </form>
</div>
