   <x-tab name="tabs_commande_menu-{{ $vdata }}" url="{{ Route('commande.show', [$commande->id]) }}?tab={tab}"
       :tabs="$tabs" styles="min-height: 10px !important;" />
