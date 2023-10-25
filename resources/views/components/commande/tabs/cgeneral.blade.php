<div style="padding:7px">
    {{-- <x-commande.buttons :commande="$commande" /> <br> --}}
    <div class="ui form form_field" data-id="{{ $commande->id }}"
        data-url="{{ Route('commande.update', $commande->id) }}?methode=savewhat&noClicked=true&commande">
        <table class="ui celled table aliceblue_table" style="border:0">
            <thead>
            </thead>
            <tbody>
                @if (Gate::allows('update', [App\Models\Commande::class, $commande]) ||
                        Gate::allows('liv_confirme', [App\Models\Commande::class, $commande]))
                    @if (in_array($commande->statut_id, [1, 2]))
                        <tr>
                            <td>
                                Semaine de livraison
                            </td>
                            <td style="border:0">
                                @can('update', [App\Models\Commande::class, $commande])
                                    <div class="ui calendar sem_liv_calendar-{{ $vdata }}"
                                        id="date_livraison_souhaitee-{{ $vdata }}">
                                        <div class="ui transparent input left icon" style="width: 160px">
                                            <i class="calendar icon"></i>
                                            <input style="border-radius: 0;padding:6px;" type="text"
                                                placeholder="Date souhaitée" readonly>
                                        </div>
                                    </div>
                                    <input style="border-radius: 0;padding:6px;" type="hidden"
                                        name="date_livraison_souhaitee" class="date_livraison_value-{{ $vdata }}"
                                        placeholder="Date confirmée" readonly>
                                    <div class="msgError up_date_livraison_souhaitee_M"></div>
                                @endcan

                                @cannot('update', [App\Models\Commande::class, $commande])
                                    {{ $commande->date_livraison_souhaitee ? Carbon\Carbon::parse($commande->date_livraison_souhaitee)->format('W/Y') : '' }}
                                @endcannot
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>
                                Semaine de livraison
                            </td>
                            <td style="border:0">
                                @can('liv_confirme', [App\Models\Commande::class, $commande])
                                    <div class="ui calendar sem_liv_calendar-{{ $vdata }}"
                                        id="date_livraison_confirmee-{{ $vdata }}">
                                        <div class="ui transparent input left icon" style="width: 160px">
                                            <i class="calendar icon"></i>
                                            <input style="border-radius: 0;padding:6px;" type="text"
                                                placeholder="Date confirmée" readonly>
                                        </div>
                                    </div>
                                    <input style="border-radius: 0;padding:6px;" type="hidden"
                                        name="date_livraison_confirmee" class="date_livraison_value-{{ $vdata }}"
                                        placeholder="Date confirmée" readonly>
                                    <div class="msgError up_date_livraison_confirmee_M"></div>
                                @endcan

                                @cannot('liv_confirme', [App\Models\Commande::class, $commande])
                                    {{ $commande->date_livraison_confirmee ? Carbon\Carbon::parse($commande->date_livraison_confirmee)->format('W/Y') : '' }}
                                @endcannot
                            </td>
                        </tr>
                    @endif
                @endif


                @can('liv_confirme', [App\Models\Commande::class, $commande])
                    <tr>
                        <td>
                            N°Commande MagiSoft
                        </td>
                        <td style="border:0">
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
                            <td>
                                N°Commande MagiSoft
                            </td>
                            <td style="border:0">{{ $commande->ccnum }}</td>
                        </tr>
                    @endif
                @endcannot

                @can('ncmdcli', [App\Models\Commande::class, $commande])
                    <tr>
                        <td>
                            N°Commande Client
                        </td>
                        <td style="border:0">
                            <div class="ui transparent right icon big input focus" style="width: 300px">
                                <input class="up_field" type="text" data-name="ncmd_cli"
                                    value="{{ $commande->ncmd_cli }}" placeholder="N°Commande Client ..."
                                    @if (!Gate::allows('ncmdcli', [App\Models\Commande::class, $commande])) readonly @endif
                                    style="padding: 3px;border-radius: 0;
                        ">
                                <i class="icon" style="margin: -2px;"></i>
                            </div>
                            <div class="msgError sw_ccnum_M"></div>
                        </td>
                    </tr>
                @endcan

                @can('ncmdcli', [App\Models\Commande::class, $commande])
                    <tr>
                        <td>
                            Intitulé
                        </td>
                        <td style="border:0">
                            <div class="ui transparent right icon big input focus" style="width: 300px">
                                <input class="up_field" type="text" data-name="intitule"
                                    value="{{ $commande->intitule }}" placeholder="Intitulé ..."
                                    @if (!Gate::allows('ncmdcli', [App\Models\Commande::class, $commande])) readonly @endif
                                    style="padding: 3px;border-radius: 0;
                        ">
                                <i class="icon" style="margin: -2px;"></i>
                            </div>
                            <div class="msgError sw_ccnum_M"></div>
                        </td>
                    </tr>
                @endcan

                <tr>
                    <td width="160px">
                        Commentaire
                    </td>
                    <td style="border:0">
                        <div class="ui  fluid right icon big input focus">
                            <textarea class="up_field" data-name="commentaire" placeholder="Commentaire ..."
                                style="padding: 3px;border-radius: 0;border:0" rows="2">{!! $commande->commentaire !!}</textarea>
                            <i class="icon" style="margin: -2px;"></i>
                        </div>
                        <div class="msgError sw_commentaire_M"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @include('components.commande.tabs.lignes')
    <small style="font-size:10px; color: rgb(182, 176, 176)">
        Créé Le {{ Carbon\Carbon::parse($commande->cree_le)->format('d/m/Y') }} @if (!Gate::allows('is_client', [App\Models\User::class]))
            Par {{ $commande->user?->Prenom }}
        @endif
    </small>
</div>

<script>
    calendarHandle({
        element: '#date_livraison_souhaitee-{{ $vdata }}',
        field: `.date_livraison_value-{{ $vdata }}`,
        format: 'W/YYYY',
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
        field: `.date_livraison_value-{{ $vdata }}`,
        format: 'W/YYYY',
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
