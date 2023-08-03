        @can('create', [App\Models\Stock::class])
            <div class="ui mini icon right floated load-model button"
                style="background-color: rgba(128, 135, 140, 0.74); color: #fff"
                data-url="{{ Route('stock.create') }}?client_id={{ $client->id }}&"
                data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;'>&nbsp;Nouveau stock</span>"
                data-color="rgba(128, 135, 140, 0.74) none repeat scroll 0% 0%" data-width="550"><i
                    class="add icon"></i>&nbsp;Nouveau
                stock</div>
        @endcan
        <br>
        <br>
        <x-data-table list="stocks" :vdata="$vdata" length="-1" :paging="false" classes="child"
            childRow="/stock/show" appends="prospect_id={{ $client->id }}" />
