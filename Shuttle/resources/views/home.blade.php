@extends('app')

@section('content')
    @if(!Auth::check())
    <br>
    <br>
    <br>
    <div class="jumbotron row">
        <div class="row-fluid">
            <div class="col-lg-1 welcome-text-box">
                <h1 class="welcome-text">Welcome to Wonder Shuttle!</h1>
                <p class="welcome-description">Pick a date and a destination, we and the Force will take care of the rest!</p>
            </div>
            <div class="col-lg-3 col-md-offset-1 col-md-2">
                <h2>Login</h2>
                <br>
                <form method="post" action="{{ route('login') }}">
                    {{ csrf_field() }}
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
        <div class="row-fluid">
        <div class="col-md-offset-0 col-md-4">
                <h2>Register</h2>
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
            <h1 class="text-primary">Home For Shuttle Reservations</h1>
            <h2 class="text-warning">We are the force that drives the world.</h2>
            <img src="http://www.shuttlefinder.net/wp-content/uploads/2014/02/SuperShuttle_Van_HiRes.png" class="img-responsive center-block">
        </div>
    @endif
@stop