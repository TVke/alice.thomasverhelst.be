@extends('layout')

@section('content')

    <a href="{{ route('leaderboard') }}" class="text-alice no-underline hover:underline block text-center sm:text-right pt-16 sm:pt-4 md:pt-6 px-6 md:px-8 pointer-events-auto">Leaderboard</a>
    <div class="flex flex-wrap absolute pin">
        <a href="{{ route('game') }}"
           class="bg-alice-lighter rounded shadow m-auto p-3 hover:shadow-none active:shadow-inner no-underline text-black transition pointer-events-auto"
        >Play the game</a>
        <noscript class="w-full">
            <p class="text-center">This game only works with Javascript turned on.</p>
        </noscript>
    </div>

@endsection