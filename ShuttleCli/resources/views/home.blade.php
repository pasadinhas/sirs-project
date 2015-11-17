@extends('master')

@section('content')
    <br>
    <br>
    <br>
    <div class="jumbotron row">
        <div class="col-md-offset-4 col-md-4">
            <h2>Login</h2>
            <br>
            <form method="post" action="{{ route('secure.login') }}">
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
@endsection