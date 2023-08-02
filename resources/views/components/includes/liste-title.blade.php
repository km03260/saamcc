<div class="ui vertical steps m-0">
    <div class="active step" style="padding: 7px 27px;">
        @if (Str::contains($icon, '.'))
            <img src='{{ asset("assets/images/$icon") }}' height="35" style="margin: 0em 1rem 0em 0em;" />
        @else
            <i class="{{ $icon }} icon"></i>
        @endif
        <div class="content">
            <div class="title">{{ $title }}</div>
            <div class="description">{{ $subtitle }}</div>
        </div>
    </div>
</div>
