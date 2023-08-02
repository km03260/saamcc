// Initial 
var IS_SMALL_DEVICE = ($(window).width() < 768 ? true : false);
var SCREENHEIGHT = $(window).height();
var sys_loading = false;
var currentSearchList = null;


/**
 * Datatable options
 **/
var OPTIONS = {
    processing: true,
    serverSide: true,
    responsive: true,
    searching: false,
    stateSave: true,
    paging: false,
    "pageLength": "All",
    "bFilter": false,
    "bInfo": false,
    "bAutoWidth": false,
    "bRedraw": true,
    // "order": [[ 0, "desc" ]],
    "ordering": false,
    aLengthMenu: [
        [10, 20, 25, 50, 100, 200, 500, 1000, -1],
        [10, 20, 25, 50, 100, 200, 500, 1000, "All"]
    ],
    iDisplayLength: -1,
    "language": {
        "processing": '<i class="ui big spinner blue loading icon"></i>'
    }
};



/**
 * Handle new modal
 */
$(document).on('click', '.load-model', function (e) {
    e.preventDefault();
    load_modal({
        title: $(this).data('title') ?? false,
        url: $(this).data('url'),
        width: $(this).data('width') ?? 750,
        color: $(this).data('color') ?? '#0d6efd',
        top: $(this).data('top') ?? 150,
        rtl: $(this).data('rtl')
            ? ($(this).data('rtl') == 1 ? true : false)
            : false
    });
})

/**
 * Handle Ajax GET Request
 */
$(document).on('click', '.ax_get', function (e) {
    e.preventDefault();
    var _ele_ = $(this);
    var url = _ele_.data('url');
    var appends = _ele_.data('appends') != undefined ? _ele_.data('appends') : '';
    var color = _ele_.data('color') == undefined ? 'green' : _ele_.data('color');
    var classes = _ele_.data('classes') != undefined ? _ele_.data('classes') : '';
    var transitionOut = _ele_.data('transitionOut') != undefined ? _ele_.data('transitionOut') : '';
    var confirm = _ele_.data('message') == undefined;
    var message = !confirm ? _ele_.data('message') : false;
    var rtl = _ele_.data('rtl') != undefined ? true : false;
    var target = _ele_.data('target') != undefined ? _ele_.data('target') : null;
    confirm_popup(message, color, () => {
        _ele_.addClass('disabled loading');
        ajax_get(null, `${url}?${appends}`,
            res => {
                _ele_.removeClass('disabled loading');
                if (res.ok) {
                    $('.load_foot').change();
                    flash(res.ok, 'success', 'bottomRight');
                    if (res._row) {
                        load_row(res._row.id, res._row);
                    }
                    if (res._new) {
                        $(res._new).DataTable().draw(false)
                    }
                    if (res._drow) {
                        drop_row(res._drow);

                    }
                    if (res.reload) {
                        location.reload();
                    }
                    if (res._clicked) {
                        $(res._clicked).click();
                    }
                    if (res.hide) {
                        $(`${res.hide}`).hide(250);
                    }
                } else if (res._append_row) {
                    $(res._target).append(res._append_row);
                } else {
                    flash(res.error, 'error', 'topRight');
                }

            },
            err => {
                _ele_.removeClass('disabled loading');
                flash("Not found!", 'error', 'topRight');
            });
    }, target, confirm, rtl, classes, transitionOut);
})

/**
 * Handle Ajax POST Request
 */
