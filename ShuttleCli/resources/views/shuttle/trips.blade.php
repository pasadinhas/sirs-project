@extends('master')

@section('content')
    <h2>Trips</h2>
    <br/><br/>
    <table class="table table-inverse">
        <tr>
            <th>Leaves In</th>
            <th>Origin</th>
            <th>Destination</th>
        </tr>
        @foreach($trips as $trip)
        <tr>
            <td>
                <a href="/trip/{{$trip->id}}">{{(new \Carbon\Carbon($trip->leaves_at))->diffForHumans()}}</a>
            </td>
            <td>{{$trip->origin}}</td>
            <td>{{$trip->destination}}</td>
        </tr>
        @endforeach
    </table>
@stop