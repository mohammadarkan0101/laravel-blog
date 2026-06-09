<head>
    <!-- Charset -->
    <meta charset="utf-8">
    <!-- Responsive viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Bootstrap with Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <!-- Title Pages -->
    <title>{{ $title ?? config('app.name') }}</title>
</head>
