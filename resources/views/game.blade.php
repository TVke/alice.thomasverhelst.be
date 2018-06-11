@extends('layout')

@section('content')

    <noscript class="flex absolute pin">
        <p class="m-auto">This game only works with Javascript turned on.</p>
    </noscript>

    <div id="game" class="overflow-hidden">
        <div class="flex bg-black-transparent absolute pin transition transition-delay-longer"
             :class="{'opacity-0': setupDone}">
            <div class="mx-auto mb-auto w-5/6 bg-white max-w-md rounded-b-lg p-6 pt-24 transition transition-slow shadow border border-t-0 pointer-events-auto"
                 :class="{'move-up': setupDone}">
                <h2 class="p-2 font-noteworthy font-light"
                    :class="{hidden: ! allowNewPlayer}">Choose your pawn</h2>
                @if(! Auth::check())
                    <form class="md:flex-wrap md:flex" method="post" :action="(login) ? '/login' : '/register'"
                          :class="{hidden: ! allowNewPlayer}">
                @endif
                @if(Auth::check())
                    <form class="md:flex-wrap md:flex" method="post" action="{{ route('logout') }}">
                @endif
                    @csrf
                    <div class="flex-1 p-2">
                        <div class="flex">
                            <label class="py-2 block{{ $errors->has('username') ? ' text-red' : '' }}" for="username">Username</label>
                            {{--@if(! Auth::check())--}}
                                {{--<a class="block my-auto mr-auto p-2" :class="{'hidden':login}" href="#" @click.prevent="login = true"> already played? Login</a>--}}
                            {{--@endif--}}
                            @if(Auth::check())
                                <input type="submit" value="Change your choice" class="appearance-none bg-white cursor-pointer hover:underline text-alice rounded pt-1 px-4 my-auto">
                            @endif
                        </div>

                        <input class="block p-2 w-full border border-grey rounded text-base{{ $errors->has('username') ? ' border-red' : '' }}"
                               required id="username" name="username" value="{{ Auth::check() ? Auth::user()->username : old('username') }}"
                                {{ Auth::check() ? 'disabled': '' }}>

                        <label v-if="login" class="py-2 block{{ $errors->has('password') ? ' text-red' : '' }}" for="password">Password</label>
                        <input v-if="login" class="block p-2 w-full border border-grey rounded text-base{{ $errors->has('password') ? ' border-red' : '' }}"
                               type="password" required id="password" name="password" value="{{ old('password') ?: '' }}">
                    </div>
                    <div class="p-2">
                        <label class="py-2 block{{$errors->has('pawn') ? ' text-red' : ''}}" for="pawn">Your pawn</label>
                        <select class="block w-full border border-grey text-base{{ $errors->has('pawn') ? ' border-red' : '' }}"
                                required id="pawn" name="pawn" {{ Auth::check() ? 'disabled' : '' }}>
                            @if(Auth::check())
                                <option value="{{ Auth::user()->pawn }}">{{ Auth::user()->pawn }}</option>
                            @endif
                                @if(old('pawn'))
                                    <option value="{{ old('pawn') }}">{{ old('pawn') }}</option>
                                @endif
                                <option value=""></option>
                                <option v-for="option in pawnOptions"
                                    :value="option.value"
                                    :key="option.name"
                                    :disabled="optionAvailable(option, {{ $players }})"
                                    v-text="option.name"></option>
                        </select>
                    </div>
                    <div class="w-full p-2 block">
                        @if ($errors->has('username') && !Auth::check())
                            <p class="block p-2 bg-grey-lighter rounded mb-4 -mt-2">{{ $errors->first('username') }}</p>
                        @endif
                        @if ($errors->has('pawn') && !Auth::check())
                            <p class="block p-2 bg-grey-lighter rounded mb-4 -mt-2">{{ $errors->first('pawn') }}</p>
                        @endif
                        @if ($errors->has('password') && !Auth::check())
                            <p class="block p-2 bg-grey-lighter rounded mb-4 -mt-2">{{ $errors->first('password') }}</p>
                        @endif
                        <input type="submit" value="Submit choose" class="py-2 px-3 rounded mt-2{{ Auth::check() ? ' bg-grey' : ' bg-alice-lighter' }}"
                                {{ Auth::check() ? 'disabled' : '' }}>
                    </div>
                </form>
                @if(Auth::check())
                    <section class="w-full p-2 py-4 block">
                        <h2 class="py-2 font-noteworthy font-light">Share this url</h2>
                        <div class="flex flex-wrap">
                            <qrcode value="{{ route('game', ['session' => session('game_token')]) }}" tag="img"></qrcode>
                            <a href="{{ route('game', ['session' => session('game_token')]) }}" class="text-alice no-underline hover:underline block m-auto truncate">
                                {{ route('game', ['session' => session('game_token')]) }}
                            </a>
                        </div>
                    </section>
                @endif
                <section class="w-full p-2 pt-4 block">
                    <h3 class="block py-2 pb-3 font-noteworthy font-light{{ (! Auth::check() && $players->count() === 0) ? ' hidden' : '' }}">Current players</h3>
                    <ul class="block list-reset">
                        @if(! Auth::check())
                            @foreach($players as $player)
                                <li>- {{ $player->username }} is {{ $player->pawn !== 'Alice' ? 'the ':'' }}
                                    <strong class="text-grey-dark">{{ $player->pawn }}</strong></li>
                            @endforeach
                        @endif
                        <li v-for="player in players" :key="player.username" v-html="
                        ` - ${player.username} is ${(player.pawn !== 'Alice') ? 'the ' : '' }
                        <strong class='text-grey-dark'>${ player.pawn }</strong>`">
                        </li>
                    </ul>
                    <button class="block bg-alice-lighter text-base py-2 px-3 border-none transition rounded mt-6 mx-auto shadow-lg hover:shadow active:shadow-inner focus:shadow-inner"
                            :class="{hidden: ! gameCanStart}" @click.prevent="setupIsDone('{{ session('game_token') }}')">Start the game
                    </button>
                </section>
            </div>
        </div>
        <game-actions playerpawn="{{ Auth::check() ? Auth::user()->pawn : '' }}"></game-actions>
        <game-board token="{{ session('game_token') }}"
                    playerpawn="{{ Auth::check() ? Auth::user()->pawn : '' }}"
                    @present-players="players = $event"
                    @add-player="players.push($event)"
                    @remove-player="players.splice($event, 1)"></game-board>
        <players playerpawn="{{ Auth::check() ? Auth::user()->pawn : '' }}"></players>
    </div>

    <audio id="tileSound" src="{{ url('/storage/audio/tile.mp3') }}" preload="auto"></audio>
    <audio id="pawnSound" src="{{ url('/storage/audio/pawn.mp3') }}" preload="auto"></audio>
    <audio id="objectSound" src="{{ url('/storage/audio/object.mp3') }}" preload="auto"></audio>

    {{--@if(Auth::check() && Auth::user()->pawn === 'Alice')--}}
        {{--<audio id="welcomeSound" src="{{ url("/storage/audio/Alice/welcome.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="rotateSound" src="{{ url("/storage/audio/Alice/rotate.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="moveSound" src="{{ url("/storage/audio/Alice/movePawn.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="foundSound" src="{{ url("/storage/audio/Alice/objectFound.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="waitingSound" src="{{ url("/storage/audio/Alice/waiting.mp3") }}" preload="auto"></audio>--}}
    {{--@endif--}}

    {{--@if(Auth::check() && Auth::user()->pawn === 'Mad Hatter')--}}
        {{--<audio id="welcomeSound" src="{{ url("/storage/audio/Mad Hatter/welcome.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="rotateSound" src="{{ url("/storage/audio/Mad Hatter/rotate.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="moveSound" src="{{ url("/storage/audio/Mad Hatter/movePawn.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="foundSound" src="{{ url("/storage/audio/Mad Hatter/objectFound.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="waitingSound" src="{{ url("/storage/audio/Mad Hatter/waiting.mp3") }}" preload="auto"></audio>--}}
    {{--@endif--}}

    {{--@if(Auth::check() && Auth::user()->pawn === 'Queen of Hearts')--}}
        {{--<audio id="welcomeSound" src="{{ url("/storage/audio/Queen of Hearts/welcome.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="rotateSound" src="{{ url("/storage/audio/Queen of Hearts/rotate.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="moveSound" src="{{ url("/storage/audio/Queen of Hearts/movePawn.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="foundSound" src="{{ url("/storage/audio/Queen of Hearts/objectFound.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="waitingSound" src="{{ url("/storage/audio/Queen of Hearts/waiting.mp3") }}" preload="auto"></audio>--}}
    {{--@endif--}}

    {{--@if(Auth::check() && Auth::user()->pawn === 'White Rabbit')--}}
        {{--<audio id="welcomeSound" src="{{ url("/storage/audio/White Rabbit/welcome.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="rotateSound" src="{{ url("/storage/audio/White Rabbit/rotate.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="moveSound" src="{{ url("/storage/audio/White Rabbit/movePawn.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="foundSound" src="{{ url("/storage/audio/White Rabbit/objectFound.mp3") }}" preload="auto"></audio>--}}
        {{--<audio id="waitingSound" src="{{ url("/storage/audio/White Rabbit/waiting.mp3") }}" preload="auto"></audio>--}}
    {{--@endif--}}

    <script src="{{ mix('js/app.js') }}"></script>
@endsection