$(document).on('click', '.submit_form', function (e) {
    e.preventDefault();
    var _ele_ = $(this);
    var ref = _ele_.data('ref');
    var _callback = _ele_.data('action');
    var _type = _ele_.data('type');
    var url = _ele_.data('url');
    var files = _ele_.data('files') != undefined ? _ele_.data('files').split(',') : null;
    var _data = $(_ele_.data('form')).serializeArray();
    var _fdata = new FormData();
    $.map(_data, function (_input) {
        _fdata.append(_input.name, _input.value);
    })
    if (files) {
        $.map(files, function (_in) {
            var _ninp = $(`#${_in}`).attr('name');
            var _Files = document.getElementById(_in).files
            filesLength = _Files.length;
            for (var i = 0; i < filesLength; i++) {
                _fdata.append(`${_ninp}${i}`, _Files[i]);
                _fdata.append(`${_ninp}`, _Files[i]);
            }

        })
    }
    var appends = _ele_.data('appends') != undefined ? _ele_.data('appends') : '';
    _ele_.addClass('disabled loading');
    ajax_post(_fdata, `${url}?${appends}`,
        res => {
            _ele_.removeClass('disabled loading');
            if (res.ok) {
                $('.load_foot').change();

                if (res._putIn) {
                    $(res._putIn['name']).val(res._putIn['value']);
                }

                if (res._new) {
                    setTimeout(() => {
                        $(res._new).DataTable().draw();
                    }, 250);
                }
                if (res._row) {
                    load_row(res._row.id, res._row, res.list);

                }
                if (res._drow) {
                    drop_row(res._drow);
                }
                if (res.reload) {
                    location.reload();
                }
                if (res._clicked) {
                    $(res._clicked).click();
                }
                if (_callback != "new") {
                    $('#izimodal-main').iziModal('close');
                    flash(res.ok, 'success', 'bottomRight');
                } else {
                    document.getElementById(_ele_.data('form').replaceAll('#', '')).reset();
                    $('.drop_field_reset').dropdown('clear');
                    $('.img_field_reset').attr('src', '/assets/images/no-photo.jpg');
                    flash(res.ok, 'success', 'bottomRight', 2000, false, '#server_msg');

                }
                $('.actions_btns').hide(200);

            } else if (res.error_messages) {
                setError(res.error_messages, ref);
            } else {
                flash(res.error, 'error', 'topRight');
            }

        },
        err => {
            _ele_.removeClass('disabled loading');
            flash("SERVER ERROR!", 'error', 'topRight');
        }, true);
})


/**
 * Load row data
 * @param {*} idRow 
 * @param {*} row 
 * @param {*} listName 
 */
function load_row(idRow, row, listName = "") {
    var _row = $(`#tr_${listName}_${idRow}`);
    var isOpen = _row.next().hasClass('child');
    var _app = listName != "" ? '.' + listName : '';
    $(`.datatable${_app}`).DataTable().row(_row).data(row);
    if (row.line_color != undefined) {
        _row.css('background-color', row.line_color);
    }
    if (isOpen) {
        setTimeout(() => {
            _row.find('td.open_child').find('i.folder').addClass('open');
        }, 250);

    }
}

/**
 * Delete row line
 * @param {*} row 
 */
function drop_row(row) {

    var _row = $(row);
    if (_row.next().hasClass('child')) {
        _row.next().hide(150);
    };
    _row.hide(250);
    var tblist = $(row).closest('table').attr('id');
    if ($(`#tfoot_${tblist}_input`).length == 1) {
        $(`#tfoot_${tblist}_input`).change();
    }
    //  $('.datatable').DataTable().row(_row).remove().draw(false);
}

/**
 * Display new model
 * @param {Object} param 
 */
function load_modal(param) {
    /**
     * Destroy old content
     */
    $('#izimodal-main').iziModal('destroy');

    /**
     * Config modal
     */
    $(`#izimodal-main`).iziModal({
        title: `${param.title}`,
        overlayClose: false,
        history: false,
        rtl: param.rtl,
        restoreDefaultContent: true,
        default: false,
        openFullscreen: IS_SMALL_DEVICE,
        width: parseInt(param.width),
        top: param.top ?? '',
        bottom: 55,
        closeOnEscape: false,
        fullscreen: true,
        right: param.right ?? '',
        headerColor: param.color ?? 'rgb(145, 144, 142)',
        transitionOut: 'comingOut',
        timeoutProgressbarColor: true,
        timeoutProgressbarColor: param.color ?? 'rgb(145, 144, 142)',
        onOpening: function (modal) {
            modal.startLoading();
            $.get(`${param.url}`, function (data) {
                $("#izimodal-main #modal-content-main").html(data.template);
                modal.stopLoading();
            });
        }
    });

    /**
     * Open modal
     */
    $('#izimodal-main').iziModal('setFullscreen', IS_SMALL_DEVICE);
    $('#izimodal-main').iziModal('open');
}

