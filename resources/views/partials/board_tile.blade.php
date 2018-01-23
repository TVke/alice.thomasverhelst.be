
<div class="tile {{ $object }} w-1/{{ $row_count }} h-1/{{ $row_count }} shadow-outset relative rounded-lg">
    <img class="w-full block rounded-lg rotate-{{ $rotation }} relative z--10" src="{{ asset('/img/tiles/'.$slot.'.png') }}" alt="{{ __('game.'.$slot.'-alt') }}">
</div>