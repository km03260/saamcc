   <div class="ui mini icon right floated load-model button" style="background-color: cornflowerblue; color: #fff"
       data-url="{{ Route('article.create') }}?client_id={{ $client->id }}&"
       data-title="<img src='{{ asset('assets/images/app_logo_sq.png') }}' height='20px' /> <span style='vertical-align: super;'>&nbsp;Nouvel article</span>"
       data-color="cornflowerblue none repeat scroll 0% 0%" data-width="850"><i class="add icon"></i>&nbsp;Nouvel article
   </div>
   <br>
   <br>
   <x-data-table list="articles" :vdata="$vdata" length="-1" :paging="false" classes="child"
       appends="prospect_id={{ $client->id }}" />
