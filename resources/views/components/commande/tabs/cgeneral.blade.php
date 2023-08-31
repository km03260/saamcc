<x-commande.buttons :commande="$commande" /> <br>
<div class="ui form form_field" data-id="{{ $commande->id }}"
    data-url="{{ Route('commande.update', $commande->id) }}?methode=savewhat&noClicked=true&commande">
    <table class="ui celled table aliceblue_table">
        <thead>
        </thead>
        <tbody>
            <tr>
                <td width="175px">
                    Commande N°
                </td>
                <td>{{ $commande->id }}</td>
            </tr>
            <tr>
                <td width="175px">
                    Client
                </td>
                <td>{{ $commande->client->raison_sociale }}</td>
            </tr>
            <tr>
                <td>
                    Statut
                </td>
                <td>
                    {{ $commande->statut->designation }}
                </td>
            </tr>
            @if (in_array($commande->statut_id, [1, 2]))
                <tr>
                    <td>
                        Date de livraison
                    </td>
                    <td>
                        @can('update', [App\Models\Commande::class, $commande])
                            <div class="ui calendar" id="date_livraison_souhaitee-{{ $vdata }}">
                                <div class="ui input left icon" style="width: 160px">
                                    <i class="calendar icon"></i>
                                    <input style="border-radius: 0;padding:6px;" type="text"
                                        name="date_livraison_souhaitee" class="date_livraison_souhaitee_value"
                                        placeholder="Date souhaitée" readonly>
                                </div>
                            </div>
                            <div class="msgError up_date_livraison_souhaitee_M"></div>
                        @endcan

                        @cannot('update', [App\Models\Commande::class, $commande])
                            {{ $commande->date_livraison_souhaitee ? Carbon\Carbon::parse($commande->date_livraison_souhaitee)->format('d/m/Y') : '' }}
                        @endcannot
                    </td>
                </tr>
            @else
                <tr>
                    <td>
                        Date de livraison
                    </td>
                    <td>
                        @can('liv_confirme', [App\Models\Commande::class, $commande])
                            <div class="ui calendar" id="date_livraison_confirmee-{{ $vdata }}">
                                <div class="ui input left icon" style="width: 160px">
                                    <i class="calendar icon"></i>
                                    <input style="border-radius: 0;padding:6px;" type="text"
                                        name="date_livraison_confirmee" class="date_livraison_confirmee_value"
                                        placeholder="Date confirmée" readonly>
                                </div>
                            </div>
                            <div class="msgError up_date_livraison_confirmee_M"></div>
                        @endcan

                        @cannot('liv_confirme', [App\Models\Commande::class, $commande])
                            {{ $commande->date_livraison_confirmee ? Carbon\Carbon::parse($commande->date_livraison_confirmee)->format('d/m/Y') : '' }}
                        @endcannot
                    </td>
                </tr>
            @endif
            @can('liv_confirme', [App\Models\Commande::class, $commande])
                <tr>
                    <td class="" style="">
                        N°Commande MagiSoft
                    </td>
                    <td>
                        <div class="ui transparent right icon big input focus" style="width: 300px">
                            <input class="up_field" type="text" data-name="ccnum" value="{{ $commande->ccnum }}"
                                placeholder="N°Commande MagiSoft ..." @if (!Gate::allows('liv_confirme', [App\Models\Commande::class, $commande])) readonly @endif
                                style="padding: 3px;border-radius: 0;
                    ">
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_ccnum_M"></div>
                    </td>
                </tr>
            @endcan
            @cannot('liv_confirme', [App\Models\Commande::class, $commande])
                @if (!in_array($commande->statut_id, [1, 2]))
                    <tr>
                        <td class="" style="">
                            N°Commande MagiSoft
                        </td>
                        <td>{{ $commande->ccnum }}</td>
                    </tr>
                @endif
            @endcannot
            <tr>
                <td>
                    Commentaire
                </td>
                <td>
                    <div class="ui  fluid right icon big input focus">
                        <textarea class="up_field" data-name="commentaire" placeholder="Commentaire ..." style="padding: 3px;border-radius: 0;"
                            rows="3">{!! $commande->commentaire !!}</textarea>
                        <i class="icon" style="margin: -2px;"></i>
                    </div>
                    <div class="msgError sw_commentaire_M"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="">
                    Créé Le {{ Carbon\Carbon::parse($commande->cree_le)->format('d/m/Y') }} Par
                    {{ $commande->user?->Prenom }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="ui divider"></div>

@include('components.commande.tabs.lignes')

<script>
    calendarHandle({
        element: '#date_livraison_souhaitee-{{ $vdata }}',
        field: `.date_livraison_souhaitee_value`,
        initialDate: @if ($commande->date_livraison_souhaitee)
            new Date("{{ $commande->date_livraison_souhaitee }}")
        @else
            null
        @endif
    }, (date) => {
        ajax_post({
                date_livraison_souhaitee: date
            }, `/commande/update/{{ $commande->id }}?methode=savewhat`, res => {
                if (res.ok) {
                    load_row(res._row.id, res._row, res.list ?? "");
                }
                if (res.error_messages) {
                    setError(res.error_messages, 'up_');
                }
            },
            err => {
                flash('Error lors de mettre à jour la date de livraison confirmée', "warning",
                    'topRight');
            });
    });

    calendarHandle({
        element: '#date_livraison_confirmee-{{ $vdata }}',
        field: `.date_livraison_confirmee_value`,
        initialDate: @if ($commande->date_livraison_confirmee)
            new Date("{{ $commande->date_livraison_confirmee }}")
        @else
            null
        @endif
    }, (date) => {
        ajax_post({
                date_livraison_confirmee: date
            }, `/commande/update/{{ $commande->id }}?methode=savewhat`, res => {
                if (res.ok) {
                    load_row(res._row.id, res._row, res.list ?? "");
                }
                if (res.error_messages) {
                    setError(res.error_messages, 'up_');
                }
            },
            err => {
                flash('Error lors de mettre à jour la date de livraison confirmée', "warning",
                    'topRight');
            });
    });
</script>
