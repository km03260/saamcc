<div class="ui mini icon right floated load-model button" style="background-color: rgba(128, 135, 140, 0.74); color: #fff"
    data-url="{{ Route('user.create') }}?client_id={{ $client->id }}&"
    data-title="<img src='{{ asset('assets/images/app_logo_sq.png') }}' height='20px' /> <span style='vertical-align: super;'>&nbsp;Nouveau utilisateur</span>"
    data-color="rgba(128, 135, 140, 0.74) none repeat scroll 0% 0%" data-width="550"><i class="add icon"></i>&nbsp;Nouveau
    utilisateur</div>
<br>
<br>
<x-data-table list="users" :vdata="$vdata" length="-1" :paging="false" classes="child" childRow="/user/show"
    appends="client_id={{ $client->id }}" />
