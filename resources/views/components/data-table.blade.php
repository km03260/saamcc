<table id="{{ $params['list'] }}" vdata="{{ $params['vdata'] }}" data-open-child="{{ $childRow }}"
    data-list="{{ $params['list'] }}" data-vdata="{{ $vdata }}"
    class="ui celled compact table disabled {{ $list }} datatable row-border hover {{ $classes }}">
    <thead style="@if ($noHead) display:none; @endif" id="{{ $vdata }}-head"></thead>
    <tbody></tbody>
    @if ($tfoot)
        <input type="hidden" id="tfoot_{{ $params['list'] }}_input">
        @php
            $count_cls = count($tfoot);
            $str_cl = 0;
        @endphp
        <tfoot>
            <tr>
                @foreach ($tfoot as $tf_column)
                    @if ($loop->first)
                        <th class="tfoot_c0 right aligned" colspan="{{ $tf_column['index'] }}">Total</th>
                        <th class="tfoot_c{{ $tf_column['index'] }} tfoot_{{ $vdata }}"><i
                                class="spinner blue loading icon"></i></th>
                        @php
                            $str_cl = $tf_column['index'];
                        @endphp
                    @endif

                    @if ($loop->last)
                        @for ($i = $str_cl; $i < $count_cls; $i++)
                            <th class="tfoot_c{{ $i + 1 }}"></th>
                        @endfor
                    @endif
                @endforeach
            </tr>
        </tfoot>
    @endif
</table>

