<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Login' }} — ODOT ERP</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'], 'assets-build')
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative" style="background-image: url('{{ asset('images/logo.png') }}'); background-size: cover; background-position: center;">
    {{-- Dark overlay with blur --}}
    <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-md pointer-events-none z-0"></div>
    
    {{-- Decorative Background Elements --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-500/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-accent-500/30 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md z-10">
        {{ $slot }}
    </div>
</body>
</html>
