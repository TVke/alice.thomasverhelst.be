@if(trim($slot)!=="")
    <div class="tile {{ $object }} w-1/{{ $row_count }} h-1/{{ $row_count }} shadow-outset relative rounded-lg">
        <img class="w-full block rounded-lg rotate-{{ $rotation }} relative z--10" src="{{ asset('/img/tiles/'.$slot.'.png') }}" alt="{{ __('game.'.$slot.'-alt') }}">
    </div>
@else
    <div class="tile {{ $object }} w-1/{{ $row_count }} h-1/{{ $row_count }} relative hide">
        <img class="w-full block rounded-lg relative z--10" role="presentation" src="{{ asset('/img/tiles/empty.png') }}" alt="{{ __('game.empty-alt') }}">
    </div>
    <div class="movable-tile {{ $object }} w-1/{{ $row_count }} h-1/{{ $row_count }} shadow-outset rounded-lg absolute place-{{ $x }}-{{ $y }}">
        <img class="w-full block rounded-lg rotate-{{ $rotation }} absolute pin z--10" src="{{ asset('/img/tiles/'.$image.'.png') }}" alt="{{ __('game.'.$image.'-alt') }}">
    </div>
@endif