   @switch($commande->statut_id)
       @case(2)
           <div class="ui mini" style="margin-top: 7px">
               <span id="up_statut_id_popup"></span>
               <a class="item im load-model ui button" data-ref="up_" data-color="" data-title="" data-class="toast-body"
                   data-top="25%"
                   data-url="/handle/render?com=confirm-statut-action&model=commande&key={{ $commande->id }}&commande"
                   style="padding: 5px 13px;min-width: 110px ;justify-content: center; font-size:13px; font-weight: bold; background: #d8ea5c; color: #000">
                   <i class=" check circle green icon"></i> Confirmer la date
               </a>
           </div>
       @break

       @case(3)
           <div class="ui mini button green ax_get"
               style="box-shadow: 0px 0px 0px 1px #22be34 !important; min-width:100px; padding: 5px 11px"
               data-url="{{ Route('commande.update', [$commande->id]) }}?statut_id=4&methode=savewhat&planif=true&noClicked=true&commande">
               Traiter
           </div>
       @break

       @case(4)
           <div class="ui mini button blue ax_get"
               style="box-shadow: 0px 0px 0px 1px #3ac0ff !important; min-width:100px; padding: 5px 11px"
               data-url="{{ Route('commande.update', [$commande->id]) }}?statut_id=5&methode=savewhat&planif=true&noClicked=true&commande">
               Terminer
           </div>
       @break

       @default
   @endswitch