/**
 * Display an iziToast confirm popup
 *
 * @param {string} message
 * @param {string} color color of displayed popup ex: "red"
 * @param {function} success_action function executed if user choses "yes"
 * @param {*} target 
 *
 * @return {undefined}
 */
function confirm_popup(message = "", color, success_action, target = false, withoutConfirm = false, rtl = false, classes = '', transitionOut = 'flipInX') {
    if (!withoutConfirm) {
        iziToast.question({
            timeout: 10000,
            class: classes,
            zindex: 999,
            rtl: rtl,
            message: message,
            position: 'center',
            transitionIn: transitionOut,
            transitionOut: transitionOut,
            targetFirst: true,
            target: target ?? false,
            backgroundColor: color,
            color: color,
            drag: true,
            balloon: true,
            displayMode: 2,
            buttons: [
                ['<button><b>Oui</b></button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    if (success_action) {
                        success_action();
                    }
                }, true],
                ['<button>No</button>', function (instance, toast) {
                    $(`.tr-remove-confirm`).removeClass('tr-remove-confirm')
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                }],
            ],
            onClosing: function () { $(`.tr-remove-confirm`).removeClass('tr-remove-confirm') }
        });

    } else {
        success_action();
    }
}

/**
 * Display Confirm box 
 */
function confirmBox(params, Btn, success_action, cancel_action) {
    confirm_box = $.confirm({
        theme: "holodark",
        title: params.title,
        type: params.type != undefined ? params.type : "blue",
        animation: 'scale',
        animationBounce: 1.5,
        closeIcon: true,
        icon: false,
        columnClass: params.classes,
        content: function () {
            var self = this;
            return $.ajax({
                url: params.url,
                data: {
                    dataType: "json",
                    data: params.data
                },
                dataType: 'json',
                method: 'get'
            }).done(function (response) {
                setTimeout(() => {
                    Btn.removeClass('disabled loading');
                }, 870);
                if (response.title) {
                    self.setTitle(response.title);
                }
                self.setContent(response.content);
            }).fail(function () {
                setTimeout(() => {
                    Btn.removeClass('disabled loading');
                }, 870);
                self.setContent('Quelque chose s\'est mal passée');
            });
        },
        typeAnimated: true,
        buttons: {
            formSubmit: {
                text: params.action_name != undefined ? params.action_name : "valider",
                btnClass: 'ui blue button',
                action: function () {
                    success_action(confirm_box);
                    return false;
                }
            },
            cancel: {
                text: params.cancel_name != undefined ? params.cancel_name : "Annuler",
                action: function () { cancel_action ? cancel_action() : ''; }
            }
        },
        scrollToPreviousElement: false,
    });
}

/**
  * confirm prompt
 * @param {*} params 
 * @param {*} success_action 
 * @param {*} cancel_action 
 */
function confirmBoxprompt(params, success_action, cancel_action) {
    prompt_box = $.confirm({
        icon: `${params.icon}  prompt-icon icon`,
        title: params.title,
        content: params.content,
        type: 'green',
        typeAnimated: true,
        buttons: {
            Oui: {
                btnClass: 'btn-green',
                action: function () {
                    success_action(prompt_box);
                    return false;
                }

            },
            Non: function () { cancel_action ? cancel_action(prompt_box) : ''; }
        }
    });
}

/**
 * Display in modal 
 * @param {*} model 
 * @param {*} id 
 * @param {*} field 
 * @param {*} success_action 
 * @param {*} groupe 
 */
function show(model, id, field, success_action, groupe = null) {
    $.ajax({
        url: '/' + model + "/show/" + id + "/" + field,
        type: 'get',
        data: { groupe: groupe },
        success: function (data) {
            if (data.ok) {
                if (success_action != null) {
                    success_action(data);
                }
            }
        },
        error: function (xhr, status, errorThrown) {
            console.log(JSON.parse(xhr.responseText).category[0]);
        }
    })
}

/**
 * Update model  function 
 * @param {String} model 
 * @param {FormData} datas 
 * @param {callback} success_action 
 */
function saveWhat(model, datas, success_action) {
    $('.field').each(function () {
        $(this).removeClass('error')
    })

    $.ajax({
        url: `${model}`,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        data: datas,
        processData: false,
        contentType: false,
        success: function (data) {
            if (success_action != null) {
                success_action(data);
            }

        },
        error: function (xhr, status, errorThrown) {
            console.log(JSON.parse(xhr.responseText).category[0]);
        }
    })
}

