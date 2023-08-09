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
                                placeholder="Raison sociale ..." style="padding: 3px;border-radius: 0;"
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

            </tbody>
        </table>
    </div>
</div>
