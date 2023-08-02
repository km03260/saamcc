   <div class="ui mini icon right floated load-model button"
       style="background-color: rgba(128, 135, 140, 0.74); color: #fff"
       data-url="{{ Route('commande.ligne.create', [$commande->id]) }}?&"
       data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;'>&nbsp;Ajouter nouveau article</span>"
       data-color="rgba(128, 135, 140, 0.74) none repeat scroll 0% 0%" data-width="850"><i
           class="add icon"></i>&nbsp;Ajouter nouveau
       article</div>
   <br>
   <br>
   <x-data-table list="lcommandes" :vdata="$vdata" length="-1" :paging="false" classes="child" order="0"
       appends="commande_id={{ $commande->id }}" />
