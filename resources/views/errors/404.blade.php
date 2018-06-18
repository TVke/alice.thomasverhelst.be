@extends('layout')

@section('content')

    <a href="{{ route('leaderboard') }}" class="text-alice no-underline hover:underline block text-center sm:text-right pt-16 sm:pt-4 md:pt-6 px-6 md:px-8 pointer-events-auto">Leaderboard</a>
    <div class="flex flex-wrap absolute pin">
        <h2 class="text-5xl mx-auto mt-auto w-full text-center pb-16 font-sans font-hairline">This page was not found.</h2>
        <a href="{{ route('game') }}"
           class="bg-alice-lighter rounded shadow mx-auto mb-auto p-3 hover:shadow-none active:shadow-inner no-underline text-black transition pointer-events-auto"
        >Start a new game</a>
    </div>

@endsection