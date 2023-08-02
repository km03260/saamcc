 <tr>
     <td>
         <x-includes.search-drop name="articles[{{ $vdata }}][id]" classes="" value=""
             placeholder="Sélectionner l'article" :vdata="$vdata" :push="false"
             url="{{ Route('handle.select', 'article') }}?prospect_id={{ $client }}&sources" />
         <div class="msgError articles_{{ $vdata }}_id_M"></div>
     </td>
     <td>
         <input type="number" name="articles[{{ $vdata }}][qty]" placeholder="Quantité">
         <div class="msgError articles_{{ $vdata }}_qty_M"></div>
     </td>
     <td width="50px">
         <i class="trash alternate large icon red drop_row c-pointer"></i>
     </td>
 </tr>
