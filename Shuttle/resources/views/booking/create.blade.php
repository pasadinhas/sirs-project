@extends('app')

@section('content')
    <br>
    <br>
    <br>
    <div class="jumbotron row">
        <div class="col-md-offset-4 col-md-4">
            <h2>Register Shuttle</h2>
            <br>
            <form method="post" action="{{ route('booking.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input class="form-control" type="number" name="trip_id" placeholder="Identification of trip">
                </div>
                <button type="submit" class="btn btn-success form-control">Create</button>
            </form>
        </div>
    </div>
@stop