@extends('layout')

@section('content')

    <noscript class="flex absolute pin">
        <p class="m-auto">This game only works with Javascript turned on.</p>
    </noscript>

    <div id="game" class="overflow-hidden">
        @if(session('player'))
            <game-setup player="{{ $player->pawn }}"></game-setup>
        @else
            <game-setup></game-setup>
        @endif
        <game-actions></game-actions>
        @if(session('game_token'))
            <game-board token="{{ session('game_token') }}"></game-board>
        @else
            <game-board></game-board>
        @endif
        <player-cards></player-cards>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
@endsection