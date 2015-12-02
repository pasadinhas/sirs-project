@extends('app')

@section('content')
    <div class="jumbotron">
        <h2>Book a Trip!</h2>
        <div class="panel">

            <div class="container">

                <h3>Filter trips</h3>

                <form class="form-inline">
                    <input class="form-control" type="text" name="origin" value="{{Input::get('origin')}}" placeholder="From...">
                    <input class="form-control" type="text" name="destination" value="{{Input::get('destination')}}" placeholder="To...">
                    <input class="form-control" type="date" name="day" value="{{Input::get('day')}}">
                    <button type="submit" class="btn bg-primary">Search</button>
                </form>

            </div>
            <br><br>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Departure Time</th>
                        <th>Arrival Time</th>
                        <th>Book!</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($trips as $trip)
                    <tr>
                        <td>{{ $trip->origin }}</td>
                        <td>{{ $trip->destination }}</td>
                        <td>{{ $trip->leaves_at }}</td>
                        <td>{{ $trip->arrives_at }}</td>
                        <td>
                            @if($reservations->contains($trip))
                                <form action="{{ route('booking.destroy') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="trip_id" value="{{ $trip->id }}" />
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="submit" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('booking.store') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="trip_id" value="{{ $trip->id }}" />
                                    <button type="submit" class="btn btn-success">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>

    </script>
@stop