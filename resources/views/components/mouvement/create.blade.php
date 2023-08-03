<form class="ui form" style="padding:17px" id="mouvement_new_form-{{ $vdata }}">
    <input type="hidden" name="sen_id" value="{{ $dir }}">
    <div class="ui visible message">
        <div class="header">
            Article
        </div>
        <p>{{ $article->ref }} &nbsp;&nbsp;{{ $article->description }}</p>
    </div>

    <div class="three fields">
        @switch($dir)
            @case(1)
                <div class="six wide field">
                    @if ($zones->where('id', $zone->id)->first())
                        <div class="ui compact menu" style="border: 1px solid #d32212">
                            <a class="item" style="min-width:150px">
                                {{ $zones->where('id', $zone->id)->first()?->libelle }}
                            </a>
                            <a class="item tsort_{{ $vdata }}">
                                {{ $article->stocks()->where('zone_id', $zone->id)->first()?->qte ?? 0 }}
                            </a>
                        </div>
                        <input type="hidden" id="sort_{{ $vdata }}"
                            value="{{ $article->stocks()->where('zone_id', $zone->id)->first()?->qte ?? 0 }}">
                    @endif

                </div>
                <div class="three wide field">
                    <div class="ui compact menu" style="border: 1px solid #d32212;background: #d760551c;">
                        <a class="item" style="min-width:65px">
                            Perte
                        </a>
                        <a class="item perte_{{ $vdata }}">0</a>
                    </div>
                    <input type="hidden" id="sperte_{{ $vdata }}" value="">
                </div>
                <div class="seven wide field">
                    @if ($zones->where('id', $zone->id)->first())
                        <div class="ui compact menu right floated" style="border: 1px solid #21ba45">
                            <a class="item" style="min-width:150px">
                                {{ $zones->where('id', $zone->id + 1)->first()?->libelle }}
                            </a>
                            <a class="item tenter_{{ $vdata }}">
                                {{ $article->stocks()->where('zone_id', $zone->id + 1)->first()?->qte ?? 0 }}
                            </a>
                        </div>
                        <input type="hidden" id="enter_{{ $vdata }}"
                            value="{{ $article->stocks()->where('zone_id', $zone->id + 1)->first()?->qte ?? 0 }}">
                    @endif
                </div>
            </div>
            <br>
            <div class="field">
                <label>Quantité à transférer de la zone
                    <span class="ui red label" style="padding: 4px 11px">
                        {{ $zones->where('id', $zone->id)->first()?->libelle }}
                    </span>
                    a la zone
                    <span class="ui green label" style="padding: 4px 11px">
                        {{ $zones->where('id', $zone->id + 1)->first()?->libelle }}
                    </span>
                </label>
                <input name="qte" id="qte_{{ $vdata }}"
                    max="{{ $article->stocks()->where('zone_id', $zone->id)->first()?->qte ?? 0 }}" min="0"
                    type="number" placeholder="Quantité" style="max-width: 150px; padding:4px 11px" />
                <div class="msgError qte_M"></div> <br>
                <input name="perte" id="perte_{{ $vdata }}"
                    max="{{ $article->stocks()->where('zone_id', $zone->id)->first()?->qte ?? 0 }}" min="0"
                    type="number" placeholder="Quantité perte"
                    style="max-width: 150px; padding:4px 11px;border: 1px solid #d32212;" />
                <div class="msgError perte_M"></div>
            </div>
        @break

        @case(2)
            <div class="six wide field">
                @if ($zones->where('id', $zone->id - 1)->first())
                    <div class="ui compact menu" style="border: 1px solid #d32212">
                        <a class="item">
                            {{ $zones->where('id', $zone->id - 1)->first()?->libelle }}
                        </a>
                        <a class="item tenter_{{ $vdata }}">
                            {{ $article->stocks()->where('zone_id', $zone->id - 1)->first()?->qte ?? 0 }}
                        </a>
                    </div>
                    <input type="hidden" id="enter_{{ $vdata }}"
                        value="{{ $article->stocks()->where('zone_id', $zone->id - 1)->first()?->qte ?? 0 }}">
                @endif

            </div>
            <div class="three wide field">
                <div class="ui compact menu" style="border: 1px solid #d32212;background: #d760551c;">
                    <a class="item" style="min-width:65px">
                        Perte
                    </a>
                    <a class="item perte_{{ $vdata }}">0</a>
                </div>
                <input type="hidden" id="sperte_{{ $vdata }}" value="">
            </div>
            <div class="seven wide field">
                @if ($zones->where('id', $zone->id)->first())
                    <div class="ui compact menu right floated" style="border: 1px solid #21ba45">
                        <a class="item" style="min-width:150px">
                            {{ $zones->where('id', $zone->id)->first()?->libelle }}
                        </a>
                        <a class="item tsort_{{ $vdata }}">
                            {{ $article->stocks()->where('zone_id', $zone->id)->first()?->qte ?? 0 }}
                        </a>
                    </div>
                    <input type="hidden" id="sort_{{ $vdata }}"
                        value="{{ $article->stocks()->where('zone_id', $zone->id)->first()?->qte ?? 0 }}">
                @endif
            </div>
            </div>
            <br>
            <div class="field">
                <label>Quantité à transférer de la zone <span class="ui red label"
                        style="padding: 4px 11px">{{ $zones->where('id', $zone->id)->first()?->libelle }}</span> a la
                    zone
                    <span class="ui green label" style="padding: 4px 11px">
                        {{ $zones->where('id', $zone->id - 1)->first()?->libelle }}
                    </span>
                </label>
                <input name="qte" id="qte_{{ $vdata }}"
                    max="{{ $article->stocks()->where('zone_id', $zone->id)->first()?->qte ?? 0 }}" min="0"
                    type="number" placeholder="Quantité" style="max-width: 150px; padding:4px 11px" />
                <div class="msgError qte_M"></div> <br>
                <input name="perte" id="perte_{{ $vdata }}"
                    max="{{ $article->stocks()->where('zone_id', $zone->id)->first()?->qte ?? 0 }}" min="0"
                    type="number" placeholder="Quantité perte"
                    style="max-width: 150px; padding:4px 11px;border: 1px solid #d32212;" />
                <div class="msgError perte_M"></div>
            </div>
        @break

        @default
            </div>
            <div class="field">
                <div class="ui compact menu" style="border: 1px solid #21ba45">
                    <a class="item">
                        {{ $zones->where('id', $zone->id)->first()?->libelle }}
                    </a>
                    <a class="item tenter_{{ $vdata }}">
                        {{ $article->stocks()->where('zone_id', $zone->id)->first()?->qte ?? 0 }}
                    </a>
                </div>
                <input type="hidden" id="enter_{{ $vdata }}"
                    value="{{ $article->stocks()->where('zone_id', $zone->id)->first()?->qte ?? 0 }}">
            </div>
            <br>
            <div class="field">
                <label>Quantité a ajouté à la zone <span class="ui green label"
                        style="padding: 4px 11px">{{ $zones->where('id', $zone->id)->first()?->libelle }}</span> a la
                    zone
                </label>
                <input name="qte" id="qte_{{ $vdata }}" min="0" type="number" placeholder="Quantité"
                    style="max-width: 150px; padding:4px 11px" />
                <div class="msgError qte_M"></div>
            </div>
    @endswitch
    </div>
    </div>
