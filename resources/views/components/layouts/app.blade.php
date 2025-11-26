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

<script>
    Livewire.on('alert', data => {
        Swal.fire({
            icon: data.type,
            title: data.title,
            text: data.text,
            toast: true,
            position: 'bottom-end',
            timer: 3000,
            showConfirmButton: false,
        });
    });
</script>


<body class="min-h-screen flex flex-col bg-slate-200 dark:bg-slate-700">

    <livewire:partials.navbar />


    <main class="flex-1">
        {{ $slot }}
    </main>

    @livewire('partials.footer')

    {{-- Livewire JS --}}
    @livewireScripts

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x - livewire-alert::scripts />
</body>

</html>
