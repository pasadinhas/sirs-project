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
                    <th>Driver</th>
                    <th>Manager</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->id_document }}</td>
                        <td>
                            <form action="{{route('user.karma', [$u->id])}}" method="post">
                                <input type="number" style="width: 7em;" class="form-control input-sm" name="karma" value="{{ $u->karma }}"></td>
                            </form>
                        <td>
                            <input type="checkbox" @if($u->isDriver()) checked @endif data-id="{{$u->id}}" toggle-driver>
                        </td>
                        <td>
                            <input type="checkbox" @if($u->isManager()) checked @endif data-id="{{$u->id}}" toggle-manager>
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
        $("*[toggle-driver]").change(function(){
            $("input[type=checkbox]").attr('disabled', true)
            var id = $(this).data('id')
            window.location.replace('/user/' + id + '/driver')
        })

        $("*[toggle-manager]").change(function(){
            $("input[type=checkbox]").attr('disabled', true)
            var id = $(this).data('id')
            window.location.replace('/user/' + id + '/manager')
        })
    </script>
@stop