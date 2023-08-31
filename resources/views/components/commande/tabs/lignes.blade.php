   @can('create', [App\Models\Lcommande::class, $commande])
       <div class="ui mini icon right floated load-model button"
           style="background-color:rgba(202, 228, 246, 0.874) !important; ; color: #000; margin-bottom:7px"
           data-url="{{ Route('commande.ligne.create', [$commande->id]) }}?&"
           data-title="<img src='{{ asset('assets/images/app_logo_sq.png') }}' height='20px' /> <span style='vertical-align: super;color:#000'>&nbsp;Ajouter Nouvel article</span>"
           data-color="rgba(202, 228, 246, 0.874) none repeat scroll 0% 0%" data-width="850"><i
               class="add icon"></i>&nbsp;Ajouter nouvel article</div>
   @endcan
   <x-data-table list="lcommandes" :vdata="$vdata" length="-1" :paging="false" classes="child" order="0"
       appends="commande_id={{ $commande->id }}" />
