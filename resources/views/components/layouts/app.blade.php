<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Matondo I Dagupan - CodeMania' }}</title>

    {{-- Load Tailwind + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire CSS --}}
    @livewireStyles
</head>

<body class="bg-slate-200 dark:bg-slate-700">

    @livewire('partials.navbar')

    <main>
        {{ $slot }}
    </main>
    @livewire('partials.footer')

    {{-- Livewire JS --}}
    @livewireScripts
</body>

</html>
