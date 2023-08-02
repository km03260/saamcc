@foreach ($items as $title => $item)
    <div class="item">
        <div class="header">{{ $title }}</div>
        <div class="menu">
            @foreach ($item['sub-item'] as $sub)
                @switch($sub['type'])
                    @case('drop-item')
                        <div class="item affaires">
                            <i class=" {{ $sub['icon'] }}"></i>
                            {{ $sub['name'] }}
                            <div style="margin:7px"></div>
                            @foreach ($sub['subitems'] as $itemsub => $route)
                                <span class="c-pointer {{ str_replace('/', '_', $route) }} item item_app"
                                    data-href="{{ env('APP_URL') . '/' . $route }}" data-parent=".affaires"
                                    data-name="{{ $route }}">
                                    <div>
                                        <i class="caret right icon"></i>
                                        {{ Str::ucfirst($itemsub) }}
                                    </div>
                                </span>
                            @endforeach
                        </div>
                    @break

                    @default
                        <span class="c-pointer {{ $sub['route'] }} item"
                            data-href="{{ env('APP_URL') . '/' . $sub['route'] . '/index' }}" data-name="{{ $sub['route'] }}">
                            <div>
                                @if ($sub['icon-type'] == 'icon')
                                    <i class=" {{ $sub['icon'] }}"></i>
                                @else
                                    <img src="{{ $sub['icon'] }}" height="34px" />
                                @endif
                                {{ $sub['name'] }}
                            </div>
                        </span>
                @endswitch
            @endforeach
        </div>
    </div>
@endforeach
