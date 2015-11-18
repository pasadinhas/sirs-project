@extends('app')

@section('content')
    <br>
    <br>
    <br>
    <div class="jumbotron row">
        <div class="col-md-offset-4 col-md-4">
            <h2>Register Shuttle</h2>
            <br>
            <form method="post" action="{{ route('shuttle.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input class="form-control" type="text" name="name" placeholder="Identification of shuttle">
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" name="seats" placeholder="Number of Seats">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="key" placeholder="Authentication Key">
                </div>
                <button type="submit" class="btn btn-success form-control">Create</button>
            </form>
        </div>
    </div>
@stop