<div class="ui form form_field" data-id="{{ $client->id }}"
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
                        <h5 class="ui header">Raison sociale</h5>
                    </td>
                    <td>
                        <div class="ui transparent right icon big input focus">
                            <input class="up_field" type="text" data-name="raison_sociale"
                                style="text-transform:uppercase;" value="{{ $client->raison_sociale }}"
                                placeholder="Raison sociale ..."
                                style="padding: 3px;border-radius: 0;
                    ">
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_raison_sociale_M"></div>
                    </td>
                </tr>
                @can('create', [App\Models\Client::class])
                    <tr>
                        <td class="" style="background-color:#f9fafb;border-bottom: 1px solid #fff;">
                            <h5 class="ui header">Type</h5>
                        </td>
                        <td style="padding: 0 1px 0 0 !important;">
                            <x-includes.dropdown name="type" classes="up_field" value="{{ $client->type }}"
                                text="{{ $client->type }}" placeholder="Sélectionner le type" :vdata="$vdata"
                                styles="border:0;" :push="false" :minCharacters="0"
                                url="{{ Route('handle.select', 'client_type') }}" />
                            <div class="msgError sw_type_M"></div>
                        </td>
                    </tr>
                @endcan
                <tr>
                    <td class="" style="background-color:#f9fafb;border-bottom: 1px solid #fff;">
                        <h5 class="ui header">Activité</h5>
                    </td>
                    <td>
                        <div class="ui transparent right icon big input focus">
                            <input class="up_field" type="text" data-name="activite" value="{{ $client->activite }}"
                                placeholder="Activité ..." style="padding: 3px;border-radius: 0;
                    ">
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_activite_M"></div>
                    </td>
                </tr>

                <tr>
                    <td class="" style="background-color:#f9fafb;border-bottom: 1px solid #fff;">
                        <h5 class="ui header">Business</h5>
                    </td>
                    <td style="padding: 0 !important;">
                        <div class="ui right icon big input focus">
                            <textarea name="business" class="up_field" data-name="business" rows="2" style="border:0"
                                placeholder="Ce qu'on leur fabrique">{!! $client->business !!}</textarea>
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_business_M"></div>
                    </td>
                </tr>

                <tr>
                    <td class="" style="background-color:#f9fafb;border-bottom: 1px solid #fff;">
                        <h5 class="ui header">Adresse</h5>
                    </td>
                    <td>
                        <div class="ui transparent right icon big input focus">
                            <input class="up_field" type="text" data-name="adresse1" value="{{ $client->adresse1 }}"
                                placeholder="Adresse ..." style="padding: 3px;border-radius: 0;
                      ">
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="ui divider"></div>
                        <div class="ui transparent right icon big input focus">
                            <input class="up_field" type="text" data-name="adresse2" value="{{ $client->adresse2 }}"
                                placeholder="Adresse ..." style="padding: 3px;border-radius: 0;
                      ">
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_adresse1_M"></div>
                        <div class="msgError sw_adresse2_M"></div>
                    </td>
                </tr>

                <tr>
                    <td class="" style="background-color:#f9fafb;border-bottom: 1px solid #fff;">
                        <h5 class="ui header">Code postal</h5>
                    </td>
                    <td>
                        <div class="ui transparent right icon big input focus" style="width: 200px">
                            <input class="up_field" type="text" data-name="cp" value="{{ $client->cp }}"
                                placeholder="Code postal ..."
                                style="padding: 3px;border-radius: 0;
                    ">
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_cp_M"></div>
                    </td>
                </tr>

                <tr>
                    <td class="" style="background-color:#f9fafb;border-bottom: 1px solid #fff;">
                        <h5 class="ui header">Ville</h5>
                    </td>
                    <td>
                        <div class="ui transparent right icon big input focus" style="width: 300px">
                            <input class="up_field" type="text" data-name="ville" value="{{ $client->ville }}"
                                placeholder="Ville ..." style="padding: 3px;border-radius: 0;
                    ">
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_ville_M"></div>
                    </td>
                </tr>

                <tr>
                    <td class="" style="background-color:#f9fafb;border-bottom: 1px solid #fff;">
                        <h5 class="ui header">Pays</h5>
                    </td>
                    <td>
                        <div class="ui transparent right icon big input focus" style="width: 300px">
                            <input class="up_field" type="text" data-name="pays" value="{{ $client->pays }}"
                                placeholder="Pays ..." style="padding: 3px;border-radius: 0;
                    ">
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_pays_M"></div>
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
                                style="padding: 3px;border-radius: 0;
                    ">
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_code_magisoft_M"></div>
                    </td>
                </tr>

                <tr>
                    <td class="" style="background-color:#f9fafb;border-bottom: 1px solid #fff;">
                        <h5 class="ui header">site web</h5>
                    </td>
                    <td>
                        <div class="ui transparent right icon big input focus">
                            <input class="up_field" type="text" data-name="siteweb"
                                value="{{ $client->siteweb }}" placeholder="site web ..."
                                style="padding: 3px;border-radius: 0;
                    ">
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_siteweb_M"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
