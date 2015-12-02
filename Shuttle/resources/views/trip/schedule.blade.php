@extends('app')

@section('content')
    <br>
    <div class="jumbotron">
        <h2>My Schedule</h2>
        <div class="panel">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Shuttle</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure time</th>
                    <th>Arrival time</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($trips as $trip)
                    <tr>
                        <td>{{ $trip->shuttle->name }}</td>
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