<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oh, snap!</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link rel="shortcut icon" href="/imgs/logo.png">
    <style>
        body {
            background: url('/imgs/bg2.jpg') !important;
            background-size: cover !important;
            color: white;
            text-shadow: 1px 1px 2px black;
            padding-top: 100px;
        }

        .jumbotron {
            background: rgba(0,0,0,0.6);
        }
    </style>
</head>
<body>
    <div class="container">
        @if(\Illuminate\Support\Facades\Auth::user())
            @include('topnav')
        @endif
        <div class="jumbotron">
            <h1>Oh Snap!</h1>
            <h3>Looks like something went terribly wrong!</h3>
            <br/><br/>
            <p>We'll send a trained Force of computer people to solve the problem in our servers.</p>
            <p>Try to visit the <a href="/">homepage</a>, maybe?</p>
        </div>
    </div>
</body>
</html>