$(document).on('change', '.up_field', function (event) {
    event.preventDefault();
    if (!sys_loading) {
        resetError();
        var _field = $(this);
        var $spinner = _field.closest('.field').find('.spinner.icon');
        $spinner != undefined ? $spinner.css('display', 'block') : _field.closest('.ui.input').addClass('loading');
        var _form = _field.closest('.form_field');
        var _url = _form.data('url') != undefined ? _form.data('url') : _field.data('url');
        var _data = new FormData();
        var _pref_m = _field.data('pref_m') != undefined ? _field.data('pref_m') : 'sw_';
        switch (_field.data('type')) {
            case 'checkbox':
                var _value = _field.is(':checked') == true ? _field.val() : _field.data('uncheck');
                break;

            default:
                var _value = _field.val();
                break;
        }
        _data.append(_field.data('name'), _value);
        _data.append("id", _form.data('id'));

        saveWhat(_url, _data, (res) => {
            $spinner != undefined ? $spinner.css('display', 'none') : _field.closest('.ui.input').removeClass('loading');

            if (res.error_messages) {
                setError(res.error_messages, _pref_m);
            }
            else if (res.error) {
                flash(res.error, 'error', 'topRight');
            }
            if (res.ok) {
                if (res._row) {
                    load_row(res._row.id, res._row, res.list);
                }
                if (res._clicked) {
                    $(res._clicked).click();
                }
                if (res._append) {
                    $(res._append['element']).html(res._append['content']);
                }
            }
        });
    }
})

/**
 * Delete model  function 
 * @param {String} model 
 * @param {Int} id 
 * @param {callback} success_action 
 */
function destroyWhat(model, id, success_action) {
    $.ajax({
        url: "/commnde/" + model + "/" + id + "/destroy",
        type: 'get',
        success: function (data) {
            if (data.ok) {
                if (success_action != null) {
                    success_action();
                }
                $(data.list).DataTable().ajax.reload(null, false);

            } else {
                flash(data.error, 'warn');
            }

        },
        error: function (xhr, status, errorThrown) {
            console.log(JSON.parse(xhr.responseText).category[0]);
        }
    })
}

/**
 * calculez la somme de colonne spécifique
 * @param {DataTable api} api  datattable api return all record 
 * @param {Int} number  index of column calculate
 */
function SUMCOLONNE(api, number) {
    var numFormat = function (i) {
        return typeof i === 'string' ? parseFloat(i) :
            typeof i === 'number' ?
                i : 0;
    };

    SUM = api.column(number).data().reduce(function (a, b) {
        return numFormat(a) + numFormat(b);
    }, 0);
    return SUM;

}

/**
 * Check if param return value and Not Empty
 * @param {Any} param
 */
function HasValue(param) {
    switch (param) {
        case undefined:
            return '';
            break;
        case null:
            return '';
            break;
        case "null":
            return '';
            break;
        case "Invalid date":
            return '';
            break;
        case "NaN":
            return 0;
            break;
        default:
            return param;
            break;
    }
}

/**
 * 
 * @param {Date|String} date 
 * @param {String} format format to change
 * @param {String} currentFormt current format of date 
 */
function formatDate(date, format, currentFormt = null) {
    var dt = new Date(date);
    if (currentFormt != null) {
        var dayFormat = moment(date, currentFormt).format(format);
    } else {
        var dayFormat = moment(dt).format(format);
    }
    return dayFormat;
}

/**
 * Close all list child
 * @param {String} list
 */
function PofermOthersChilds(list, removedClass, addedClass, handle) {
    $("#" + list).DataTable().rows().every(function () {
        var $_elem = $(this.node()).find('td.open_child').find('i:first');
        if ($_elem[0] != undefined) {
            let $icon_td = $_elem[0].dataset.icon;
            $_elem.removeClass(' pencil')
            $_elem.removeClass('black undo')
            $_elem.addClass($icon_td)
        } else {
            $.map(addedClass, function (c) {
                $(`.${handle}`).removeClass(c)
            })
            $.map(removedClass, function (c) {
                $(`.${handle}`).addClass(c)
            })
        }
        var tr = $(this.node());
        var row = $("#" + list).DataTable().row(tr);
        row.child.hide();
        tr.removeClass('shown');
    });
}

