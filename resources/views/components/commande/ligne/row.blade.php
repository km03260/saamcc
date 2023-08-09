 <tr>
     <td>
         <x-includes.search-drop name="articles[{{ $vdata }}][id]" classes="" value=""
             placeholder="Sélectionner l'article" :vdata="$vdata" :push="false"
             url="{{ Route('handle.select', 'article') }}?prospect_id={{ $client->id }}&ids={{ $ids ?? '' }}&notin={{ $notIn ?? '' }}&add=true&sources" />
         <div class="msgError articles_{{ $vdata }}_id_M"></div>
         @php
             $_vbody = $client->variations()->first();
             $_vhead =
                 $client->variations()->count() == 2
                     ? $client
                         ->variations()
                         ->latest()
                         ->first()
                     : null;
         @endphp
         @if ($client->variations()->count() > 0)
             <table class="ui celled table">
                 <thead>
                     <tr>
                         <th></th>
                         @if ($_vhead)
                             @foreach (explode(',', $_vhead->value) as $_ver)
                                 <th class="center aligned" style="padding: 5px 11px">{{ $_ver }}</th>
                             @endforeach
                         @else
                             <th class="center aligned" style="padding: 5px 11px"></th>
                         @endif
                         <th class="center aligned" width="150px" style="padding: 5px 11px">Quantité</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach (explode(',', $_vbody->value) as $_verb)
                         <tr>
                             <th class="center aligned">{{ $_verb }}</th>
                             @if ($_vhead)
                                 @foreach (explode(',', $_vhead->value) as $_ver)
                                     <td class="center aligned">
                                         <div class="ui radio checkbox">
                                             <input type="radio"
                                                 name="articles[{{ $vdata }}][variation][{{ $_verb }}][value]"
                                                 value="{{ $_ver }}">
                                             <label></label>
                                         </div>
                                     </td>
                                 @endforeach
                             @else
                                 <td class="center aligned">
                                     <div class="ui radio checkbox">
                                         <input type="radio"
                                             name="articles[{{ $vdata }}][variation][{{ $_verb }}][0]"
                                             value="variation">
                                         <label></label>
                                     </div>
                                 </td>
                             @endif
                             <td>
                                 <input type="number"
                                     name="articles[{{ $vdata }}][variation][{{ $_verb }}][qty]"
                                     placeholder="Quantité">
                                 <div class="msgError articles_{{ $vdata }}_qty_M"></div>
                             </td>
                         </tr>
                     @endforeach
                 </tbody>
             </table>
         @endif
     </td>
     @if ($client->variations()->count() == 0)
         <td>
             <input type="number" name="articles[{{ $vdata }}][variation][0][qty]" placeholder="Quantité">
             <div class="msgError articles_{{ $vdata }}_qty_M"></div>
         </td>
     @endif
     <td width="50px">
         <i class="trash alternate large icon red drop_row c-pointer"></i>
     </td>
 </tr>
