@foreach ($items as $item)
    @if ($item['can'])
        <x-navbar.item :item="$item" />
    @endif
@endforeach
