<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#000000">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
</head>
<body class="font-sans pointer-events-none">
<a href="{{ route('info') }}" class="text-black no-underline absolute pin-t pin-x z-10 px-4 w-1/2 mx-auto rounded-b-lg pointer-events-auto">
    <header class="pt-2 mx-auto">
        <h1 class="text-center flex-auto font-noteworthy text-xl md:text-3xl flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 410.64 550" class="w-4 md:w-8 h-full block mx-4">
            <path fill="#063" d="M205.18 464.89l34.45-4.1-2.44 37.96-32.01 18.44v-52.3z"/>
            <path d="M294.08 439.8s-58.41 54.83-53.15 84.45l-57.29 23.71s-19.7 5.84-32.89-2.24c0 0 37.19-28.73-19.91-89.21-32.77-34.71 84.5-12.33 84.5-12.33l1 53.77 2.29 12.09 12.27-64.11z" fill="#3aaa35"/>
            <path d="M166.59 463.91s100.25 13.21 140.92-7.59 85.12-55.8 100.25-130.52-58.64-153.21-51.07-175.91z" fill="#2f4596"/>
            <path d="M7.94 108.93s10-38.31 3-52.67S25.75 41.89 37.5 40.59s17.41 1.3 25.68 1.3 16.55 22.64 16.55 22.64z" fill="#60c2d1"/>
            <path d="M358.92 31.09s-47.94-9.51-93.9-25-68.54 3.17-68.54 3.17 17.43 2.78 28.53 13.91 60.61 24.17 74.48 21.79 59.43-13.87 59.43-13.87z" fill="#2f4899"/>
            <path d="M37.54 40.59s69.39-18.95 95.88-29 39.21-9.82 63.06-4.65 48.23 23.74 48.23 23.74L106.36 53.45z" fill="#34276b"/>
            <path d="M133.36 50.6s40.52-24.27 71.9-26.21c19.8-1.22 29.61 2.75 42.49 7.46 17 6.23 51.79 13.11 51.79 13.11l-51.51 35.43-91.91-9.88z" fill="#314596"/>
            <path d="M133.36 59.62s-37.17-32.53-65.69-30.2S3.94 45.14 17.2 58.84c10.65 11 43.09 15.41 43.09 15.41z" fill="#2f4596"/>
            <path d="M259.75 62.64s-22-15.46-43.14-15.46-38.67 11.39-43.14 15.46 65.11 29.31 65.11 29.31z" fill="#281f4e"/>
            <path fill="#4476bb" d="M39.44 79.57l98.7 21.15h138.83l58.57-52.19 37.96-14.64 32.37-4.09-100.7 117.02-61.82 125.27-33.62-18.98L53.54 113.19l-14.1-33.62z"/>
            <path d="M48.47 200.5s-26.19 83.32-25 129.75 31 101.18 75 121.41c44.69 13.84 68.13 12.25 68.13 12.25l65.19-86.05 7.14-118.72s-20.75-31.2-45.79-42.05S59.05 191.43 48.47 200.5z" fill="#2f4596"/>
            <path d="M405.87 29.8s11.35 11.35-.95 35-43.5 65.23-48.23 85.09-55.8 287.54-190.1 314c0 0 56.74-215.66 131.46-316.86S390.73 33.59 405.87 29.8z" fill="#4d9bd5"/>
            <path d="M244.13 74.41s-32.2 2.63-52.77-7.27-43.58-21.39-66.56-18.22-53.88 9.9-53.88 9.9l54.68 28.13 83.19 6.74 30.91-5.55z" fill="#24388d"/>
            <path d="M199.46 84.04s24 6.88 44.67-9.62 63.66-50 161.74-44.61c0 0-49.73 11.31-69.63 27.37-20.22 16.31-39 79.4-96.23 50.92z" fill="#37519f"/>
            <path d="M17.85 87.71s13.21-23.61 35.2-29.8 64.61 20.62 83.17 23.37 44-3.43 58.43 0 45.36 26.81 45.36 26.81-65.38 8.24-100.4 5.5c-31.68-2.47-77.25-41.44-121.76-25.88z" fill="#2a3182"/>
            <path d="M9.08 46.9c7.25 36.28-17.1 80.88-6.25 112.59s30.34 34.44 45.64 41 93.75 4.07 144.66 16.59c0 0-72.72-28-100.41-80.13C59.78 74.96 2.81 15.57 9.08 46.9z" fill="#4d9bd5"/>
        </svg>
        {{ config('app.name') }}</h1>
    </header>
</a>
<main class="mx-auto">
    @yield('content')
</main>
</body>
</html>