<script>
    /**
     * Datatable
     **/
    var datatable = null;
    var columns_attributes = null;
    var _url_grid = ``;

    $(function() {
        _url_grid = `{{ $params['url'] }}?list={{ $list }}&header=true&{{ $appends }}`;
        _url_grid = _url_grid.replaceAll('amp;', '');
        ajax_get(null, _url_grid,
            res => {
                $('#{{ $vdata }}-head').html(res.content);
                columns_attributes = res.js_columns;
                window["columns_{{ $vdata }}"] = columns_attributes.map(attributtes => {
                    var column_attributtes = attributtes[0].split('|');
                    var column_name = column_attributtes[0];
                    var column_data = column_attributtes[1];
                    var column_render = column_attributtes[2];
                    var isRender = column_attributtes[3];
                    var className = column_attributtes[4];
                    var width = column_attributtes[5];
                    var edit_params = column_attributtes[6];
                    var visible = column_attributtes[7];
                    var orderable = column_attributtes[8];
                    const column = {
                        "data": column_data,
                        className: className.includes('open_child') ? className +
                            ` open_child_{{ $vdata }}` : className
                    };
                    switch (isRender) {
                        case "1":
                            column["render"] = function(data, type, full) {
                                return full[column_data] ?
                                    `<span class="inline" ${edit_params}>${full[column_render]} </span>` :
                                    '';
                            };
                            break;
                        case "field":
                            column["render"] = function(data, type, full) {
                                var _value = '';
                                if (column_data) {
                                    var _data_relation = column_data.substring(0, column_data
                                        .indexOf('.'));
                                    if (full[_data_relation]) {
                                        _value = eval(`full.${_data_relation}.${column_data
                                .substring(column_data.lastIndexOf('.') + 1)}`);
                                    } else {
                                        _value = full[column_data];
                                    }

                                }

                                return column_render.replaceAll('key-index', full.id).replace(
                                    'key-value', _value);
                            };
                            break;
                        case "relation":
                            column["render"] = function(data, type, full) {
                                var _render_val = ``;
                                var _data_relation = column_data.substring(0, column_data
                                    .indexOf('.'));
                                if (full[_data_relation]) {
                                    _render_val = eval(
                                        ` full.${_data_relation}.${column_data.substring(column_data.lastIndexOf('.') + 1)}`
                                    );
                                }
                                return `<span class="inline" ${edit_params} >${_render_val}</span>`;
                            };
                            break;
                        case "relation_mtm":
                            column["render"] = function(data, type, full) {
                                var _data_relation = column_data.substring(0, column_data
                                    .indexOf('-'));
                                var _relations_params = column_data.split('-');

                                if (full[_data_relation]) {
                                    var _value = full[_data_relation].filter(_rela => _rela
                                        .id ==
                                        _relations_params[
                                            1]).map(_rela =>
                                        eval(
                                            `_rela.${_relations_params[2]}`));
                                    return _value[0] != undefined ? _value[0] : '';
                                }
                                return '';
                            };
                            break;
                        case "link":
                            var urlSpl = column_render.split(',');
                            column["render"] = function(data, type, full) {
                                var linkParams = ``;
                                if (urlSpl[2] != undefined) {
                                    $.map(urlSpl[2].split('&'), function(parLink) {
                                        var name = parLink.split('=')[0];
                                        var value = parLink.split('=')[1];
                                        linkParams +=
                                            `&${name}=${value.includes('full')?eval(value):value}`;
                                    })
                                }
                                return `<a href="${urlSpl[0]}/${urlSpl[1]}${linkParams}" target="_blanck" style="color: blue; font-weigth: bold"><i class="mini linkify icon"></i>${full[column_data]}</a>`;
                            };
                            break;
                        case "url":
                            column["render"] = function(data, type, full) {

                                $.ajax({
                                    url: `${column_render}&vdata={{ $params['vdata'] }}&key=${full.id}`,
                                }).done(function(response) {
                                    $(`#${column_data}_{{ $params['vdata'] }}renderInner${full.id}{{ $params['vdata'] }}`)
                                        .html(response.render);
                                }).fail(function(message) {
                                    $(`#${column_data}_{{ $params['vdata'] }}renderInner${full.id}{{ $params['vdata'] }}`)
                                        .html(
                                            `<span class="msgError">error</span>`
                                        );
                                });
                                return `<span id="${column_data}_{{ $params['vdata'] }}renderInner${full.id}{{ $params['vdata'] }}"><i class="spinner blue loading icon"></i></span>`;
                            };
                            break;

                        default:
                            column["render"] = function(data, type, full) {
                                var $_format_data = full[column_data];
                                if (column_name.includes('Date') && $_format_data) {
                                    $_format_data = formatDate(full[column_data],
                                        'DD/MM/YYYY');
                                }
                                return `<span class="inline" ${edit_params}>${HasValue($_format_data)}</span>`;
                            };
                            break;
                    }

                    column["title"] = column_name +
                        `${className.includes('editFieldLine')?'&nbsp;<i class="pencil alternate small icon right floated"></i>':''}`;
                    column["width"] = width;

                    column["visible"] = visible == 1 ? true : false;

                    column['orderable'] = orderable ?? (!["field", "url", "relation_mtm"].includes(
                        isRender)) ? true : false;

                    return column;
                });


                /**
                 * Draw datatable
                 **/
                datatable = $('#{{ $params['list'] }}').DataTable(
                    $.extend({}, OPTIONS, {
                        fixedHeader: "{{ $fixedHeader }}" == 1 ? true : false,
                        "bInfo": false, // "{{ $bInfo }}",
                        serverSide: "{{ $dServerSide }}",
                        "searching": "{{ $searching }}",
                        paging: "{{ $paging }}",
                        "pageLength": "{{ $length }}",
                        "ordering": "{{ $ordering }}",
                        "order": [
                            ["{{ $order }}", "{{ $dir }}"]
                        ],
                        "dom": '<"top"fi>rt<"bottom"lp><"clear">',
                        ajax: {
                            url: "{{ $params['url'] }}?{{ $appends }}",
                            data: function(d) {
                                var data = $("#{{ $params['list'] }}datatable_form")
                                    .serializeArray()
                                $.map(data, function(input) {
                                    d[input.name] = input.value;
                                })
                            }
                        },

                        'columnDefs': [],
                        drawCallback: function(params) {
                            @if ($ctfoot)
                                $(`#tfoot_{{ $params['list'] }}_input`).change();
                            @endif
                            @if ($childRow)
                                if (params.aoData.length == 1) {
                                    var row = params.aoData[0]._aData.id;
                                    openChildDataTable(
                                        `{{ $childRow }}/${row}?vdata={{ $vdata }}`,
                                        $('#{{ $params['list'] }}').DataTable(),
                                        '{{ $params['list'] }}', 'id', $(
                                            `#tr_{{ $list }}_${row}`),
                                        ['folder yellow'], ['folder open yellow'], $(this),
                                        'open_child_{{ $vdata }}',
                                        "list={{ $params['list'] }}"
                                    )
                                } else if ("{{ $list }}" == 'commandes') {

                                    $.map(params.aoData, function(_row) {

                                        if (_row._aData.statut_id == 2) {

                                            var _ligne = _row._aData.id;

                                            openChildDataTable(
                                                `{{ $childRow }}/${_ligne}?vdata={{ $vdata }}`,
                                                $('#{{ $params['list'] }}')
                                                .DataTable(),
                                                '{{ $params['list'] }}', 'id', $(
                                                    `#tr_{{ $list }}_${_ligne}`
                                                ),
                                                ['folder yellow'], [
                                                    'folder open yellow'
                                                ],
                                                $(this),
                                                'open_child_{{ $vdata }}',
                                                "list={{ $params['list'] }}",
                                                false
                                            )
                                        }
                                    })
                                }
                            @endif
                        },

                        'createdRow': function(row, data, dataIndex) {
                            $(row).attr('id', `tr_{{ $list }}_${data.id}`);
                            $(row).attr('data-id', data.id);
                            @if ($parent)
                                $(row).addClass('parent');
                            @endif

                            if (data.line_color != undefined) {
                                $(row).css('background-color', data.line_color);
                            }
                        },

                        columns: window["columns_{{ $vdata }}"],

                        initComplete: function(settings, json) {
                            @if ($customLength)
                                $("#{{ $params['list'] }}_length").css('display', 'none');
                            @endif

                            @if ($open)
                                let row = '{{ $open }}';
                                let _table = $(this).closest('table.datatable');
                                let closeOther = !_table.hasClass('close-other');
                                openChildDataTable(
                                    `{{ $childRow }}/${row}?vdata={{ $vdata }}`,
                                    $('#{{ $params['list'] }}').DataTable(),
                                    '{{ $params['list'] }}', 'id', $(
                                        `#tr_{{ $list }}_${row}`),
                                    ['folder yellow'], ['folder open yellow'], $(this),
                                    'open_child_{{ $vdata }}',
                                    "list={{ $params['list'] }}",
                                    closeOther
                                )
                            @endif

                            $('.ui.loading.segment').removeClass('loading')
                        }
                    }));


                /**
                 *Handle filtre  
                 **/
                $(document).on('change', ".{{ $params['list'] }}_filter", function(event) {
                    $('#{{ $params['list'] }}').DataTable().draw();
                })

                @if ($ctfoot)
                    /**
                     *Handle row foot  
                     **/
                    $(document).on('change', "#tfoot_{{ $params['list'] }}_input", function(
                        event) {
                        $.ajax({
                            url: `{{ $params['url'] }}?tfoot=true&vdata={{ $vdata }}`,
                            data: {
                                "filter": $(`#{{ $params['list'] }}datatable_form`)
                                    .serializeArray(),
                                "columns": "{{ $ctfoot }}"
                            }
                        }).done(function(response) {
                            $.map(response, function(_td) {
                                $(`.tfoot_{{ $vdata }}.tfoot_c${_td.index}`)
                                    .text(
                                        `${_td.value} ${_td.label ?? ''}`);
                            })

                        }).fail(function(message) {
                            $(`.tfoot_{{ $vdata }}`).html(
                                `<span class="msgError"> error </span>`);
                        });
                    })
                @endif
                /**
                 *Handle filtre  
                 **/
                $(document).on('keyup', ".{{ $params['list'] }}_filter_ku", function(event) {
                    $('#{{ $params['list'] }}').DataTable().draw();
                })


                /**
                 *Handle reset filtre  
                 **/
                $(document).on('click', ".{{ $params['list'] }}_reset", function(event) {
                    $('.{{ $params['list'] }}_filter').val('');
                    $('.{{ $params['list'] }}_filter_ku').val('');
                    $('.{{ $params['list'] }}_filter').closest('.ui.dropdown').dropdown(
                        'clear');
                    $("#{{ $params['list'] }}datatable_form").find('.ui.search .close').click();
                    $('#{{ $params['list'] }}').DataTable().draw();
                })

                /**
                 * Handle export
                 **/
                $(document).on('click', `#{{ $params['list'] }}_export`, function(event) {
                    event.preventDefault();

                    var params_filter = ``;
                    $.map(
                        $("#{{ $list }}{{ $params['vdata'] }}datatable_form")
                        .serializeArray(),
                        function(f, i) {
                            params_filter += `&${f.name}=${f.value}`;
                        }
                    )

                    window.open(`/tissus/sitesstockage/export?${params_filter}`, '_blank')
                })

                /**
                 * Handle page length 
                 **/
                @if ($customLength)
                    $(document).on('change', "#{{ $params['list'] }}_clength", function(event) {
                        event.preventDefault();
                        $("#{{ $params['list'] }}_length select").val(this.value);
                        $("#{{ $params['list'] }}_length select").change();
                    })
                @endif


                @if ($childRow)

                    /**
                     * Open detail
                     **/
                    $(document).on('click', 'td.open_child_{{ $vdata }}:not(.iopen)',
                        function(e) {
                            e.preventDefault()
                            let row = $(this).closest('tr').data('id');
                            let _table = $(this).closest('table.datatable');
                            let childUrl = _table.data('open-child');
                            let _list = _table.data('list');
                            let _vdata = _table.data('vdata');
                            let closeOther = !_table.hasClass('close-other');
                            openChildDataTable(
                                `${childUrl}/${row}?vdata=${_vdata}`,
                                $(`#${_list}`).DataTable(),
                                `${_list}`, 'id', $(this).closest('tr'),
                                ['folder yellow'], ['folder open yellow'], $(this),
                                'open_child',
                                `list=${_list}`,
                                closeOther
                            )
                        })

                    /**
                     * Open detail icon
                     **/
                    $(document).on('click',
                        'table#{{ $params['list'] }} tr.parent td.iopen .open_child_{{ $vdata }}',
                        function(e) {
                            e.preventDefault()
                            let row = $(this).attr('data-id');
                            let _table = $(this).closest('table.datatable');
                            let closeOther = !_table.hasClass('close-other');
                            openChildDataTable(
                                `{{ $childRow }}/${row}?vdata={{ $vdata }}`,
                                $('#{{ $params['list'] }}').DataTable(),
                                '{{ $params['list'] }}', 'id', $(this).closest('tr'),
                                ['folder yellow'], ['folder open yellow'], $(this),
                                'open_child_{{ $vdata }}',
                                "list={{ $params['list'] }}",
                                closeOther
                            )
                        })
                @endif
            }, err => {
                flash('Erreur lors de chargement header', 'error');
            });

    })
</script>
