<!DOCTYPE html>
<html>
<head>
    <title>IKEA</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/libs.css">
    <script type="application/javascript" src="/js/libs.js"></script>
    @yield('head')
</head>
<body>
<div class="container">
    @include('partials.navbar')
    @if (session()->has('flash_success'))
        <div class="alert alert-success" roler="alert">
            {{ session()->get('flash_success') }}
        </div>
    @endif
    @if (session()->has('flash_info'))
        <div class="alert alert-info" roler="alert">
            {{ session()->get('flash_info') }}
        </div>
    @endif
    @yield('content')
</div>

@yield('footer')
</body>
</html>