@extends('layout')

@section('content')

    <a href="{{ route('leaderboard') }}" class="text-alice no-underline hover:underline block text-center sm:text-right pt-16 sm:pt-4 md:pt-6 px-6 md:px-8 pointer-events-auto">Leaderboard</a>
    <div class="flex flex-wrap absolute pin">
        <h2 class="text-5xl mx-auto mt-auto w-full text-center pb-16 font-sans font-hairline">We are updating the site.</h2>
    </div>

@endsection