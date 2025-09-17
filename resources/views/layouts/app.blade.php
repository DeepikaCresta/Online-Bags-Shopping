<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="{{ asset('vendor/sangam-toastr/toastr.min.css') }}">
    <script src="{{ asset('vendor/sangam-toastr/toastr.min.js') }}"></script>
</head>

<body class="font-sans antialiased">
    @include('layouts.header')
    <main class="px-10">
        {{ $slot }}
    </main>
    @include('layouts.footer')
    @livewireScripts
    @include('sangam-toastr::toastr')
</body>

</html>

