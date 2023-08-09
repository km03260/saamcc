 <tr>
     <td>
         <x-includes.dropdown name="articles[{{ $vdata }}][id]" classes="" value=""
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
             <table class="ui collapsing celled striped table">
                 @if ($_vhead)
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
                         </tr>
                     </thead>
                 @endif
                 <tbody>
                     @foreach (explode(',', $_vbody->value) as $_verb)
                         <tr>
                             <th class="center aligned"
                                 style="padding: 5px 11px;background: #f9fafb;border: 1px solid #cccccc47;">
                                 {{ $_verb }}</th>
                             @if ($_vhead)
                                 @foreach (explode(',', $_vhead->value) as $_ver)
                                     <td class="center aligned" style="padding: 4px 2px;border: 1px solid #cccccc47;">
                                         <div class="ui transparent input">
                                             <input type="number" placeholder="Quantité"
                                                 style="text-align: right; font-weight: bold;font-size: 15px;"
                                                 name="articles[{{ $vdata }}][variation][{{ $_verb }}][{{ $_ver }}]"
                                                 value="">
                                         </div>
                                     </td>
                                 @endforeach
                             @else
                                 <td class="center aligned" style="padding: 4px 2px;border: 1px solid #cccccc47;">
                                     <div class="ui transparent input">
                                         <input type="number" placeholder="Quantité"
                                             style="text-align: right; font-weight: bold;font-size: 15px;"
                                             name="articles[{{ $vdata }}][variation][{{ $_verb }}][0]"
                                             value="">
                                     </div>
                                 </td>
                             @endif
                         </tr>
                     @endforeach
                 </tbody>
             </table>
         @endif
     </td>
     @if ($client->variations()->count() == 0)
         <td>
             <input type="number" name="articles[{{ $vdata }}][variation][0][0]" placeholder="Quantité">
             <div class="msgError articles_{{ $vdata }}_qty_M"></div>
         </td>
     @endif
     <td width="50px">
         <i class="trash alternate large icon red drop_row c-pointer"></i>
     </td>
 </tr>
