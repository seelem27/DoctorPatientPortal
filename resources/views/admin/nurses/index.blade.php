@extends('layouts.app')

@section('content')
    <h3 class="page-title">Nurse</h3>
    {{-- @can('nurse_create')
    <p>
        <a href="{{ route('admin.nurses.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>        
    </p>
    @endcan --}}

    <section class="box">
        <div class="box-header">
            <h3 class="box-title">Nurse List</h3>
        </div>

        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($nurses) > 0)
                        @foreach ($nurses as $nurse)
                            <tr data-entry-id="{{ $nurse->id }}">
                                <td>{{ $nurse->id}}</td>
                                <td>{{ $nurse->name}}</td>
                                <td>{{ $nurse->phone }}</td>
                                <td>{{ $nurse->users->email or ''}}</td>
                                <td>{{ $nurse->address }}</td>
                                <td>
                                    @can('nurse_view')
                                    <a href="{{ route('admin.nurses.show',[$nurse->id]) }}" class="btn btn-xs btn-primary">View</a>
                                    @endcan
                                    @can('nurse_edit')
                                    <a href="{{ route('admin.nurses.edit',[$nurse->id]) }}" class="btn btn-xs btn-info">Edit</a>
                                    @endcan
                                    {{-- @can('nurse_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.nurses.destroy', $nurse->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan --}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">No entries in table</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>
@stop

@section('javascript') 
    <script>
        // @can('nurse_delete')
        //     window.route_mass_crud_entries_destroy = '{{ route('admin.nurses.mass_destroy') }}';
        // @endcan
    </script>
@endsection