
<div class="movable-tile tile {{ $object }} w-1/{{ $field_size }} h-1/{{ $field_size }} shadow-outset rounded-lg absolute z-10 place-{{ $x }}-{{ $y }}" data-tile-type="{{ $image }}" data-tile-rotation="{{ $rotation }}">
    <img class="w-full block rounded-lg rotate-{{ $rotation }} absolute pin z--10" src="{{ asset('/img/tiles/'.$image.'.png') }}" alt="{{ __('game.'.$image.'-alt') }}">
</div>