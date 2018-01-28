
<div id="pawn-{{ $slot }}" class="block w-1/{{ $field_size }} h-1/{{ $field_size }} absolute place-{{ $x }}-{{ $y }}">
    <img class="m-auto block absolute pin w-1.5/5" src="{{ asset('img/pawn-'.$slot.'.png') }}" alt="{{ __('game.pawn-'.$slot.'-alt') }}">
</div>