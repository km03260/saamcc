<div class="ui mini icon right floated load-model button" style="background-color: #ffff0a ; color: #000"
    data-url="{{ Route('commande.create') }}?client_id={{ $client->id }}&"
    data-title="<img src='{{ asset('assets/images/app_logo_sq.png') }}' height='20px' /> <span style='vertical-align: super;color:#000'>&nbsp;Nouvelle commande</span>"
    data-color="#ffff0a none repeat scroll 0% 0%" data-width="1024"><i class="add icon"></i>&nbsp;Nouvelle commande</div>
<br>
<br>
<x-data-table list="commandes" :vdata="$vdata" length="-1" :paging="false" classes="child" childRow="/commande/show"
    appends="client_id={{ $client->id }}" />
