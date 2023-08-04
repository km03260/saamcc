<div>
    <x-data-table list="commandes" :vdata="$vdata" childRow="/commande/show" appends="statut_id=3&suivi=true"
        :length="50" />
</div>
