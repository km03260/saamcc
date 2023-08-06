@php
    $qty_sem = [];
@endphp
<div class="table-responsive" style="overflow-x: auto;">
    <div data-parse="1595877840000" id="calplaceholder" style="margin-bottom: 17px;">
        <div class="cal-sectionDiv">
            <table class="ui table celled striped ssem" cellspacing="4" cellpadding="4" style="border-collapse:separate">
                <thead class="cal-thead">
                    <tr>
                        @foreach ($weeks as $semaine)
                            @php
                                $qty_sem[$semaine] = 0;
                            @endphp
                            <th class="center aligned cal-toprow @if (Carbon\Carbon::now()->format('W/Y') == $semaine) current @endif"
                                id="{{ str_replace('/', '-', $semaine) . '_th' }}" style="padding: 5px 11px">
                                {{ $semaine }}
                                <span style="display: none" class="ui circular green label"
                                    id="{{ str_replace('/', '-', $semaine) }}_qty"></span>
                            </th>
                        @endforeach
                    </tr>

                </thead>
                <tbody class="cal-tbody">
                    <tr id="u1">
                        @php
                            $point_sem = 0;
                        @endphp
                        @foreach ($weeks as $semaine)
                            <td id="{{ str_replace('/', '_', $semaine) }}_box" data-week="{{ $semaine }}"
                                align="middle" valign="top" class="center aligned sorting"
                                style="padding: 17px 15px;">
                                <i class="spinner huge blue loading icon" style="margin:17px"></i>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('.table-responsive').scrollTo('#{{ Carbon\Carbon::now()->format('W-Y') . '_th' }}')
    var _weeks_list = [];
    @foreach ($qty_sem as $_qsem => $_qty)
        _weeks_list.push("{{ $_qsem }}");

        // var target = document.getElementById("{{ str_replace('/', '_', $_qsem) }}_box");
        // target.addEventListener("dragend", (event) => {
        //     var $_tar = document.elementFromPoint(event.x, event.y);
        //     if ($_tar != undefined) {
        //         var new_week = $_tar.getAttribute("data-week");
        //         var commande = __tar_td.getAttribute("data-commande");
        //         var old_week = event.target.getAttribute('data-week');
        //         if (new_week != old_week && new_week != null) {

        //             confirm_popup(
        //                 `<div style='color:#000'><i class='ui large check circle green icon'></i> Êtes-vous sûr de passer la commande N° (${commande})?</div>`,
        //                 "", res => {
        //                     $(`#${old_week.replaceAll('/', '_')}_box`).html(
        //                         `<i class="spinner huge blue loading icon" style="margin:17px"></i>`
        //                     );
        //                     $(`#${new_week.replaceAll('/', '_')}_box`).html(
        //                         `<i class="spinner huge blue loading icon" style="margin:17px"></i>`
        //                     );

        //                     $(`#${old_week.replaceAll('/', '-')}_qty`).text("");
        //                     $(`#${new_week.replaceAll('/', '-')}_qty`).text("");
        //                     $(`#${old_week.replaceAll('/', '-')}_qty`).hide();
        //                     $(`#${new_week.replaceAll('/', '-')}_qty`).hide();

        //                     var client = event.target.getAttribute('data-client');
        //                     var usine = event.target.getAttribute('data-usine');
        //                     var baril = event.target.getAttribute('data-baril');
        //                     var _params = {
        //                         week: old_week,
        //                         new_week: new_week,
        //                         selfBaril: baril,
        //                         client: `${client}`,
        //                         Usine: `${usine}`
        //                     };

        //                     $.loadWeekData(_params, '/events/mouvement');
        //                 });

        //         }
        //     }
        // });

        inViewObserver.observe(document.getElementById('{{ str_replace('/', '_', $_qsem) }}_box'))
        setTimeout(() => {
            /**
             * Initaial load data
             **/
            var params = {
                week: "{{ $_qsem }}",
                async: true
            };

            if ($('#{{ str_replace('/', '_', $_qsem) }}_box').hasClass('in-view')) {
                $.loadWeekData(params, '/commande/planif/week');
            }
        }, 350);
    @endforeach

    if (isMozBrowser) {
        $('.usine-col').addClass('moz');
    }
    var container_scroller = document.querySelector('.table-responsive');

    /*
     *Scroll tb
     * 
     **/
    $(document).on('click', '.btn_scroll', function(e) {
        e.preventDefault();
        var dir = $(this).data('dir');
        if (dir == "left") {
            container_scroller.scrollLeft -= 150;
        } else {
            container_scroller.scrollLeft += 150;
        }

    })

    /**
     * Scroll handle event  listener
     **/
    container_scroller.addEventListener("scroll", (event) => {
        $.map(_weeks_list, function(_wbox) {
            inViewObserver.observe(document.getElementById(`${_wbox.replaceAll('/', '_')}_box`))
            setTimeout(() => {
                var params = {
                    week: _wbox,
                    async: true
                };

                if ($(`#${_wbox.replaceAll('/', '_')}_box`).hasClass('in-view') && !$(
                        `#${_wbox.replaceAll('/', '_')}_box`).hasClass('out-dimmer')) {
                    $.loadWeekData(params, '/commande/planif/week');
                }
            }, 100);
        })
    });
</script>
