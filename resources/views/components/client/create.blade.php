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

        <div class="two fields fieldControl field img_F">
            <div class="two wide field">
                <label>Logo</label>
            </div>
            <div class="twelve wide field">
                <div class="blurring dimmable image" style="background: #fff">
                    <div class="ui dimmer">
                        <div class="content">
                            <div class="center">
                                <input type="file" name="img" data-type="image"
                                    data-target="photo-{{ $vdata }}" id="photo-{{ $vdata }}"
                                    style="display: none" accept="image/png, image/gif, image/jpeg">
                                <label class="ui inverted button" for="photo-{{ $vdata }}">Nouveau
                                    logo
                                </label>
                            </div>
                        </div>
                    </div>
                    <img id="img-{{ $vdata }}" style="height: 250px;width: auto;"
                        src='{{ 'assets/images/no-photo.jpg' }}'>
                </div>
                <div class="msgError img_M"></div>
            </div>
        </div>

        <h1></h1>
        <h1></h1>

        <div style="position: fixed; bottom:10px; text-align: center; margin-top:17px;width: 100%">

            <button class="ui mini button green submit_form  bradius-0" data-form="#client_new_form-{{ $vdata }}"
                data-action="new" data-url="{{ Route('client.store') }}" data-files="photo-{{ $vdata }}"
                type="button" style="padding: 4px 11px"><i class="save outline icon"></i>
                Enregistrer puis Nouveau</button>

            <button class="ui mini button green submit_form  bradius-0" data-form="#client_new_form-{{ $vdata }}"
                data-url="{{ Route('client.store') }}" data-files="photo-{{ $vdata }}" type="button"
                style="padding: 4px 11px"><i class="save icon"></i>
                Enregistrer et fermer</button>

            <button class="ui mini button grey" type="button" style="width: 110px;padding: 4px 11px"
                data-izimodal-close="" data-izimodal-transitionout="bounceOutDown"> Annuler</button>
        </div>

    </form>
</div>

<script>
    $('#client_new_form-{{ $vdata }} .image').dimmer({
        on: 'hover'
    });
    $(document).on('change', '#photo-{{ $vdata }}', function(e) {
        var _prev_photo = e.target.files[0];
        if (_prev_photo) $('#img-{{ $vdata }}').attr('src', URL.createObjectURL(
            _prev_photo));
    });
</script>
