@extends('layout')
@section('content')
    <h1 class="p-2 mx-auto text-center sm:absolute sm:pin-x sm:pin-t">{{ __('general.title') }}</h1>

    @foreach($settings as $setting)
        @php
            //making settings into variables
            ${$setting->key} = $setting->value;
            $tile_count = 1;
        @endphp
    @endforeach
    <div data-field_size="{{ $field_size }}" class="game relative w-3/4 mx-auto mb-4">
        <div class="pawns max-w-md mx-auto absolute pin z-10 block pointer-events-none">
            <div id="pawn-1" class="block w-1/{{ $field_size }} h-1/{{ $field_size }} absolute place-0-0">
                <img class="m-auto block absolute pin w-1.5/5" src="{{ asset('img/pawn_blue.png') }}" alt="{{ __('game.pawn-blue-alt') }}">
            </div>
            <div id="pawn-2" class="block w-1/{{ $field_size }} h-1/{{ $field_size }} absolute place-{{ $field_size-1 }}-0">
                <img class="m-auto block absolute pin w-1.5/5" src="{{ asset('img/pawn_red.png') }}" alt="{{ __('game.pawn-red-alt') }}">
            </div>
            <div id="pawn-3" class="block w-1/{{ $field_size }} h-1/{{ $field_size }} absolute place-{{ $field_size-1 }}-{{ $field_size-1 }}">
                <img class="m-auto block absolute pin w-1.5/5" src="{{ asset('img/pawn_black.png') }}" alt="{{ __('game.pawn-black-alt') }}">
            </div>
            <div id="pawn-4" class="block w-1/{{ $field_size }} h-1/{{ $field_size }} absolute place-0-{{ $field_size-1 }}">
                <img class="m-auto block absolute pin w-1.5/5" src="{{ asset('img/pawn_green.png') }}" alt="{{ __('game.pawn-green-alt') }}">
            </div>
        </div>
        <div class="board flex flex-wrap mx-auto max-w-md shadow relative z--20 rounded-sm">
            @for ($y = 0; $y < $field_size; ++$y)
                @for ($x = 0; $x < $field_size; ++$x)
                    @php
                        $min = 0;
                        $max = $field_size-1;
                    @endphp
                    @component('partials.board_tile')
                        @slot('row_count')
                            {{ $field_size }}
                        @endslot
                            @slot('x')
                                {{ $x }}
                            @endslot
                            @slot('y')
                                {{ $y }}
                            @endslot
                        @slot('rotation')
                            @if($x%2 === 0 && $y%2 === 0) {{-- if x & y are even => sticky tiles --}}
                            @if(($x===$min && $y===$min)) {{-- corners --}}
                                0
                            @elseif(($x===$max && $y===$min))
                                90
                            @elseif(($x===$min && $y===$max))
                                270
                            @elseif(($x===$max && $y===$max))
                                180
                            @else {{-- after corners -> other tiles --}}
                            @if($x===$max || ($x > floor($max/2) && ($y >= floor($max/2)) && $y < $max))
                                90
                            @elseif($y===$max || ($y > floor($max/2) && ($x <= floor($max/2)) && $x > $min))
                                180
                            @elseif($x===$min || ($x < floor($max/2)&& ($y <= floor($max/2)) && $y > $min))
                                270
                            @else
                                0
                            @endif
                            @endif
                            @else
                                {{ array_random($rotation_options) }}
                            @endif
                        @endslot
                        @slot('object')
                        @endslot
                        @if($x%2 === 0 && $y%2 === 0) {{-- if x & y are even --}}
                        @if(
                        ($x===$min && $y===$min) ||
                        ($x===$max && $y===$min) ||
                        ($x===$min && $y===$max) ||
                        ($x===$max && $y===$max)) {{-- corners --}}
                            corner
                        @else
                            tpoint
                        @endif
                        @endif
                            @slot('image')
                                {{ array_random($movable_pieces) }}
                            @endslot
                    @endcomponent
                @endfor
            @endfor
        </div>
    </div>

@endsection