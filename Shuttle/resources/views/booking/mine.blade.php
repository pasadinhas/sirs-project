@extends('app')

@section('content')
    <div class="jumbotron">
        <h2>My Reservations</h2>
        @if($reservations->isEmpty())
            <p>You don't have any bookings. <a href="{{route('booking.index')}}">Make a booking!</a></p>
        @else
            <div class="panel">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Departure Time</th>
                        <th>Arrival Time</th>
                        <th>Cancel</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reservations as $trip)
                        <tr>
                            <td>{{ $trip->origin }}</td>
                            <td>{{ $trip->destination }}</td>
                            <td>{{ $trip->leaves_at }}</td>
                            <td>{{ $trip->arrives_at }}</td>
                            <td>
                                <form action="{{ route('booking.destroy') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="trip_id" value="{{ $trip->id }}" />
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="submit" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@stop