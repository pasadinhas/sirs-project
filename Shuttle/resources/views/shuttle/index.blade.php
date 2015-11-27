@extends('app')

@section('content')
    {{-- */$user = Auth::user()/* --}}
    <br>
    <div class="jumbotron">
        <h2>The Wonder Shuttles at service</h2>
        <div class="panel">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Shuttle Name</th>
                        <th>Shuttle ID</th>
                        <th>Seats</th>
                        <th>Delete</th>
                        @if($user->isAdmin())
                            <th>Change key</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shuttles as $shuttle)
                        <tr>
                            <td>{{ $shuttle->name }}</td>
                            <td>{{ $shuttle->id }}</td>
                            <td>{{ $shuttle->seats }}</td>
                            <td align="center" width="7%">
                                <a href="{{ URL::route('shuttle.delete', array('id' => $shuttle->id)) }}"> <!--TODO: Change href-->
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                            @if($user->isAdmin())
                                <td align="center" width="10%">
                                    <a href="#{{ $shuttle->id }}"> <!--TODO: Change href-->
                                        <span class="glyphicon glyphicon-cog"></span>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop