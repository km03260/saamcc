<form class="ui mini form" id="list_commandes{{ $vdata }}datatable_form">
    <div class="ui styled accordion" style="border-radius: 0; width: 100%">
        <div class="title" style="padding: 4px;">
            <i title="Rafraîchir le filtre" class="sync blue large icon list_commandes{{ $vdata }}_reset"
                style="float: right;margin-top: 6px;"></i>
            <div class="five fields" style="margin: 0;">
                <div class="four wide field">
                    <div style="display: flex;">
                        <label style="margin-top: auto;margin-bottom: auto;">Afficher&nbsp;</label>
                        <select style="width: 80px" id="list_commandes{{ $vdata }}_clength">
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
                <div class="three wide field">
                    <div class="ui input">
                        <input type="text" name="id" placeholder="N° commande" id="cmd_num"
                            class="list_commandes{{ $vdata }}_filter_ku">
                    </div>
                </div>
                <div class="three wide field">
                    <div class="ui calendar calendar_field_filter">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" name="week_liv" style="font-size: 17px;padding:4px"
                                class="list_commandes{{ $vdata }}_filter" placeholder="Semaine Livraison"
                                readonly>
                        </div>
                    </div>
                </div>
                @if (!Gate::allows('is_client', [App\Models\User::class]))
                    <div class="four wide field">
                        <x-includes.search-drop name="client_id" classes="list_commandes{{ $vdata }}_filter"
                            value="" placeholder="Client" :vdata="$vdata" :push="false"
                            url="{{ Route('handle.select', 'client') }}" />
                    </div>
                @endif
                <div class="three wide field">
                    <x-includes.dropdown name="statut_id" classes="list_commandes{{ $vdata }}_filter"
                        value="{{ Gate::allows('is_operateur', [App\Models\User::class]) ? 4 : '' }}"
                        placeholder="Statut" :vdata="$vdata" :push="false" :multiple="false"
                        url="{{ Route('handle.select', 'scommande') }}" />
                </div>
                <div class="three wide field">
                    <x-includes.search-drop name="article_id" classes="list_commandes{{ $vdata }}_filter"
                        value="" placeholder="Article" :vdata="$vdata" :push="false"
                        url="{{ Route('handle.select', 'article') }}" />
                </div>
            </div>
        </div>
        <div class="content" style="margin:0; padding:0;">
            <br>
            <br>

        </div>
    </div>
</form>

@push('script')
    <script>
        $('.accordion').accordion({
            selector: {
                trigger: '.title .sliders.icon'
            }
        });

        calendarHandle({
            element: '.calendar_field_filter',
            field: ``,
            initialDate: null,
            format: "W/YYYY"
        });
    </script>
@endpush
