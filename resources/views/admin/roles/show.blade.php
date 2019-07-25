@extends('layouts.app')

@section('content')
    <h3 class="page-title">Roles</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            View
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Role</th>
                            <td>{{ $role->title }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="users">
            <table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>User Role</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                @if (count($users) > 0)
                    @foreach ($users as $user)
                        <tr data-entry-id="{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role->title or '' }}</td>
                            <td>
                                @can('user_view')
                                    <a href="{{ route('admin.users.show',[$user->id]) }}" class="btn btn-xs btn-primary">View</a>
                                @endcan

                                @can('user_edit')
                                    <a href="{{ route('admin.users.edit',[$user->id]) }}" class="btn btn-xs btn-info">Edit</a>
                                @endcan

                                @can('user_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("Are you sure")."');",
                                        'route' => ['admin.users.destroy', $user->id])) !!}
                                    {!! Form::submit(trans('Delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="9">No entries in table</td>
                </tr>
                @endif
                </tbody>
            </table>
            </div>
        </div>

            <p>&nbsp;</p>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-default">Back to list</a>
        </div>
    </div>
@stop