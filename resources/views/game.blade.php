@extends('layout')

@section('content')

    <div id="game">
        <game-setup></game-setup>
        <game-board></game-board>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
@endsection