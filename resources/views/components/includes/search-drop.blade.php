<div class="ui fluid selection search multiple {{ $classes }}" id="search-{{ $vsearch }}">
    <div class="ui action icon input">
        <input type="hidden" class="refer" value="hjhj">
        <input id="{{ $vsearch }}_prompt_{{ $name }}" class="prompt {{ $vsearch }}_prompt_"
            value="{{ html_entity_decode($text) }}" type="text" placeholder="{{ $placeholder }}"
            style="
        padding: 7px;
        border-radius: 0;
        ">
        <div class="ui basic red mini button" id="close-{{ $vsearch }}"
            style="border:0;display: @if ($value) block @else none @endif"><i
                class="close red icon" style="margin-top: 2px;margin-right: 25px;"></i></div>
        <input class="{{ $classes }} {{ $vsearch }}_search_"
            id="{{ $vsearch }}_search_{{ $name }}" name="{{ $name }}"
            data-name="{{ $name }}" value="{{ $value }}" type="hidden">
        <i class="search icon" style="border-right: 1px solid grey;"></i>
    </div>
    <div class="result"></div>
</div>
@if ($push)
    @push('scripts')
    @endif
    <script>
        var _search_url = `{{ $url }}?selected={{ $value }}&search={query}&{{ $appends }}`;
        $("#search-{{ $vsearch }}").search({
            apiSettings: {
                url: _search_url.replaceAll('amp;', '&'),
                onResponse: function(searchResponse) {
                    @if ($refer)
                        var response = {
                            results: []
                        };
                        var refer = "{{ $refer }}".split('|');
                        var referValue = $(refer[0]).val();
                        if (referValue) {
                            var referField = refer[1];
                            $.each(searchResponse.results, function(index, item) {
                                if (item[referField].toLowerCase() == referValue.toLowerCase() || item[
                                        referField].toLowerCase().includes(
                                        referValue.toLowerCase())) {
                                    response.results.push(item);
                                }
                            });
                            return response;
                        }
                    @endif
                }
            },
            fields: {
                results: 'results',
                title: 'name',
                value: 'value'
            },
            minCharacters: {{ $minCharacters }},
            maxResults: 150,
            cache: false,
            clearable: true,
            minCharacters: 1,
            searchOnFocus: {{ $searchOnFocus == 1 ? 'true' : 'false' }},
            onSelect: function(result) {
                $(`.{{ $vsearch }}_search_`).val(result.value);
                currentSearchList = result;
                $(`.{{ $vsearch }}_search_`).change();
                $('#close-{{ $vsearch }}').css('display', 'block')
            },
            error: {
                source: 'Cannot search. No source used, and Semantic API module was not included',
                noResults: 'Your search returned no results',
                logging: 'Error in debug logging, exiting.',
                noTemplate: 'A valid template name was not specified.',
                serverError: 'There was an issue with querying the server.',
                maxResults: 'Results must be an array to use maxResults setting',
                method: 'The method you called is not defined.'
            },
        });

        $('#close-{{ $vsearch }}').on('click', function(e) {
            e.preventDefault();
            currentSearchList = null;
            $('.{{ $vsearch }}_search_').val('');
            $('.{{ $vsearch }}_prompt_').val('');
            $(`.{{ $vsearch }}_search_`).change();
            $('#close-{{ $vsearch }}').css('display', 'none');
        })
    </script>
    @if ($push)
    @endpush
@endif
