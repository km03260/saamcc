@switch($item['type'])
    @case('item')
        <a class="item {{ $item['current'] }}" href="{{ $item['route'] }}"> {{ $item['name'] }} </a>
    @break

    @case('inline')
        <a class="item c-pointer {{ $item['route'] }} item item_app"
            data-href="{{ env('APP_URL') . '/' . $item['route'] . '/index' }}" data-name="{{ $item['route'] }}">
            {{ $item['name'] }} </a>
    @break

    @case('drop-item')
        <div class="ui dropdown item affaires">
            {{ $item['name'] }}
            <i class="dropdown icon"></i>
            <div class="menu">
                @foreach ($item['subitems'] as $sub => $route)
                    <a class="item item_app {{ str_replace('/', '_', $route) }}" data-href="{{ env('APP_URL') . '/' . $route }}"
                        data-parent=".affaires" data-name="{{ $route }}">{{ Str::ucfirst($sub) }}</a>
                @endforeach
            </div>
        </div>
    @break

    @default
        <a class="item {{ $item['current'] }}" href="{{ $item['route'] }}">
            <div>
                @if ($item['icon_type'] == 'icon')
                    <i class=" {{ $item['icon'] }} icon"></i>
                @else
                    <img src="{{ $item['icon'] }}" height="34px" />
                @endif
                {{ $item['name'] }}
            </div>
        </a>
@endswitch
