@extends('app')

@section('content')
    {{-- */$user = Auth::user()/* --}}
    <br>
    <div class="jumbotron">
        <h2>The Wonder users</h2>
        <div class="panel">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Document ID</th>
                    <th>Karma</th>
                    <th>Role</th>
                    @if($user->isAdmin() || $user->isManager())
                        <th>Modify</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->id_document }}</td>
                        <td>{{ $u->karma }}</td>
                        <td>
                            @if($u->isAdmin())
                                Admin
                            @elseif($u->isDriver())
                                Driver
                            @elseif($u->isManager())
                                Manager
                            @else
                                User
                            @endif
                        </td>
                        <td>
                            @if($user->isAdmin() || $user->isManager())
                                <a href="{{ URL::route('user.driver', array('id_document' => $u->id_document)) }}">
                                @if($u->isDriver())
                                    Unset Driver
                                @else
                                    Set Driver
                                @endif
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop