@extends('layouts.app')
@section('content')
    <div class="ui fluid container" style="padding:17px !important">

        <x-includes.liste-title title="Stock" subtitle="Liste de stock" icon="battery three quarters" />
        @can('create', [App\Models\Stock::class])
            <div class="ui mini icon right floated load-model button" style="background-color: #1678c2; color: #fff"
                data-url="{{ Route('stock.create') }}"
                data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;'>&nbsp;Nouveau stock</span>"
                data-color="rgb(112, 142, 164) none repeat scroll 0% 0%" data-width="650"><i class="add icon"></i>&nbsp;Nouveau
                stock</div>
        @endcan
        <br>
        <br>
        <x-stock.filter :vdata="$vdata" length="50" />
        <x-data-table list="stocks" :vdata="$vdata" appends="wclient=true" length="50" :customLength="true"
            childRow="/stock/show" />
    </div>
@endsection
