<!DOCTYPE html>
<html>
<head>
    <title>IKEA</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/libs.css">
    <script type="application/javascript" src="/js/libs.js"></script>
</head>
<body>
<div class="container">
    @include('partials.navbar')
    @yield('content')
</div>

@yield('footer')
</body>
</html>