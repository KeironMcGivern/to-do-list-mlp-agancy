<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="/favicon.ico" />
    @routes
    @viteReactRefresh
    @vite(['resources/js/app.jsx', 'resources/sass/app.scss'])
    @inertiaHead
</head>

<body class="body">
    @yield('body')
</body>

</html>
