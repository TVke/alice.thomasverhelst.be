@extends('layout')

@section('content')

    <noscript class="flex absolute pin">
        <p class="m-auto">This game only works with Javascript turned on.</p>
    </noscript>

    <div id="game" class="overflow-hidden">
{{--        {{ session('pawn') }}--}}
        {{--@if(session('pawn'))--}}
            {{--<game-setup token="{{ session('game_token') }}"></game-setup>--}}
        {{--@else--}}
            <game-setup></game-setup>
        {{--@endif--}}
        <player-cards></player-cards>
        <game-board></game-board>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
@endsection