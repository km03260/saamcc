@extends('layouts.app')
@section('content')
    <div class="ui fluid container" style="padding:17px !important">

        <x-includes.liste-title title="Commande" subtitle="Liste des commandes" icon="shopping cart" />
        @can('create', [App\Models\Commande::class])
            <div class="ui mini icon right floated load-model button"
                style="background: none 0% 0% repeat scroll rgb(112, 142, 164) !important;
            background-color: #88a0b9; color: #fff"
                data-url="{{ Route('commande.create') }}"
                data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;'>&nbsp;Nouveau commande</span>"
                data-color="rgb(112, 142, 164) none repeat scroll 0% 0%" data-width="950"><i class="add icon"></i>&nbsp;Nouveau
                commande</div>
        @endcan
        <br>
        <br>
        <x-commande.filter :vdata="$vdata" length="50" />
        <x-data-table list="commandes" :vdata="$vdata" appends="wclient=true" length="50" :customLength="true"
            childRow="/commande/show" />
    </div>
@endsection
