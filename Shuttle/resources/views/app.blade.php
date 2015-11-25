<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservations System</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
    @include('topnav')

    <div class="container">
        @include('flash::message')
        @yield('content')
    </div>

    @yield('footer')
</body>
</html>