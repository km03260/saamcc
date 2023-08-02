<div style="margin: 17px;">
    <form class="ui small form" id="client_new_form-{{ $vdata }}">

        <div class="field fieldControl type_F">
            <div class="two fields">
                <div class="two wide field" style="margin-top: auto;margin-bottom: auto;">
                    <label>Type</label>
                </div>
                <div class="four wide field">
                    <x-includes.dropdown name="type" classes="" value="client" placeholder="Sélectionner le type"
                        :vdata="$vdata" :push="false" url="{{ Route('handle.select', 'client_type') }}" />
                    <div class="msgError type_M"></div>
                </div>
            </div>
        </div>

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

        <div class="field  fieldControl adresse1_F adresse2_F">
            <div class="two fields">
                <div class="two wide field" style="margin-top: auto;margin-bottom: auto;">
                    <label>Adresse</label>
                </div>
                <div class="twelve wide fieldControl field adresse1_F ">
                    <input type="text" name="adresse1" placeholder="Adresse .." style="border-radius: 0">
                    <input type="text" name="adresse2" placeholder="Adresse .." style="border-radius: 0">
                    <div class="msgError adresse1_M"></div>
                    <div class="msgError adresse2_M"></div>
                </div>
            </div>
        </div>

        <div class="two fields">
            <div class="six wide fieldControl field cp_F">
                <div class="two fields">
                    <div class="six wide field" style="margin-top: auto;margin-bottom: auto;">
                        <label>Code postal</label>
                    </div>
                    <div class="twelve wide fieldControl field cp_F">
                        <input type="text" name="cp" placeholder="Code postale">
                        <div class="msgError cp_M"></div>
                    </div>
                </div>
            </div>

            <div class="eight wide fieldControl field ville_F">
                <div class="two fields">
                    <div class="six wide field" style="margin-top: auto;margin-bottom: auto;text-align: end;">
                        <label>Ville</label>
                    </div>
                    <div class="twelve wide fieldControl field ville_F">
                        <input type="text" name="ville" placeholder="Ville">
                        <div class="msgError ville_M"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="field wide fieldControl field pays_F">
            <div class="two fields">
                <div class="two wide field" style="margin-top: auto;margin-bottom: auto;">
                    <label>Pays</label>
                </div>
                <div class="four wide field">
                    <input type="text" name="pays" placeholder="Pays" value="France">
                    <div class="msgError pays_M"></div>
                </div>
            </div>
        </div>

        <div class="field fieldControl activite_F">
            <label>Activité</label>
            <input type="text" name="activite" placeholder="Activité" value="">
        </div>
        <div class="msgError activite_M"></div>

        <div class="field fieldControl business_F">
            <label>Business</label>
            <textarea name="business" rows="2" placeholder="Ce qu'on leur fabrique.."></textarea>
        </div>
        <div class="msgError business_M"></div>

        <div class="six wide fieldControl field code_magisoft_F">
            <label>Code Magisoft</label>
            <input type="text" name="code_magisoft" placeholder="Code Magisoft">
            <div class="msgError code_magisoft_M"></div>
        </div>

        <div class="fieldControl field siteweb_F">
            <label>Site web</label>
            <input type="text" name="siteweb" placeholder="Site web">
            <div class="msgError siteweb_M"></div>
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
