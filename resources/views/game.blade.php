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
                <form class="md:flex-wrap md:flex" method="post" action="{{ route('register') }}"
                      :class="{hidden: ! allowNewPlayer}">
                    @csrf
                    <div class="flex-1 p-2">
                        <label class="py-2 block{{ $errors->has('username') ? ' text-red' : '' }}" for="username">Username</label>
                        <input class="block p-2 w-full border border-grey rounded text-base{{ $errors->has('username') ? ' border-red' : '' }}"
                               required id="username" name="username" value="{{ Auth::check() ? Auth::user()->username : old('username') }}"
                                {{ Auth::check() ? 'disabled': '' }}>
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
                        <input type="submit" value="Submit choose" class="py-2 px-3 rounded mt-2{{ Auth::check() ? ' bg-grey' : ' bg-alice-lighter' }}"
                                {{ Auth::check() ? 'disabled' : '' }}>
                    </div>
                </form>
                @if(Auth::check())
                    <section class="w-full p-2 py-4 block">
                        <h2 class="py-2 font-noteworthy font-light">Share this url</h2>
                        <div class="flex">
                            <qrcode value="{{ route('game', ['session' => session('game_token')]) }}" tag="img"></qrcode>
                            <a href="{{ route('game', ['session' => session('game_token')]) }}" class=" block m-auto">
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
                        <li v-for="player in players" :key="player.username">
                            - @{{ player.username }} is @{{ (player.pawn !== 'Alice') ? 'the ' : '' }}
                            <strong class="text-grey-dark">@{{ player.pawn }}</strong>
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
        <players object="{{ Auth::check() ? Auth::user()->current_object : '' }}"
                 playerpawn="{{ Auth::check() ? Auth::user()->pawn : '' }}"></players>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
@endsection