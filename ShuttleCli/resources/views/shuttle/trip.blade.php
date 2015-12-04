@extends('master')

@section('content')
    <h2>{{$trip->origin}} - {{$trip->destination}}</h2>
    <h6>{{new \Carbon\Carbon($trip->leaves_at)}} - {{new \Carbon\Carbon($trip->arrives_at)}}</h6>
    <br/><br/>
    <table class="table table-inverse">
        <tr>
            <th>Document ID</th>
            <th>Name</th>
            <th>Check-in</th>
        </tr>
        @foreach($trip->passengers as $passenger)
            <tr>
                <td>{{$passenger->id_document}}</td>
                <td>{{$passenger->name}}</td>
                <td>
                    @if ($attendances->contains(function($key, $value) use($passenger, $trip) {
                        return $value->user == $passenger->id && $value->trip == $trip->id;
                    }))
                        <form method="post" action="/checkout">
                            {{csrf_field()}}
                            <input type="hidden" name="user" value="{{$passenger->id}}"/>
                            <input type="hidden" name="trip" value="{{$trip->id}}"/>
                            <button class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
                        </form>
                    @else
                        <form method="post" action="/checkin">
                            {{csrf_field()}}
                            <input type="hidden" name="user" value="{{$passenger->id}}"/>
                            <input type="hidden" name="trip" value="{{$trip->id}}"/>
                            <button class="btn btn-default"><span class="glyphicon glyphicon-ok"></span></button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    @unless(\ShuttleCli\Trip::where('trip_id', $trip->id)->first() == null)
        <button class="btn btn-default" disabled>Already submited</button>
    @else
        <a href="/trip/{{$trip->id}}/send"><button class="btn btn-primary">Finish Attendance Check</button></a>
    @endunless
@stop