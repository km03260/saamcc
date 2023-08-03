{{-- <div class="field fieldControl fieldControl field statut_id_F">
    <div class="two fields">
        <div class="four wide field" style="margin-top: auto;margin-bottom: auto;">
            <label>Statut</label>
        </div>
        <div class="five wide field">
            <x-includes.dropdown name="statut_id" classes="" value="1" placeholder="Sélectionner statut"
                :vdata="$vdata" :push="false" url="{{ Route('handle.select', 'scommande') }}" />
            <div class="msgError statut_id_M"></div>
        </div>
    </div>
</div> --}}

<div class="two fields">
    <div class="four wide field" style="margin-top: auto;margin-bottom: auto;">
        <label> Date de Livraison Souhaitée </label>
    </div>
    <div class="five wide fieldControl field date_livraison_souhaitee_F">
        <div class="ui calendar calendar_field">
            <div class="ui input left icon">
                <i class="calendar icon"></i>
                <input type="text" class="date_field" name="date_livraison_souhaitee"
                    style="font-size: 17px;padding:4px" placeholder=" Date de Livraison Souhaitée " readonly>
            </div>
        </div>
        <div class="msgError date_livraison_souhaitee_M"></div>
    </div>
</div>

{{-- <div class="two fields">
    <div class="four wide field" style="margin-top: auto;margin-bottom: auto;">
        <label> Date de Livraison Confirmée </label>
    </div>
    <div class="five wide fieldControl field date_livraison_confirmee_F">
        <div class="ui calendar calendar_field">
            <div class="ui input left icon">
                <i class="calendar icon"></i>
                <input type="text" class="date_field" name="date_livraison_confirmee" style="font-size: 17px"
                    placeholder=" Date de Livraison Confirmée " readonly>
            </div>
        </div>
        <div class="msgError date_livraison_confirmee_M"></div>
    </div>
</div> --}}
<br>
<table class="ui celled striped table">
    <thead>
        <tr>
            <th colspan="3" style="padding: 4px 11px;">
                Articles de commande <div class="ui mini blue icon button right floated ax_get"
                    data-inputs=".{{ $vdata }}_lcmd_rows input[type='hidden']:not(.prompt,.refer)"
                    data-url="{{ Route('commande.ligne.row') }}?target=.{{ $vdata }}_lcmd_rows&client={{ $client_id }}&ressourc">
                    <i class="add icon"></i>&nbsp;Ajouter
                    article
                </div>
            </th>
        </tr>
        <tr>
            <th style="padding: 4px 11px;">Article</th>
            <th style="padding: 4px 11px;">Quantité</th>
            <th style="padding: 4px 11px;"></th>
        </tr>
    </thead>
    <tbody class="{{ $vdata }}_lcmd_rows">
        <x-commande.ligne.create-rows :client="$client_id" />
    </tbody>
</table>

<script>
    $('.calendar_field').calendar({
        type: 'date',
        today: true,
        firstDayOfWeek: 1,
        showWeekNumbers: true,
        text: {
            days: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre',
                'Octobre', 'Novembre', 'Decembre'
            ],
            monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
            today: 'Aujourd\'hui',
            now: 'Maintenant',
            am: 'AM',
            pm: 'PM',
            weekNo: 'Semaine'
        },
        formatter: {
            date: function(date, settings) {
                if (!date) return '';
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                var date_format = `${day}/${month}/${year}`;
                return date_format;
            }
        },
        parser: {
            date: function(text, settings) {}
        },
        onChange: function(date, text, mode) {
            if (date) {
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                var date_format = `${day}/${month}/${year}`;
                return date_format
            }
        },
        onHide: function() {
            // $(".RefOrd").focus();
        }
    });
</script>
