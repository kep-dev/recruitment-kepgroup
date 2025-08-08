<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
</head>

<body class="bg-gray-50 transition-all duration-300 lg:hs-overlay-layout-open:ps-65 dark:bg-neutral-900">
    {{ $slot }}
</body>

</html>

