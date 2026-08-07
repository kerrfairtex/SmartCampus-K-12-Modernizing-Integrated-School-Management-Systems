<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'SmartCampus') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons&style=normal&weight=400" rel="stylesheet">

    @routes
    @vite(['resources/js/app.js', 'resources/css/app.scss'])
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>
