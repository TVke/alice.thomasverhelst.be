@extends('layout')

@section('content')

    <div class="flex flex-wrap absolute pin">
        <a href="{{ route('game') }}"
           class="bg-alice-lighter rounded shadow m-auto p-3 hover:shadow-none active:shadow-inner no-underline text-black transition pointer-events-auto"
        >Play the game</a>
        <noscript class="w-full">
            <p class="text-center">This game only works with Javascript turned on.</p>
        </noscript>
    </div>

@endsection