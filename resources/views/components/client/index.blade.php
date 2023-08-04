@extends('layouts.app')
@section('content')
    <div class="ui fluid container" style="padding:17px !important">

        @can('create', [App\Models\Client::class])
            <x-includes.liste-title title="Clients" subtitle="Listes des clients" icon="users" />
            <div class="ui mini icon right floated load-model button"
                style="background: none 0% 0% repeat scroll rgb(112, 142, 164) !important;
            background-color: #88a0b9; color: #fff"
                data-url="{{ Route('client.create') }}"
                data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;'>&nbsp;Nouveau client</span>"
                data-color="rgb(112, 142, 164) none repeat scroll 0% 0%" data-width="850"><i class="add icon"></i>&nbsp;Nouveau
                client</div>
        @endcan
        @cannot('create', [App\Models\Client::class])
            <x-includes.liste-title title="{{ $client->raison_sociale }}" subtitle="{{ $client->business }}" icon="building"
                :length="50" />
        @endcannot
        <br>
        <x-data-table list="clients" childRow="/client/show" :vdata="$vdata" :length="50"
            open="{{ Auth::user()->Profil == 8 && $client ? $client->id : false }}" />

    </div>
@endsection
