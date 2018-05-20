@extends('layout')

@section('content')

    <noscript class="flex absolute pin">
        <p class="m-auto">This game only works with Javascript turned on.</p>
    </noscript>

    <div id="game" class="overflow-hidden">
        <game-setup></game-setup>
        <player-cards></player-cards>
        <game-board></game-board>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
@endsection