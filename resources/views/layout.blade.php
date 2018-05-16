<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="font-sans">
<a href="{{ route('info') }}" class="text-black no-underline absolute pin-t pin-x z-10 px-4 w-1/2 mx-auto rounded-b-lg">
    <header class="py-4 px-6 mx-auto">
        <h1 class="text-center flex-auto font-noteworthy">{{ config('app.name') }}</h1>
    </header>
</a>
<main class="mx-auto">
    @yield('content')
</main>
</body>
</html>