<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SmartCampus K-12 — DepEd-aligned school management for Philippine K-12 education. Enrollment, attendance, quarterly grading, and local-hosted deployment for Tawi-Tawi and nationwide schools.">

    <title>@yield('title', 'Home') — SmartCampus K-12</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=Outfit:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/smartcampus-landing.css') }}">
</head>
<body class="sc-landing">
    @yield('content')

    @stack('scripts')
</body>
</html>
