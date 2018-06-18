@extends('layout')

@section('content')

    <h2 class="p-2 pt-24 text-center font-noteworthy font-light pointer-events-auto">Leaderboard</h2>
    @if($scores->isNotEmpty())
        <ol class="px-16 py-4 m-auto max-w-sm w-full pointer-events-auto">
            @foreach($scores as $score)
                <li>
                    @if($score->pawn)
                        <img class="w-4 h-full block float-left mr-2" src="{{ url("/storage/images/pawns/{$score->pawn}.svg") }}" alt="">
                    @else
                        <div class="w-4 h-4 block float-left mr-2"></div>
                    @endif
                    <p class="float-left pr-2">{{ $score->username }}</p>
                    <strong class="text-grey-dark">{{ $score->score }}</strong></li>
            @endforeach
        </ol>

        {{ $scores->links() }}
    @else
        <div class="flex flex-wrap">
            <p class="block w-full text-center pt-24 pb-16 text-grey-dark">Nobody has played yet, be the first</p>
            <a href="{{ route('game') }}"
               class="bg-alice-lighter rounded shadow m-auto p-3 hover:shadow-none active:shadow-inner no-underline text-black transition pointer-events-auto"
            >Play the game</a>
        </div>
    @endif

@endsection