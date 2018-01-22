<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title'){{ __('general.title') }}</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    @if(Route::currentRouteName() === "info")
        <meta name="description" content="{{ __('general.description-info') }}">
    @elseif(Route::currentRouteName() === "game")
        <meta name="description" content="{{ __('general.description-info') }}">
    @else
        <meta name="description" content="{{ __('general.description-general') }}">
    @endif
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <link rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
    @endforeach
<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112840907-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-112840907-1');
    </script>
</head>
<body>
@yield('content')
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>