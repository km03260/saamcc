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
             <td>
                 @can('update', [App\Models\Commande::class, $commande])
                     <div class="ui calendar" id="date_livraison_souhaitee-{{ $vdata }}">
                         <div class="ui input left icon" style="width: 160px">
                             <i class="calendar icon"></i>
                             <input style="border-radius: 0;padding:6px;" type="text" name="date_livraison_souhaitee"
                                 class="date_livraison_souhaitee_value" placeholder="Date confirmée" readonly>
                         </div>
                     </div>
                     <div class="msgError up_date_livraison_souhaitee_M"></div>
                 @endcan

                 @cannot('update', [App\Models\Commande::class, $commande])
                     {{ $commande->date_livraison_souhaitee ? Carbon\Carbon::parse($commande->date_livraison_souhaitee)->format('d/m/Y') : '' }}
                 @endcannot
             </td>
         </tr>
         <tr>
             <td>
                 Date de livraison confirmée
             </td>
             <td>
                 @can('liv_confirme', [App\Models\Commande::class, $commande])
                     <div class="ui calendar" id="date_livraison_confirmee-{{ $vdata }}">
                         <div class="ui input left icon" style="width: 160px">
                             <i class="calendar icon"></i>
                             <input style="border-radius: 0;padding:6px;" type="text" name="date_livraison_confirmee"
                                 class="date_livraison_confirmee_value" placeholder="Date confirmée" readonly>
                         </div>
                     </div>
                     <div class="msgError up_date_livraison_confirmee_M"></div>
                 @endcan

                 @cannot('liv_confirme', [App\Models\Commande::class, $commande])
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
