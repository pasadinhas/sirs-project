@extends('app')

@section('content')
    <br>
    <br>
    <br>
    <div class="jumbotron row">
        <div class="col-md-offset-4 col-md-4">
            <h2>Create Trip</h2>
            <br>
            <form method="post" action="{{ route('trip.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input class="form-control" type="number" name="shuttle_id" placeholder="Identification of shuttle">
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" name="driver_id" placeholder="Identification of driver">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="origin" placeholder="Origin">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="destination" placeholder="Destination">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="leaves_at" placeholder="Leaves at">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="arrives_at" placeholder="Arrives at">
                </div>
                <button type="submit" class="btn btn-success form-control">Create</button>
            </form>
        </div>
    </div>
@stop