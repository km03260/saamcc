<div style="margin: 17px;">
    <form class="ui small form" id="commande_new_form-{{ $vdata }}">

        @if ($client_id)
            <input type="hidden" name="client_id" value="{{ $client_id }}">
            <div class="msgError client_id_M"></div>
            <input type="hidden" class="{{ $vdata }}_client_value" value="{{ $client_id }}">

            @include('components.commande.fields')
        @else
            <div class="field fieldControl client_id_F">
                <div class="two fields">
                    <div class="four wide field" style="margin-top: auto;margin-bottom: auto;">
                        <label>Client</label>
                    </div>
                    <div class="ten wide fieldControl field client_id_F {{ $vdata }}_client_selected">
                        <x-includes.search-drop name="client_id" classes="{{ $vdata }}_input_val" value=""
                            placeholder="Sélectionner le client" :vdata="$vdata" :push="false"
                            url="{{ Route('handle.select', 'Client') }}" />
                        <div class="msgError client_id_M"></div>
                    </div>
                </div>
            </div>

            <div class="ui vertical segment" id="fields_{{ $vdata }}" style="border: 0;"></div>
        @endif


    </form>
</div>

<h1></h1>
<h1></h1>

<div style="position: fixed; bottom:10px; text-align: center; margin-top:17px;width: 100%">

    <button class="ui mini button green submit_form  bradius-0" data-form="#commande_new_form-{{ $vdata }}"
        data-url="{{ Route('commande.store') }}" type="button" style="padding: 4px 11px"><i class="save icon"></i>
        Enregistrer</button>

    <button class="ui mini button grey" type="button" style="width: 110px;padding: 4px 11px" data-izimodal-close=""
        data-izimodal-transitionout="bounceOutDown"> Annuler</button>
</div>

@if (!$client_id)
    <script>
        setTimeout(() => {

            $(document).on('change', ".{{ $vdata }}_client_selected input.{{ $vdata }}_input_val",
                function(e) {
                    e.preventDefault();
                    $('#fields_{{ $vdata }}').html('');
                    $('#fields_{{ $vdata }}').addClass('loading');

                    ajax_get(null, `/commande/fields/${e.target.value}`, res => {
                        $('#fields_{{ $vdata }}').removeClass('loading');
                        $('#fields_{{ $vdata }}').html(res);
                    }, err => {
                        $('#fields_{{ $vdata }}').removeClass('loading');
                        $('.client_id_M').text('Vous devez selectioné un client ');
                    })
                });
        }, 750);
    </script>
@endif
