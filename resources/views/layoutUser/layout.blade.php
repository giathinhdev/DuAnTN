<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('Web_Restaurant/assets/ico/web.ico') }}" type="image/x-icon">
    <!--CSS-->
    <link rel="stylesheet" href="{{ asset('Web_Restaurant/assets/ico/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Web_Restaurant/assets/css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('Web_Restaurant/assets/css/style-about.css') }}">
    <link rel="stylesheet" href="{{ asset('Web_Restaurant/assets/css/style-contact.css') }}">
    <link rel="stylesheet" href="{{ asset('Web_Restaurant/assets/css/style-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('Web_Restaurant/assets/css/style-table.css') }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Thêm liên kết icon nếu cần -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!--JS-->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!--Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Zilla+Slab:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main">
    
    @include('layoutUser.header')

    @yield('content')
    
    @include('layoutUser.footer')
    
</body>

</html>