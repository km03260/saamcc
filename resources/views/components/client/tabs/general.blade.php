<div class="ui form form_field form_field-{{ $vdata }}" data-id="{{ $client->id }}"
    data-url="{{ Route('client.savewhat', $client->id) }}?methode=savewhat">
    @can('delete', [App\Models\Client::class, $client])
        <i title="Supprimer" class="ui c-pointer large red trash alternate icon ax_get" style="float: right;"
            data-url='{{ Route('client.destroy', $client->id) }}' data-color="rgba(239, 183, 166, 0.9)" data-classes='inline'
            data-transitionOut='fadeInUp' data-target=".form_field"
            data-message="<i class='ui large red trash alternate icon'></i> Êtes-vous sûr de vouloir supprimer ?"></i>
    @endcan
    <div class="ten wide field">
        <table class="ui celled table">
            <tbody>

                <tr>
                    <td class="" style="background-color:#f9fafb;border-bottom: 1px solid #fff;">
                        <h5 class="ui header">Reason sociale</h5>
                    </td>
                    <td>
                        <div class="ui transparent right icon big input focus">
                            <input class="up_field" type="text" data-name="raison_sociale"
                                style="text-transform:uppercase;" value="{{ $client->raison_sociale }}"
                                placeholder="Reason sociale ..." style="padding: 3px;border-radius: 0;"
                                @if (!Gate::allows('update', [App\Models\Client::class, $client])) readonly @endif>
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_raison_sociale_M"></div>
                    </td>
                </tr>

                <tr>
                    <td class="" style="background-color:#f9fafb;border-bottom: 1px solid #fff;">
                        <h5 class="ui header">Code Magisoft</h5>
                    </td>
                    <td>
                        <div class="ui transparent right icon big input focus" style="width: 300px">
                            <input class="up_field" type="text" data-name="code_magisoft"
                                value="{{ $client->code_magisoft }}" placeholder="Code Magisoft ..."
                                @if (!Gate::allows('update', [App\Models\Client::class, $client])) readonly @endif
                                style="padding: 3px;border-radius: 0;
                    ">
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_code_magisoft_M"></div>
                    </td>
                </tr>

                <tr>
                    <td class="" style="background-color:#f9fafb;border-bottom: 1px solid #fff;">
                        <h5 class="ui header">Logo</h5>
                    </td>
                    <td>
                        <div class="field  fieldControl au_img_F">
                            <div class="ui fluid card bradius-0" style="margin: 0; border:0;">
                                <div class="blurring dimmable image" style="background: #fff">
                                    <div class="ui dimmer">
                                        <div class="content">
                                            <div class="center">
                                                <input type="file" class="up_field" data-name="img" data-type="image"
                                                    data-target="photo-{{ $vdata }}"
                                                    id="photo-{{ $vdata }}" style="display: none"
                                                    accept="image/png, image/gif, image/jpeg">
                                                <label class="ui inverted button"
                                                    for="photo-{{ $vdata }}">Nouveau
                                                    logo
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <img id="img-{{ $vdata }}" style="height: 250px;width: auto;"
                                        src='{{ asset($client->logo ? $client->logo : 'assets/images/no-photo.jpg') }}''>
                                </div>
                            </div>
                        </div>
                        <div class="msgError sw_img_M"></div>

                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<script>
    $('.form_field-{{ $vdata }} .image').dimmer({
        on: 'hover'
    });
    $(document).on('change', '#photo-{{ $vdata }}', function(e) {
        var _prev_photo = e.target.files[0];
        if (_prev_photo) $('#img-{{ $vdata }}').attr('src', URL.createObjectURL(
            _prev_photo));
    });
</script>
