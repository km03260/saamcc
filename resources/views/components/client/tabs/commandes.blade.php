<div class="ui mini icon right floated load-model button" style="background-color: rgba(128, 135, 140, 0.74); color: #fff"
    data-url="{{ Route('commande.create') }}?client_id={{ $client->id }}&"
    data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;'>&nbsp;Nouveau commande</span>"
    data-color="rgba(128, 135, 140, 0.74) none repeat scroll 0% 0%" data-width="850"><i class="add icon"></i>&nbsp;Nouveau
    commande</div>
<br>
<br>
<x-data-table list="commandes" :vdata="$vdata" length="-1" :paging="false" classes="child" childRow="/commande/show"
    appends="client_id={{ $client->id }}" />
