<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title . ' | Recruitment KEP Group' ?? 'Recruitment KEP Group' }}</title>
    <x-assets.style />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-stone-100 transition-all duration-300 dark:bg-neutral-900">
    {{ $slot }}
</body>
</html>
