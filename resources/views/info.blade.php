@extends('layout')

@section('content')

    <div class="flex absolute pin">
        <a href="{{ route('game') }}"
           class="bg-alice-lighter rounded shadow m-auto p-3 hover:shadow-none active:shadow-inner no-underline text-black transition"
        >Play the game</a>
    </div>

@endsection