 <tr>

     {{-- @php
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
     @if (!isset($wdelete))
         <td width="50px">
             <i class="trash alternate large icon red drop_row c-pointer"></i>
         </td>
     @endif --}}
 </tr>
 <tr>
     <td class="p-0">
         <table class="ui celled table b-0">
             <tr>
                 <td style="padding: 0 7px;background-color: rgb(247, 247, 255);width: 150px;">Article</td>
                 <td class="p-0">
                     <x-includes.dropdown name="articles[{{ $vdata }}][id]"
                         classes="{{ $vdata }}_articles_selected" styles="border:0" value=""
                         placeholder="Sélectionner l'article" :vdata="$vdata" :push="false"
                         url="{{ Route('handle.select', 'article') }}?prospect_id={{ $client->id }}&ids={{ $ids ?? '' }}&notin={{ $notIn ?? '' }}&add=true&sources" />
                     <div class="msgError articles_{{ $vdata }}_id_M"></div>

                     <div class="fields_{{ $vdata }}_lcmd"></div>
                 </td>
             </tr>
             @foreach ($client->variations()->get() as $var)
                 <tr class="_field_{{ $vdata }}_row" style="display:none">
                     <td style="padding: 0 7px;background-color: rgb(247, 247, 255);">{{ $var->label }}</td>
                     <td class="p-0">
                         <x-includes.dropdown name="articles[{{ $vdata }}][variation][{{ $var->label }}]"
                             classes="{{ $vdata }}_selected_{{ $var->label }}" value=""
                             styles="border:0" placeholder="Sélectionner {{ $var->label }}" :vdata="$vdata"
                             :push="false"
                             url="{{ Route('handle.select', $var->label) }}?options={{ $var->value }}&{{ $var->label }}" />
                     </td>
                 </tr>
             @endforeach
             <tr class="_field_{{ $vdata }}_row" style="display:none">
                 <td style="padding: 0 7px;background-color: rgb(247, 247, 255);">Quantité</td>
                 <td class="p-0" style="background-color:#fff">
                     <div class="ui transparent input">
                         <input type="number" placeholder="Quantité"
                             style="text-align: right; font-weight: bold;font-size: 15px;width:100px;"
                             name="articles[{{ $vdata }}][qty]" value="">
                     </div>
                     <div class="msgError articles_{{ $vdata }}_qty_M"></div>

                 </td>
             </tr>
         </table>
     </td>
 </tr>

 <script>
     setTimeout(() => {
         $(document).on('change',
             ".{{ $vdata }}_articles_selected",
             function(e) {
                 e.preventDefault();
                 if (e.target.value) {
                     $('._field_{{ $vdata }}_row').show(250);
                 } else {
                     $('._field_{{ $vdata }}_row').hide(250);

                 }
             });
     }, 750);
 </script>
