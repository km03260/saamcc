@extends('layouts.app')
@section('content')
    <div class="ui fluid container" style="padding:17px !important">

        <x-includes.liste-title title="Articles" subtitle="Listes des articles" icon="suitcase" />
        <div class="ui mini icon right floated load-model button" style="background-color: #1678c2; color: #fff"
            data-url="{{ Route('article.create') }}"
            data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;'>&nbsp;Nouveau article</span>"
            data-color="rgb(112, 142, 164) none repeat scroll 0% 0%" data-width="850"><i class="add icon"></i>&nbsp;Nouveau
            article</div>
        <br>
        <br>
        <x-article.filter :vdata="$vdata" length="50" />
        <x-data-table list="articles" :vdata="$vdata" appends="wclient=true" length="50" :customLength="true" />
    </div>
@endsection
