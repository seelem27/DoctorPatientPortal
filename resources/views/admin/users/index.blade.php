@extends('layouts.app')

@section('content')
    <h3 class="page-title">Users</h3>
    @can('user_create')
    <p>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">Add New</a>

    </p>
    @endcan

    <section class="box">
        <div class="box-header">
            <h3 class="box-title">User List</h3>
        </div>

        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($users) > 0)
                        @foreach ($users as $user)
                            <tr data-entry-id="{{ $user->id }}">
                                <td>{{ $user->id }}</td>
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
                                        @if($user->deleted_at != null)
                                        @else
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("Are you sure")."');",
                                                'route' => ['admin.users.destroy', $user->id])) !!}
                                            {!! Form::submit(trans('Delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                            {!! Form::close() !!}
                                        @endif
                                    @endcan

                                    @can('user_status')
                                        @if($user->deleted_at == null)
                                        @else
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'PUT',
                                                'onsubmit' => "return confirm('".trans("Are you sure")."');",
                                                'route' => ["admin.users.restore", $user->id])) !!}
                                            {!! Form::submit(trans('Reactivate'), array('class' => 'btn btn-xs btn-warning')) !!}
                                            {!! Form::close() !!}
                                        @endif
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
    </section>
@stop

@section('javascript')
    <script>
        // @can('user_delete')
        //     window.route_mass_crud_entries_destroy = '{{ route('admin.users.mass_destroy') }}';
        // @endcan

    </script>
@endsection
