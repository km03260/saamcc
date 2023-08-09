<div class="ui fluid search selection {{ $multiple ? 'multiple' : '' }} dropdown" id="dropdown-{{ $vdrop }}"
    style="
    min-height: {{ $multiple ? '' : 'max-content !important' }};
    border-radius: 0;
    width: 100%;
    width: -moz-available ;
    width: -webkit-fill-available;
    {{ $styles }}
    ">
    <div id="text-{{ $vdrop }}" class="text"
        style="
    font-size: 12px;
    padding: 0px;
    padding-top: 3px;
    width: max-content;
    height: auto;
    ">
        {{ $placeholder }}</div>
    <input type="hidden" name="{{ $name }}" data-name="{{ $name }}" value="{{ $value }}"
        class="{{ $classes }}" id="{{ $vdrop }}_drop_{{ $name }}" vdrop="{{ $vdrop }}">
    <i class="dropdown icon" style="
    padding: 4px;
    padding-top: 7px;
    "></i>
</div>

@if ($push)
    @push('script')
    @endif
    <script>
        $("#dropdown-{{ $vdrop }}").dropdown('clear');
        $("#dropdown-{{ $vdrop }}").dropdown('restore default text');
        $(function() {
            var _durl =
                `{{ $url }}?selected={{ $value }}&{{ $appends }}`;
            ajax_get(null,
                _durl.replaceAll('amp;', '&'),
                res => {
                    $("#dropdown-{{ $vdrop }}").dropdown({
                        cache: true,
                        allowAdditions: "{{ $allowAdditions }}",
                        fields: {
                            name: "name",
                            value: "value",
                            text: "name",
                            color: "color",
                        },
                        values: res.results,
                        placeholder: "{{ $placeholder }}",
                        clearable: true,
                        forceSelection: false,
                        transition: 'slide down',
                        onChange: function(value, text, $selectedItem) {
                            if ($(`#{{ $name }}_value`).length == 1) {
                                $(`#{{ $name }}_value`).val(value);
                            }
                            if (text) {
                                var textElement = $.parseHTML(text)[0];
                                if (textElement.attributes) {
                                    this.style.background = textElement.getAttribute('color');
                                }
                            } else {
                                this.style.background = '#FFFFFF';
                            }
                        }
                    });
                });

        })
    </script>

    @if ($push)
    @endpush
@endif
