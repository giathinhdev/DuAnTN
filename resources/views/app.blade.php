<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Web_Restaurant/assets/ico/web.ico') }}" type="image/x-icon">

    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('Web_Restaurant/assets/css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('Web_Restaurant/assets/css/style-about.css') }}">
    <link rel="stylesheet" href="{{ asset('Web_Restaurant/assets/css/style-contact.css') }}">
    <link rel="stylesheet" href="{{ asset('Web_Restaurant/assets/css/style-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('Web_Restaurant/assets/css/style-table.css') }}">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zilla+Slab:wght@300;400;600;700&display=swap" rel="stylesheet">

    @routes
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
    @inertiaHead
</head>

<body class="font-sans antialiased bg-gray-100">
    @inertia

    <!-- Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
