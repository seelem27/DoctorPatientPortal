@extends('layouts.app')

@section('content')
    <h3 class="page-title">Patient</h3>

    <section class="box">
        <div class="box-header">
            <h3 class="box-title">Patient List</h3>
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
                    @if (count($patients) > 0)
                        @foreach ($patients as $patient)
                            <tr data-entry-id="{{ $patient->id }}">
                                <td>{{ $patient->id}}</td>
                                <td>{{ $patient->name}}</td>
                                <td>{{ $patient->phone }}</td>
                                <td>{{ $patient->users->email or ''}}</td>
                                <td>{{ $patient->address }}</td>
                                <td>
                                    @can('patient_view')
                                    <a href="{{ route('admin.patients.show',[$patient->id]) }}" class="btn btn-xs btn-primary">View</a>
                                    @endcan
                                    @can('patient_edit')
                                    <a href="{{ route('admin.patients.edit',[$patient->id]) }}" class="btn btn-xs btn-info">Edit</a>
                                    @endcan
                                    {{-- @can('patient_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.patients.destroy', $patient->id])) !!}
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
    </div>
@stop

@section('javascript') 
    <script>
        // @can('patient_delete')
        //     window.route_mass_crud_entries_destroy = '{{ route('admin.patients.mass_destroy') }}';
        // @endcan
    </script>
@endsection