<table class="ui datatable table" style="margin: 0 !important">
    <tr>
        <td class="padding:5px 11px;">
            <div style="display:flex; justify-content: space-between; align-items: center;">
                <div style='color:#000'><i class='ui large check circle green icon'></i> Êtes-vous sûr de
                    confirmer la
                    commande N°
                    ({{ $_model->id }})? &nbsp,
                </div>

                @can('liv_confirme', [$_model::class, $_model])
                    <div class="ui calendar" id="date_livraison_confirmee-{{ $kdata }}">
                        <div class="ui input left icon" style="width: 160px">
                            <i class="calendar icon"></i>
                            <input style="border-radius: 0;padding:6px;" type="text" name="date_livraison_confirmee"
                                class="date_livraison_confirmee_value" placeholder="Date confirmée" readonly>
                            <input type="hidden" name="date_liv_confirmee" class="date_liv_confirm-{{ $kdata }}">
                        </div>
                    </div>
                    <div class="msgError up_date_livraison_confirmee_M"></div>
                @endcan
                @php
                    $_week = Carbon\Carbon::parse($_model->date_livraison_confirmee)
                        ->startOfWeek(Carbon\Carbon::MONDAY)
                        ->format('W/Y');
                @endphp
                <div>
                    <div class="ui mini green button ax_get" style="padding:4px 11px; font-size:15px"
                        data-url="{{ Route('commande.update', [$_model->id]) }}?statut_id=3&methode=savewhat&planif=true&noClicked=true&week={{ $_week }}&commande"
                        data-inputs=".date_liv_confirm-{{ $kdata }}">Oui</div>
                    <div class="ui mini button" data-izimodal-close="" data-izimodal-transitionout="bounceOutDown"
                        style="padding:4px 11px; font-size:15px">Non
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>


<script>
    calendarHandle({
        element: '#date_livraison_confirmee-{{ $kdata }}',
        field: `.date_livraison_confirmee_value`,
        initialDate: @if ($_model->date_livraison_confirmee)
            new Date("{{ $_model->date_livraison_confirmee }}")
        @else
            null
        @endif
    }, (date) => {
        $('.date_liv_confirm-{{ $kdata }}').val(date)
    });
</script>
