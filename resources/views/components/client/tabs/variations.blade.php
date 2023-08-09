   @can('create', [App\Models\Variation::class])
       <div class="ui mini icon right floated load-model button" style="background-color: #62ff0a; color: #000"
           data-url="{{ Route('variation.create') }}?client_id={{ $client->id }}&"
           data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;color:#000'>&nbsp;Nouvelle variante</span>"
           data-color="#62ff0a none repeat scroll 0% 0%" data-width="850"><i class="add icon"></i>&nbsp;Nouvelle
           variante
       </div>
   @endcan
   <br>
   <br>
   <x-data-table list="variations" :vdata="$vdata" length="-1" :paging="false" classes="child"
       appends="client_id={{ $client->id }}" />
