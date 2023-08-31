@extends('layouts.app')
@section('content')
    <div class="ui fluid container" style="padding:17px !important">

        <x-includes.liste-title title="Utilisateurs" subtitle="Listes des utilisateurs" icon="users" />
        {{-- <div class="ui mini icon right floated load-model button" style="background-color: #1678c2; color: #fff"
            data-url="{{ Route('article.create') }}"
            data-title="<img src='{{ asset('assets/images/app_logo_sq.png') }}' height='20px' /> <span style='vertical-align: super;'>&nbsp;Nouvel article</span>"
            data-color="rgb(112, 142, 164) none repeat scroll 0% 0%" data-width="850"><i class="add icon"></i>&nbsp;Nouveau
            article</div> --}}
        <br>
        <br>
        <x-user.filter :vdata="$vdata" length="50" />
        <x-data-table list="users" :vdata="$vdata" appends="wprofil=true" length="50" :customLength="true" />
    </div>
@endsection
