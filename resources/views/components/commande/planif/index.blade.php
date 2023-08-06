@extends('layouts.app')
@section('content')
    <div class="ui fluid container" style="padding:17px !important">
        <div id="app">
            <planification weekyeartr="{{ Carbon\Carbon::now()->format('W-Y') }}_th"
                :statuts='@json($statuts)' />
        </div>
    </div>
@endsection
