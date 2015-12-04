@extends('app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8  toppad" >
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $user->name }}</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10 col-lg-10 ">
                                    <table class="table table-user-information">
                                        <tbody>
                                        <tr>
                                            <td>Username:</td>
                                            <td>
                                                {{ $user->username }}
                                                @if($user->isAdmin())
                                                    (Admin)
                                                @elseif($user->isDriver())
                                                    (Driver)
                                                @elseif($user->isManager())
                                                    (Manager)
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>ID Document</td>
                                            <td>{{ $user->id_document }}</td>
                                        </tr>

                                        <tr>
                                            <td>Karma</td>
                                            <td>{{ $user->karma }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop