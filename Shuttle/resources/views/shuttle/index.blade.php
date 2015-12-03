@extends('app')

@section('content')
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
                        @if(Auth::user()->isAdmin())
                            <th>Change key</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <a href="#create" data-toggle="modal" data-target="#modalCreate"><span style="color: #3c763d" class="glyphicon glyphicon-plus"></span></a>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if(Auth::user()->isAdmin())
                            <td></td>
                        @endif
                    </tr>
                    @foreach ($shuttles as $shuttle)
                        <tr>
                            <td><a href="{{route('shuttle.show', [$shuttle->name])}}">{{ $shuttle->name }}</a></td>
                            <td>{{ $shuttle->id }}</td>
                            <td>{{ $shuttle->seats }}</td>
                            <td align="center" width="7%">
                                <form action="{{route('shuttle.destroy', [$shuttle->id])}}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete"/>
                                    <button type="submit" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </form>
                            </td>
                            @if(Auth::user()->isAdmin())
                                <td align="center" width="10%">
                                    <button class="btn btn-default" data-toggle="modal" data-target="#myModal" data-shuttle-id="{{ $shuttle->id }}">
                                        <span class="glyphicon glyphicon-cog"></span>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                            <a href="#create" data-toggle="modal" data-target="#modalCreate"><span style="color: #3c763d" class="glyphicon glyphicon-plus"></span></a>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if(Auth::user()->isAdmin())
                            <td></td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('modal')
    <form action="{{ route('shuttle.edit.key') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" value="" name="id" value-shuttle-id>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Shuttle <span text-shuttle-id></span> - Change Key</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="key" class="control-label">New Key:</label>
                            <input type="text" maxlength="32" class="form-control" id="key" name="key">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Change Key</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('shuttle.store') }}" method="post">
        {{csrf_field()}}
        <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel2">Create a new Shuttle</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="i1" class="control-label">Shuttle Name</label>
                            <input type="text" class="form-control" id="i1" name="name">
                        </div>
                        <div class="form-group">
                            <label for="i2" class="control-label">Number of Seats</label>
                            <input type="number" class="form-control" id="i2" name="seats">
                        </div>
                        <div class="form-group">
                            <label for="key2" class="control-label">Shuttle Key</label>
                            <input type="text" maxlength="32" class="form-control" id="key2" name="key">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('javascript')
    <script>
        $(document).ready(function() {
            $('a[data-toggle=modal], button[data-toggle=modal]').click(function () {
                var data_id = '';
                if (typeof $(this).data('shuttle-id') !== 'undefined') {
                    data_id = $(this).data('shuttle-id');
                }
                $('*[value-shuttle-id]').val(data_id);
                $('*[text-shuttle-id]').text(data_id);
            })
        });
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').focus()
        })
    </script>
@stop