   @can('create', [App\Models\Lcommande::class, $commande])
       {{-- <div class="ui mini compact inverted green menu right floated" style="margin:0 0 7px 0"> --}}
       {{-- <span id="up_{{ $commande->id }}_lcstatut_id_popup"></span>
       <a class="im load-model ui mini green button right floated" data-ref="up_{{ $commande->id }}_lc"
           style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold"
           data-color="#21ba45" data-url="{{ Route('commande.ligne.create', [$commande->id]) }}?&"
           data-title="<img src='{{ asset('assets/images/app_logo_sq.png') }}' height='20px' /> <span style='vertical-align: super;color:#000'>&nbsp;Ajouter Nouvel article</span>"><i
               class="add icon"></i>&nbsp;Ajouter nouvel article
       </a> --}}
       {{-- </div> --}}
   @endcan
   <x-data-table list="lcommandes" :vdata="$vdata" length="-1" :paging="false" classes="child" order="0"
       appends="commande_id={{ $commande->id }}" />
