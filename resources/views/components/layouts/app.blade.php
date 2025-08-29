<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title . ' | Recruitment KEP Group' ?? 'Recruitment KEP Group' }}</title>
    <x-assets.style />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-stone-100 transition-all duration-300 lg:hs-overlay-layout-open:ps-65 dark:bg-neutral-900">
    <div class="wrapper">
        <x-organism.user-header />
        {{ $slot }}
        <x-organism.footer />
    </div>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B73TDMXKF5"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@latest/build/vanilla-calendar.min.js"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-B73TDMXKF5');
    </script>
</body>

</html>
