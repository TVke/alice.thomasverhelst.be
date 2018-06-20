@extends('layout')

@section('content')

    <a href="{{ route('leaderboard') }}" class="text-alice no-underline hover:underline block text-center sm:text-right pt-16 sm:pt-4 md:pt-6 px-6 md:px-8 pointer-events-auto">Leaderboard</a>
    <div class="w-full block flex flex-col py-16">
        <a href="{{ route('game') }}"
           class="bg-alice-lighter rounded shadow my-4 mx-auto py-2 px-3 hover:shadow-none active:shadow-inner no-underline text-black transition pointer-events-auto"
        >Play the game</a>
        <noscript class="w-full">
            <p class="text-center">This game only works with Javascript turned on.</p>
        </noscript>
    </div>

    <section class="p-4 pb-4">
        <h2>The game</h2>
        <p>Alice's magical maze is a multiplayer boardgame.
            This game is set in the maze of the Queen of Hearts from the book "Alice's adventures in Wonderland".
            Inside the magical maze there are different objects from the book that need to be found.
            You can choose to be Alice, the Mad Hatter, the White Rabbit and the Queen of Hearts when you enter the maze.
            Of course this maze is inside Wonderland so it is not what it seems, the maze changes every turn in the game.
            This provides you with a surprising and fun treasurehunt inside the magical maze. </p>
    </section>
    <section class="p-4 pb-4">
        <h3>The goal of the game</h3>
        <p>The goal of the game is to find all your objects inside the maze.
            If one player wins it is the end of the game en everybody gets a score based on the objects every player found.</p>
    </section>
    <section class="p-4 pb-8">
        <h3>One turn</h3>
        <p>Every turn you need to move the maze by sliding one tile inside the maze. </p>
        <p>Every turn the player can move the pawn to a prefered position.</p>
    </section>

    <div class="block pt-8 pb-8 border-t">
        <figure>
            <div class="flex w-full justify-between px-4">
                <img class="block w-1/4 h-full" src="{{ url('/storage/images/pawns/Alice.svg') }}" alt="Alice pawn">
                <img class="block w-1/4 h-full" src="{{ url('/storage/images/pawns/Mad Hatter.svg') }}" alt="Mad Hatter pawn">
                <img class="block w-1/4 h-full" src="{{ url('/storage/images/pawns/Queen of Hearts.svg') }}" alt="Queen of Hearts pawn">
                <img class="block w-1/4 h-full" src="{{ url('/storage/images/pawns/White Rabbit.svg') }}" alt="White Rabbit pawn">
            </div>
            <figcaption class="text-center p-2 w-full bg-black-transparent text-white my-4">The pawns</figcaption>
        </figure>
        <figure>
            <div class="flex flex-wrap w-full justify-between px-4 border-t">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/bottle.svg') }}" alt="bottle">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/cake.svg') }}" alt="cake">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/cardsoldiers.svg') }}" alt="cardsoldiers">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/crown.svg') }}" alt="crown">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/doorknob.svg') }}" alt="doorknob">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/golfbal.svg') }}" alt="golfbal">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/golfmallets.svg') }}" alt="golfmallets">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/hammer.svg') }}" alt="hammer">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/hats.svg') }}" alt="hats">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/key.svg') }}" alt="key">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/mirror.svg') }}" alt="mirror">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/pocketwatch.svg') }}" alt="pocketwatch">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/diamonds.svg') }}" alt="diamonds">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/clubs.svg') }}" alt="clubs">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/hearts.svg') }}" alt="hearts">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/spades.svg') }}" alt="spades">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/redrose.svg') }}" alt="redrose">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/shoe.svg') }}" alt="shoe">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/singingflower.svg') }}" alt="singing flower">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/teacup.svg') }}" alt="teacup">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/teapot.svg') }}" alt="teapot">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/tree.svg') }}" alt="tree">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/waterpipe.svg') }}" alt="waterpipe">
                <img class="block p-4 w-24 h-24" src="{{ url('/storage/images/objects/whiterose.svg') }}" alt="white rose">
            </div>
            <figcaption class="text-center p-2 w-full bg-black-transparent text-white my-4">The objects</figcaption>
        </figure>
    </div>

@endsection