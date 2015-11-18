@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
                <A href="" >Edit Profile</A>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $shuttle->name }}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="http://findicons.com/files/icons/978/cem_transport/128/travel_bus.png" class="img-circle img-responsive"> </div>
                            <div class=" col-md-9 col-lg-9 ">
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>ID:</td>
                                        <td>{{ $shuttle->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Number of seats:</td>
                                        <td>{{ $shuttle->seats }}</td>
                                    </tr>
                                    <tr>
                                        <td>Authentication Key:</td>
                                        <td>{{ $shuttle->key }}</td>
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
@stop