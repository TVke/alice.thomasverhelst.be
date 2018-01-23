@extends('layout')
@section('content')
    <h1>{{ __('general.title') }}</h1>

    @foreach($settings as $setting)
        @php
            //making settings into variables
            ${$setting->key} = $setting->value;
        @endphp
    @endforeach
    <div class="game">
        <div class="board flex flex-wrap">
            @for ($y = 0; $y < $field_size; ++$y)
                @for ($x = 0; $x < $field_size; ++$x)
                    @component('partials.board_tile')
                        @slot('tile_count')
                            {{ $field_size }}
                            @endslot
                        @slot('rotation')
                            @if($x%2 === 0 && $y%2 === 0) {{-- if x & y are even --}}
                            @if(($x===0 && $y===0)) {{-- corners --}}
                                0
                            @elseif(($x===($field_size-1) && $y===0))
                                90
                            @elseif(($x===0 && $y===($field_size-1)))
                                270
                            @elseif(($x===($field_size-1) && $y===($field_size-1)))
                                180
                            @else
                                0
                            @endif
                            @else
                                0
                            @endif
                        @endslot
                        @slot('object')
                        @endslot
                        @if($x%2 === 0 && $y%2 === 0) {{-- if x & y are even --}}
                        @if(($x===0 && $y===0) ||
                        ($x===($field_size-1) && $y===0) ||
                        ($x===0 && $y===($field_size-1)) ||
                        ($x===($field_size-1) && $y===($field_size-1))){{-- corners --}}
                        corner
                        @else
                            tpoint
                        @endif
                        @else
                            {{ array_random($movable_pieces) }}
                            {{--                    {{ array_slice($movable_pieces,rand(0,(count($movable_pieces) - 1)))[0] }}--}}
                        @endif
                    @endcomponent
                @endfor
            @endfor
        </div>
    </div>

@endsection