</form>
<h1></h1>
<h1></h1>

<div style="position: fixed; bottom:10px; text-align: center; margin-top:17px; width:100%">
    <button class="ui mini button green submit_form  bradius-0" data-form="#mouvement_new_form-{{ $vdata }}"
        data-url="{{ Route('mouvement.store', [$dir, $article->id, $zone->id]) }}" type="button"
        style="width: 110px; padding: 4px 11px"><i class="save icon"></i>
        Valider</button>

    <button class="ui mini button grey" type="button" style="width: 110px; padding: 4px 11px"
        data-izimodal-close="" data-izimodal-transitionout="bounceOutDown"> Annuler</button>


    <script>
        var qstock = {{ $article->stocks()->where('zone_id', $zone->id)->first()?->qte ?? 0 }};
        $(document).on('change', '#qte_{{ $vdata }}', function(e) {
            var _val = notNaN(parseInt(e.target.value));
            var _perte = notNaN(parseInt($('#perte_{{ $vdata }}').val()));
            if (e.target.value > (qstock - _perte) && {{ $dir }} != 0) {
                $('#qte_{{ $vdata }}').val(qstock - _perte);
                _val = qstock - _perte;
            }
            if (e.target.value < 0) {
                $('#qte_{{ $vdata }}').val(0);
                _val = 0;
            }
            _val = parseInt(_val);
            if ($(`#sort_{{ $vdata }}`).length > 0) {
                $(`.tsort_{{ $vdata }}`).text(parseInt(parseInt($(`#sort_{{ $vdata }}`).val()) -
                    (_val + _perte)));
            }
            if ($(`#enter_{{ $vdata }}`).length > 0) {
                $(`.tenter_{{ $vdata }}`).text(parseInt(parseInt($(`#enter_{{ $vdata }}`).val()) +
                    _val));
            }
        });
        $(document).on('change', '#perte_{{ $vdata }}', function(e) {
            var _val = notNaN(parseInt(e.target.value));
            var _qty = notNaN(parseInt($('#qte_{{ $vdata }}').val()));
            if (e.target.value > (qstock - _qty) && {{ $dir }} != 0) {
                $('#perte_{{ $vdata }}').val(qstock - _qty);
                _val = qstock - _qty;
            }
            if (e.target.value < 0) {
                $('#perte_{{ $vdata }}').val(0);
                _val = 0;
            }
            $('.perte_{{ $vdata }}').text(_val);
            _val = parseInt(_val) + _qty;
            if ($(`#sort_{{ $vdata }}`).length > 0) {
                $(`.tsort_{{ $vdata }}`).text(parseInt(parseInt($(`#sort_{{ $vdata }}`)
                        .val()) -
                    _val));
            }
        });
    </script>
