 <table class="ui celled striped table">
     <thead>
     </thead>
     <tbody>
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
             <td>{{ $commande->statut->designation }}</td>
         </tr>
         <tr>
             <td>
                 Date de livraison souhaitée
             </td>
             <td>{{ $commande->date_livraison_souhaitee ? Carbon\Carbon::parse($commande->date_livraison_souhaitee)->format('d/m/Y') : '' }}
             </td>
         </tr>
         <tr>
             <td>
                 Date de livraison confirmée
             </td>
             <td>
                 @can('update', [App\Models\Commande::class, $commande])
                     <div class="ui calendar" id="date_livraison_confirmee-{{ $vdata }}">
                         <div class="ui input left icon" style="width: 160px">
                             <i class="calendar icon"></i>
                             <input style="border-radius: 0;padding:6px;" type="text" name="date_livraison_confirmee"
                                 class="date_livraison_confirmee_value" placeholder="Date confirmée" readonly>
                         </div>
                     </div>
                     <div class="msgError up_date_livraison_confirmee_M"></div>
                 @endcan

                 @cannot('update', [App\Models\Commande::class, $commande])
                     {{ $commande->date_livraison_confirmee ? Carbon\Carbon::parse($commande->date_livraison_confirmee)->format('d/m/Y') : '' }}
                 @endcannot
             </td>
             {{-- <td>{{ $commande->date_livraison_confirmee }}</td> --}}
         </tr>
         <tr>
             <td colspan="2" style="background-color: #1678c2 !important; color: #fff">
                 Créé Le {{ Carbon\Carbon::parse($commande->cree_le)->format('d/m/Y') }} Par
                 {{ $commande->user?->Prenom }}
             </td>
         </tr>
     </tbody>
 </table>


 <script>
     $('#date_livraison_confirmee-{{ $vdata }}').calendar({
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
                 $(`.date_livraison_confirmee_value`).val(date_format)
                 return date_format;
             }
         },
         parser: {
             date: function(text, settings) {
                 @if ($commande->date_livraison_confirmee)
                     return new Date("{{ $commande->date_livraison_confirmee }}");
                 @endif
             }
         },
         onChange: function(date, text, mode) {
             if (date) {
                 var day = date.getDate();
                 var month = date.getMonth() + 1;
                 var year = date.getFullYear();
                 var date_format = `${day}/${month}/${year}`;
                 $(`.date_livraison_confirmee_value`).val(date_format)
                 ajax_post({
                         date_livraison_confirmee: date_format
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
             }
         },
         onHide: function() {
             $(".RefOrd").focus();
         }
     });
 </script>
