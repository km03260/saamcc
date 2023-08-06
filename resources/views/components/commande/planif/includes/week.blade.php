    @php
        $_qty = 0;
    @endphp

    @if ($commandes->count() > 0)
        @foreach ($commandes->get()->sortBy('dateSteUF')->groupBy('weekSte') as $sem => $sofs)
            @foreach ($sofs->groupBy('client_id') as $usine => $uofs)
                <div class="ui center aligned column grid">
                    <div class="ui raised  of_box_{{ str_replace('/', '_', $sem) }} segment"
                        style="border: 1px solid  @if ($uofs->first()->client->raison_sociale) #{{ $uofs->first()->statut->id }} @else #389fe8 @endif; padding:2px; margin-bottom:7px; ">
                        <a class="ui blue ribbon label" style="width: 90%;">
                            {{ $uofs->first()->client?->raison_sociale }}
                        </a>
                        @foreach ($uofs->groupBy('statut_id') as $statut => $cbofs)
                            @foreach ($cbofs as $bofs)
                                @php
                                    $_qty += $bofs->articles->sum('qty');
                                @endphp
                                <x-commande.planif.includes.card :week="$week" :statut="$statut" :sem="$sem"
                                    :commande="$bofs" />
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endforeach
    @else
        <p class="meta" style="color: #ccc">aucune</p>
    @endif

    <script>
        @if ($_qty > 0)
            var _elem_sq = `#{{ str_replace('/', '-', $week) }}_qty`;
            $(_elem_sq).text("{{ $_qty }}")
            $(_elem_sq).show(150);
        @endif
        $(".ofs_box.segment").visibility({
            once: false,
            observeChanges: true,
            continuous: true,
            onTopPassed: function() {},
            onPassing: function() {}
        });
    </script>
