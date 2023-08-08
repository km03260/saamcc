@can('update', [App\Models\Stock::class])
    <div class="form_field" style="display: flex; justify-content: space-between"
        data-url="{{ Route('stock.sens', [3, $_model->id, $zone_id]) }}?methode=savewhat">
        @if ($zone_id == 1)
            <i class="large arrow alternate circle right green icon load-model"
                data-url="{{ Route('mouvement.create', [0, $_model->id, $zone_id]) }}"
                data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;'>&nbsp;Modification quantité</span>"
                data-color="rgb(112, 142, 164) none repeat scroll 0% 0%" data-width="750"></i>
        @else
            <i class="large arrow alternate circle left red icon load-model"
                data-url="{{ Route('mouvement.create', [2, $_model->id, $zone_id]) }}"
                data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;'>&nbsp;Modification quantité</span>"
                data-color="rgb(112, 142, 164) none repeat scroll 0% 0%" data-width="750"></i>
        @endif
        @can('upStock', [App\Models\Stock::class])
            <input class="up_field" data-name="qty" style="min-width:90px; text-align:right" type="number"
                value="{{ $_model->stocks()->where('zone_id', $zone_id)->first()->qte ?? '' }}" placeholder="quantité" />
            &nbsp;
        @endcan
        @cannot('upStock', [App\Models\Stock::class])
            {{ $_model->stocks()->where('zone_id', $zone_id)->first()->qte ?? '' }}
            &nbsp;
        @endcannot
        @if ($zone_id == App\Models\Stock::LAST_ZONE)
        @else
            <i class="large arrow alternate circle right green icon load-model"
                data-url="{{ Route('mouvement.create', [1, $_model->id, $zone_id]) }}"
                data-title="<img src='{{ asset('assets/images/app_logo.png') }}' height='25px' /> <span style='vertical-align: super;'>&nbsp;Modification quantité</span>"
                data-color="rgb(112, 142, 164) none repeat scroll 0% 0%" data-width="750"></i>
        @endif
    </div>
@endcan

@cannot('update', [App\Models\Stock::class])
    {{ $_model->stocks()->where('zone_id', $zone_id)->first()->qte ?? '' }}
@endcannot