/**
 * Reset Errors
 */
function resetError() {
    $(".fieldControl").each(function () {
        $(this).removeClass('error hasError');
    });

    $('.msgError').each(function () {
        $(this).text('')
    });
}

/**
 * display error of submit
 * @param {*} errors 
 * @param {*} ref 
 */
function setError(errors, ref = null) {
    $.each(errors, function (i, error) {
        let name = ref ? `${ref}${i}` : i;
        $(`.${name.replace('.', '_')}_F`).addClass('error')
        $(`.${name.replaceAll('.', '_')}_M`).text(error[0])
        if ($(`#${name.replace('.', '_')}_popup`).length == 1) {
            $(`#${name.replace('.', '_')}_popup`).popup({
                inline: true,
                hoverable: true,
                on: 'hover focus',
                position: 'bottom left',
                title: false,
                content: error[0]
            });
            $(`#${name.replace('.', '_')}_popup`).popup('show');
        }
    })
}

/**
 * Close All childs
 * @param {String} list 
 */
function closeAllChild(list) {
    $('#' + list).DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
        var tr = $(this.node());
        tr.removeClass('select-row');
        tr.removeClass('shown');
    })
}

/**
 * open child row datatable
 * @param {DataTable} datatable 
 * @param {String} list 
 * @param {*} ref 
 * @param {*} tr 
 */
function openChildDataTable(url, datatable, list, ref, tr, removedClass, addedClass, handle, classHandle, appends = null) {
    $('#of-action-tab').remove();
    closeAllChild(list);
    var row = datatable.row(tr);
    var ndata = row.data()
    var pivot = eval(`ndata.${ref}`)
    if (row.child.isShown()) {
        $(`div#laod-${list}${pivot}`, row.child()).slideUp(function () {
            row.child.hide();
            tr.removeClass('shown');
            tr.removeClass('select-row');
        });
        $.map(addedClass, function (c) {
            handle.removeClass(c)
        })
        $.map(removedClass, function (c) {
            handle.addClass(c)
        })
    }
    else {
        PofermOthersChilds(list, removedClass, addedClass, classHandle);

        $.map(removedClass, function (c) {
            handle.removeClass(c)
        })
        $.map(addedClass, function (c) {
            handle.addClass(c)
        })
        row.child(`<div class="ui mini loading segment" id="laod-${list}${pivot}" style="padding:0;margin:0px !important; border-radius:0"> <div id="detail${list}${pivot}" style="display: none;"></div></div>`, 'child').show();
        appendDetails(url, pivot, list, appends);
        tr.addClass('shown details-row select-row');
        tr.next().find('td').addClass('coverChild');
        tr.next().find('td').addClass('p-0');
        $('html, body').animate({
            scrolltop: tr.offset().top
        }, 1000);
    }

}

/**
 * Append details
 * @param {Url} url 
 * @param {String} pivot 
 * @param {String} list 
 */
function appendDetails(url, pivot, list, appends = null) {
    $.ajax({
        url: `${url}?${appends}`,
        method: "get",
        success: function (data) {
            $(`#laod-${list}${pivot}`).removeClass('loading');
            $(`div#detail${list}${pivot}`).html(data.child);
            $(`div#detail${list}${pivot}`).slideDown();
        },
        error: function (xhr, status, errorThrown) {
            flash("Erreur lors de l'ouverture des détails", 'error', 'topRight');
            $(`#laod-${list}${pivot}`).removeClass('loading');

        }
    })

}

/**
 * Format number to format 1 000 000 000.00
 * @param {Float} num 
 */
function formatNumber(num) {
    num = parseFloat(num).toFixed(2)
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ')
}

/**
 * Flash messge
 * @param {String} message  To show
 * @param {string} type  type of flash message [success| error|info|warn]
 * @param {string} position  // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
 * @param {*} timeout  timeout 
 */
