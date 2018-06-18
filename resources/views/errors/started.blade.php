@extends('layout')

@section('content')

    <div class="flex flex-wrap absolute pin">
        <h2 class="text-5xl mx-auto mt-auto w-full text-center pb-16 font-sans font-hairline">This game has already been started.</h2>
        <a href="{{ route('game') }}"
           class="bg-alice-lighter rounded shadow mx-auto mb-auto p-3 hover:shadow-none active:shadow-inner no-underline text-black transition pointer-events-auto"
        >Start a new game</a>
    </div>

@endsection