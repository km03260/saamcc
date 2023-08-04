<div class="center aligned tabs {{ $name }}" id="{{ $name }}"
    style="
    border-radius: 16px;
    border-radius: 0;
    padding: 0
        ">
    <div class="ui pointing secondary tab_menu menu" style="margin-bottom: -2px;margin-top: -10px;">
        @foreach ($tabs as $tab)
            @if ($tab['can'] ?? true)
                <a class="@if ($loop->first) default @endif {{ $tab['name'] }}  {{ $name }} item"
                    style="justify-content: center;min-width:100px;border-radius:5px;padding:5px 11px;background: {{ isset($tab['color']) ? $tab['color'] : '' }}"
                    data-tab="{{ $tab['name'] }}">{{ $tab['title'] }}</a>
            @endif
        @endforeach
    </div>

    @foreach ($tabs as $tab)
        @if ($tab['can'] ?? true)
            <div class="ui tab segment" data-tab="{{ $tab['name'] }}"
                style="border-radius: 0;margin-top: 0px;text-align: initial; border-top: 4px solid {{ isset($tab['color']) ? $tab['color'] : '' }}">
            </div>
        @endif
    @endforeach

</div>

{{-- @push('script') --}}
<script>
    sys_loading = true;
    $('.{{ $name }}.item').tab({
        cache: false,
        history: false,
        evaluateScripts: 'once',
        context: 'parent',
        alwaysRefresh: true,
        apiSettings: {
            url: `{{ $url }}`,
        },
        onFirstLoad: function(path, arr, history) {
            sys_loading = true;
        },
        onRequest: function(path, arr, history) {
            sys_loading = true;
        },
        onLoad: function(path, arr, history) {
            setTimeout(() => {
                sys_loading = false;
            }, 750);
        },
        onVisible: function(tab) {

            sys_loading = true;
        },
    });

    $('.default.{{ $name }}.item').click();
</script>
{{-- @endpush --}}
