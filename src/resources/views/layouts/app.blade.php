<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <title>Document</title>
    @yield('css')
</head>

<body class="body">
    <header class="header-index">
        <p class="header-ttl">FashionablyLate</p>
        @yield('header')
    </header>

    <main class="main">
        @yield('content')
    </main>
</body>

</html>