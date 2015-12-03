<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservations System</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <style>

    </style>
    @yield('style')
</head>
<body>
    @yield('modal')
    @include('topnav')

    <div class="container">
        @include('flash::message')
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    @yield('javascript')
</body>
</html>