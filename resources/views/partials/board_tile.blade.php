@if(trim($slot)!=="")
    <div class="tile {{ $object }} w-1/{{ $field_size }} h-1/{{ $field_size }} shadow-outset relative rounded-lg" data-tile-type="{{ $slot }}" data-tile-rotation="{{ $rotation }}">
        <img class="w-full block rounded-lg rotate-{{ $rotation }} relative z--10" src="{{ asset('/img/tiles/'.$slot.'.png') }}" alt="{{ __('game.'.$slot.'-alt') }}">
    </div>
@else
    <div class="w-1/{{ $field_size }} h-1/{{ $field_size }} relative">
        <img class="w-full block rounded-lg relative z--10" role="presentation" src="{{ asset('/img/tiles/empty.png') }}" alt="{{ __('game.empty-alt') }}">
    </div>
    <div class="movable-tile tile {{ $object }} w-1/{{ $field_size }} h-1/{{ $field_size }} shadow-outset rounded-lg absolute z-10 place-{{ $x }}-{{ $y }}" data-tile-type="{{ $image }}" data-tile-rotation="{{ $rotation }}">
        <img class="w-full block rounded-lg rotate-{{ $rotation }} absolute pin z--10" src="{{ asset('/img/tiles/'.$image.'.png') }}" alt="{{ __('game.'.$image.'-alt') }}">
    </div>
@endif