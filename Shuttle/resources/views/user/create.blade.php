@extends('app')

@section('content')
    <br>
    <br>
    <br>
    <div class="jumbotron row">
        <div class="col-md-offset-4 col-md-4">
            <h2>Create User</h2>
            <br>
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
@stop