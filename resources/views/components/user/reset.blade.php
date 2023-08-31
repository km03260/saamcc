<div style="margin: 17px;">

    <form class="ui small form" id="reset_form-{{ $vdata }}">

        <div class="field fieldControl password_F">
            <div class="two fields">
                <div class="four wide field" style="margin-top: auto;margin-bottom: auto;">
                    <label>Nouveau mot de passe</label>
                </div>
                <div class="twelve wide fieldControl field password_F">
                    <input type="password" name="password" placeholder="Saisir le nouveau mot de passe ...">
                    <div class="msgError password_M"></div>
                </div>
            </div>
        </div>

        <div class="field fieldControl password_confirmation_F">
            <div class="two fields">
                <div class="four wide field" style="margin-top: auto;margin-bottom: auto;">
                    <label>Confirmer mot de passe</label>
                </div>
                <div class="twelve wide fieldControl field password_confirmation_F">
                    <input type="password" name="password_confirmation" placeholder="Confirmer mot de passe ...">
                    <div class="msgError password_confirmation_M"></div>
                </div>
            </div>
        </div>

        <h1></h1>
        <h1></h1>

        <div style="position: fixed; bottom:10px; text-align: center; margin-top:17px;width: 100%">
            <button class="ui mini button green submit_form  bradius-0" data-form="#reset_form-{{ $vdata }}"
                data-url="{{ Route('user.newPassword', $user->id) }}" type="button" style="padding: 4px 11px"><i
                    class="save icon"></i>
                Réinitialiser le mot de passe</button>

            <button class="ui mini button grey" type="button" style="width: 110px; padding: 4px 11px"
                data-izimodal-close="" data-izimodal-transitionout="bounceOutDown"> Annuler</button>
        </div>

    </form>
</div>
