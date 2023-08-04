@extends('layouts.app')
@section('content')
    <div class="ui fluid container" style="padding:17px !important">
        <br>
        <x-tab name='cmd_suivi-{{ $vdata }}' url="/commande/suivi?tab={tab}"
            onVisible="history.replaceState(null,``,`?query=${$.urlParam('query')}&tab=${tab}`);" :tabs="$tabs" />

    </div>
@endsection