function flash(message, type, position, timeout = 5000, rtl = false, target = false) {
    switch (type) {
        case "success":
            iziToast.success({
                title: false,
                rtl: rtl,
                position: position,
                message: message,
                displayMode: 1,
                timeout: timeout,
                target: target ?? false
            });
            break;
        case "warning":
            iziToast.warning({
                title: false,
                rtl: rtl,
                position: position,
                message: message,
                displayMode: 1,
                timeout: timeout,
                target: target ?? false
            });
            break;
        case "error":
            iziToast.error({
                title: false,
                rtl: rtl,
                position: position,
                message: message,
                displayMode: 1,
                timeout: timeout,
                target: target ?? false
            });
            break;
        default:
            iziToast.info({
                title: false,
                rtl: rtl,
                position: position,
                message: message,
                displayMode: 1,
                timeout: timeout,
                target: target ?? false
            });
            break;
    }
}


/**
 * Update row in list
 * @param {String} list 
 * @param {Int} rowIndex 
 * @param {Int} columnIndex 
 * @param {void} val 
 */
function loadRow(list, rowIndex, columnIndex, val) {
    var table = $("#" + list).DataTable();
    var row = $('#' + rowIndex).closest('tr');
    table.row(row).nodes().to$().find('td:eq(' + columnIndex + ')').text(val)
}

// metter focus in last caracter
(function ($) {
    $.fn.focusTextToEnd = function () {
        this.focus();
        var $thisVal = this.val();
        this.val('').val($thisVal);
        return this;
    }
}(jQuery));

/**
 * Get parms from url
 */
$.urlParam = function (index = 0) {
    var vars = [];
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        vars[key] = value;
    });
    if (vars[index] != undefined) {
        return vars[index];
    }
    return '';
}

function arr_diff(a1, a2) {

    var a = [], diff = [];

    for (var i = 0; i < a1.length; i++) {
        a[a1[i]] = true;
    }

    for (var i = 0; i < a2.length; i++) {
        if (a[a2[i]]) {
            delete a[a2[i]];
        } else {
            a[a2[i]] = true;
        }
    }

    for (var k in a) {
        diff.push(k);
    }

    return diff;
}

/**
* Post a request using jQuery ajax
*
* @param {array} data array of objects {name, value}
* @param {string} url end point
* @param {function} success_action
* @param {function} error_action
*
* @return {undefined}
*/
function ajax_post(data, url, success_action, error_action, file = false) {

    resetError();
    $.ajax({
        url: url,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        processData: file ? false : true,
        contentType: file ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
        success: function (response) {
            success_action(response);
        },
        error: function (xhr, status, errorThrown) {
            if (error_action) {
                error_action(xhr, status, errorThrown);
            }
        }
    })
}

/**
 * Get a request 
 * @param {*} data 
 * @param {*} url 
 * @param {*} success_action 
 * @param {*} error_action 
 */
function ajax_get(data, url, success_action, error_action) {
    $.ajax({
        url: url,
        type: 'GET',
        data: data,
        success: function (response) {
            success_action(response);
        },
        error: function (xhr, status, errorThrown) {
            if (error_action) {
                error_action(xhr, status, errorThrown);
            }
        }
    })
}

/**
 * Create slug from string
 * @param {string} str 
 * @returns 
 */
function string_to_slug(str) {
    str = str.replace(/^\s+|\s+$/g, ""); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "åàáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to = "aaaaaaeeeeiiiioooouuuunc------";

    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
    }

    str = str
        .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
        .replace(/\s+/g, "-") // collapse whitespace and replace by -
        .replace(/-+/g, "-") // collapse dashes
        .replace(/^-+/, "") // trim - from start of text
        .replace(/-+$/, ""); // trim - from end of text

    return str;
}

/**
 * Format form to appends url
 * @param {String} form_id 
 * @returns String
 */
function form_appends(form_id) {
    var form_data = $(`#${form_id}`).serializeArray();
    var append = ``;
    $.map(form_data, function (input) {
        if (input.value != "") {
            append += `&${input.name}=${input.value}`
        }
    })
    return append;
}

$(document).on('click', '.drop_row', function (e) { $(this).closest('tr').remove(); });

var resizePopup = function () { $('.ui.popup').css('max-height', $(window).height()); };

$(window).resize(function (e) {
    resizePopup();
});