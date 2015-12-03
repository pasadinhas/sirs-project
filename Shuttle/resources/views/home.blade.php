@extends('app')

@section('content')
    @if(!Auth::check())

        @section('style')
            <style rel="stylesheet">
                body {
                    background: url('/imgs/bg{{mt_rand(1,2)}}.jpg') !important;
                    background-size: cover !important;
                    color: white;
                    text-shadow: 0 0 5px black;
                }

                .jumbotron {
                    background: rgba(0,0,0,0.3);
                }

            </style>
        @stop

    <br>
    <br>
    <br>
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-6">
                <h1 class="welcome-text">Welcome to Wonder Shuttle!</h1>
                <p class="welcome-description">Pick a date and a destination, we and the Force will take care of the rest!</p>
            </div>
            <div class="col-md-5 col-md-offset-1">
                <form method="post" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        {!! Recaptcha::render() !!}
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-success form-control">Login</button>
                </form>
            </div>
        </div>
        <br/><br/><br/>
        <div class="row">
            <div class="col-lg-offset-7 col-md-5">
                <h4>New to WonderShuttle? Create an account!</h4>
                <form method="post" action="{{ route('user.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input class="form-control" type="text" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="id_document" placeholder="Identification Document">
                    </div>
                    <button type="submit" class="btn btn-success form-control">Create</button>
                </form>
            </div>
        </div>
    </div>
    @else
        <div class="jumbotron">
            <h1 class="text-primary">Wonder Shuttle salutes you!</h1>
            <h2 class="text-warning">We have the Force that drives the world.</h2>
            <br>
            <img src="../imgs/logo.png" class="img-responsive center-block">
        </div>
    @endif
@stop