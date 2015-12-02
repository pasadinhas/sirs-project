@extends('app')

@section('content')
    {{-- */$user = Auth::user()/* --}}
    <br>
    <div class="jumbotron">
        <h2>Wonder Trips </h2>
        <div class="panel">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Trip ID</th>
                    <th>Shuttle ID</th>
                    <th>Driver ID</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure time</th>
                    <th>Arrival time</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7">
                            <a href="#create" data-toggle="modal" data-target="#modalCreate"><span style="color: #3c763d" class="glyphicon glyphicon-plus"></span></a>
                        </td>
                    </tr>
                @foreach ($trips as $trip)
                    <tr>
                        <td>{{ $trip->id }}</td>
                        <td>{{ $trip->shuttle_id }}</td>
                        <td>{{ $trip->driver_id }}</td>
                        <td>{{ $trip->origin }}</td>
                        <td>{{ $trip->destination }}</td>
                        <td>{{ $trip->leaves_at }}</td>
                        <td>{{ $trip->arrives_at }}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="7">
                            <a href="#create" data-toggle="modal" data-target="#modalCreate"><span style="color: #3c763d" class="glyphicon glyphicon-plus"></span></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('modal')
    <form action="{{ route('trip.store') }}" method="post">
        <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel2">Create a new Trip</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="i1" class="control-label">Origin</label>
                            <input type="text" class="form-control" id="i1" name="origin">
                        </div>
                        <div class="form-group">
                            <label for="i2" class="control-label">Destination</label>
                            <input type="text" class="form-control" id="i2" name="destination">
                        </div>
                        <div class="form-group">
                            <label for="i3" class="control-label">Departure Time</label>
                            <input type="datetime-local" class="form-control" id="i3" name="leaves_at">
                        </div>
                        <div class="form-group">
                            <label for="i4" class="control-label">Arrival Time</label>
                            <input type="datetime-local" class="form-control" id="i4" name="arrives_at">
                        </div>
                        <div class="form-group">
                            <label for="i6" class="control-label">Driver</label>
                            <select class="form-control" id="i6" name="driver_id">
                                @foreach(\Shuttle\User::where('is_driver', true)->get() as $driver)
                                    <option value="{{$driver->id}}">{{$driver->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="i7" class="control-label">Driver</label>
                            <select class="form-control" id="i7" name="shuttle_id">
                                @foreach(\Shuttle\Shuttle::all() as $shuttle)
                                    <option value="{{$shuttle->id}}">{{$shuttle->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop