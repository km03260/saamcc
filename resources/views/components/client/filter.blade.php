<form class="ui mini form" id="list_clients{{ $vdata }}datatable_form">
    <div class="ui styled accordion" style="border-radius: 0; width: 100%">
        <div class="title" style="padding: 4px;">
            <i title="Rafraîchir le filtre" class="sync blue large icon list_clients{{ $vdata }}_reset"
                style="float: right;margin-top: 6px;"></i>
            <div class="five fields" style="margin: 0;">
                <div class="four wide field">
                    <div style="display: flex;">
                        <label style="margin-top: auto;margin-bottom: auto;">Afficher&nbsp;</label>
                        <select style="width: 80px" id="list_clients{{ $vdata }}_clength">
                            <option @if ($length == '10') selected @endif value="10">10</option>
                            <option @if ($length == '20') selected @endif value="20">20</option>
                            <option @if ($length == '25') selected @endif value="25">25</option>
                            <option @if ($length == '50') selected @endif value="50">50</option>
                            <option @if ($length == '100') selected @endif value="100">100</option>
                            <option @if ($length == '200') selected @endif value="200">200</option>
                            <option @if ($length == '500') selected @endif value="500">500</option>
                            <option @if ($length == '1000') selected @endif value="1000">1000</option>
                            <option @if ($length == '-1') selected @endif value="-1">tout</option>
                        </select>
                        <label style="margin-top: auto;margin-bottom: auto;">&nbsp;fiches</label>
                    </div>

                </div>
                @if (!Gate::allows('is_client', [App\Models\User::class]))
                    <div class="four wide field">
                        <x-includes.search-drop name="id" classes="list_clients{{ $vdata }}_filter"
                            value="" placeholder="Client" :vdata="$vdata" :push="false"
                            url="{{ Route('handle.select', 'client') }}" />
                    </div>
                @endif
            </div>
        </div>
        <div class="content" style="margin:0; padding:0;">
            <br>
            <br>

        </div>
    </div>
</form>

<script>
    $('.accordion').accordion({
        selector: {
            trigger: '.title .sliders.icon'
        }
    });
</script>
