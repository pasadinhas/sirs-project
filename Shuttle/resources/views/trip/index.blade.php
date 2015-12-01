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
                </tbody>
            </table>
        </div>
    </div>
@stop