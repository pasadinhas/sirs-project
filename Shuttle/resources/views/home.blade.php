@extends('app')

@section('content')
    @if(!Auth::check())
    <br>
    <br>
    <br>
    <div class="jumbotron row">
        <div class="col-md-offset-4 col-md-4">
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
    @else
        <div class="jumbotron">
            <h1 class="text-primary">Home For Shuttle Reservations</h1>
            <h2 class="text-warning">We are the force that drives the world.</h2>
            <img src="http://www.shuttlefinder.net/wp-content/uploads/2014/02/SuperShuttle_Van_HiRes.png" class="img-responsive center-block">
        </div>
    @endif
@stop