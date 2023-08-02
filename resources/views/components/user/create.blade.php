  <div style="margin: 17px;">
      <form class="ui small form" id="user_new_form-{{ $vdata }}">
          <div class="field Nom_F fieldControl">
              <label>Nom</label>
              <input type="text" class="NomField" name="Nom" placeholder="Nom">
              <span class="Nom_M hasError msgError"></span>
          </div>

          <div class="field Prenom_F fieldControl">
              <label>Prenom</label>
              <input type="text" name="Prenom" placeholder="Prenom">
              <span class="Prenom_M hasError msgError"></span>
          </div>


          <div class="field Login_F fieldControl">
              <label>Login</label>
              <input type="text" name="Login" placeholder="Login">
              <span class="Login_M hasError msgError"></span>
          </div>


          <div class="field Tel_F fieldControl">
              <label>Tel</label>
              <input type="text" name="Tel" placeholder="Téléphone" autocomplete="off">
              <span class="Tel_M hasError msgError"></span>
          </div>

          <div class="field Tel_F fieldControl">
              <label>Email</label>
              <input type="text" name="Email" placeholder="Email" autocomplete="off">
              <span class="Email_M hasError msgError"></span>
          </div>

          @if (isset($client_id))
              <input type="hidden" name="client_id" value="{{ $client_id }}">
              <input type="hidden" name="Profil" value="8">
          @else
              <div class="field Profil_F fieldControl" style="width:260px;">
                  <label>Profil</label>
                  <x-includes.dropdown name="Profil" classes="" value="" placeholder="Sélectionner le profil"
                      :vdata="$vdata" :push="false" url="{{ Route('handle.select', 'profile') }}?&sources" />

                  <span class="Profil_M hasError msgError"></span>
              </div>
          @endif

          <div class="field Mdp_F fieldControl">
              <label>Mot de passe</label>
              <input type="password" name="Mdp" placeholder="Mot de passe" autocomplete="new-password">
              <span class="Mdp_M hasError msgError"></span>
          </div>


          <h1></h1>
          <h1></h1>

          <div style="position: fixed; bottom:10px; text-align: center; margin-top:17px;width: 100%">
              <button class="ui mini button green submit_form  bradius-0" data-form="#user_new_form-{{ $vdata }}"
                  data-action="new" data-url="{{ Route('user.store') }}" type="button" style="padding: 4px 11px"><i
                      class="save outline icon"></i>
                  Enregistrer puis Nouveau</button>

              <button class="ui mini button green submit_form  bradius-0" data-form="#user_new_form-{{ $vdata }}"
                  data-url="{{ Route('user.store') }}" type="button" style="padding: 4px 11px"><i
                      class="save icon"></i>
                  Enregistrer et fermer</button>

              <button class="ui mini button grey" type="button" style="width: 110px;padding: 4px 11px"
                  data-izimodal-close="" data-izimodal-transitionout="bounceOutDown"> Annuler</button>
          </div>

      </form>
  </div>
