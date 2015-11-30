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
                    @if($user->isAdmin() || $user->isManager())
                        <th></th>
                    @endif
                    <th>Admin</th>
                    @if($user->isAdmin())
                        <th></th>
                    @endif
                    <th>Driver</th>
                    @if($user->isAdmin() || $user->isManager())
                        <th></th>
                    @endif
                    <th>Manager</th>
                    @if($user->isAdmin() || $user->isManager())
                        <th></th>
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
                        @if($user->isAdmin() || $user->isManager())
                            <td>
                                <form method="post" action="{{ route('user.karma', array('id_document' => $u->id_document)) }}">
                                    {{ csrf_field() }}
                                    <div class="col-xs-12 form-group">
                                        <input class="form-control" type="text" name="karma" placeholder="Karma" maxlength="3">
                                        <button type="submit" class="btn btn-success btn-xs ">Ok</button>
                                    </div>
                                </form>
                            </td>
                        @endif
                        <td>
                            @if($u->isAdmin())
                                <span class="glyphicon glyphicon-ok"></span>
                            @else
                                <span class="glyphicon glyphicon-remove"></span>
                            @endif
                        </td>
                        @if($user->isAdmin())
                            <td>
                                <a href="{{ URL::route('user.admin', array('id_document' => $u->id_document)) }}">
                                    @if($u->isAdmin())
                                        Unset Admin
                                    @else
                                        Set Admin
                                    @endif
                                </a>
                            </td>
                        @endif
                        <td>
                            @if($u->isDriver())
                                <span class="glyphicon glyphicon-ok"></span>
                            @else
                                <span class="glyphicon glyphicon-remove"></span>
                            @endif
                        </td>
                        @if($user->isAdmin() || $user->isManager())
                            <td>
                                <a href="{{ URL::route('user.driver', array('id_document' => $u->id_document)) }}">
                                    @if($u->isDriver())
                                        Unset Driver
                                    @else
                                        Set Driver
                                    @endif
                                </a>
                            </td>
                        @endif
                        <td>
                            @if($u->isManager())
                                <span class="glyphicon glyphicon-ok"></span>
                            @else
                                <span class="glyphicon glyphicon-remove"></span>
                            @endif
                        </td>
                        @if($user->isAdmin() || $user->isManager())
                            <td>
                                <a href="{{ URL::route('user.manager', array('id_document' => $u->id_document)) }}">
                                    @if($u->isManager())
                                        Unset Manager
                                    @else
                                        Set Manager
                                    @endif
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