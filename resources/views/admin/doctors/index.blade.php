@extends('layouts.app')

@section('content')
    <h3 class="page-title">Doctor</h3>
    {{-- @can('doctor_create')
    <p>
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>        
    </p>
    @endcan --}}

    <section class="box">
        <div class="box-header">
            <h3 class="box-title">Doctor List</h3>
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
						<th>Services</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($doctors) > 0)
                        @foreach ($doctors as $doctor)
                            <tr data-entry-id="{{ $doctor->id }}">
                                <td>{{ $doctor->id }}</td>
                                <td>{{ $doctor->name }}</td>
                                <td>{{ $doctor->phone }}</td>
                                <td>{{ $doctor->users->email }}</td>
                                <td>{{ $doctor->address }}</td>
								<td>                                    
                                    @foreach($doctor->services as $service)
                                        <span class="label label-success">{{ $service->name }}</span>
                                    @endforeach
                                </td>
                                								
                                <td>
                                    @can('doctor_view')
                                        <a href="{{ route('admin.doctors.show',[$doctor->id]) }}" class="btn btn-xs btn-primary">View</a>
                                    @endcan

                                    @can('doctor_edit')
                                        <a href="{{ route('admin.doctors.edit',[$doctor->id]) }}" class="btn btn-xs btn-info">Edit</a>
                                    @endcan
                                    
                                    {{-- @can('doctor_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.doctors.destroy', $doctor->id])) !!}
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
        // @can('doctor_delete')
        //     window.route_mass_crud_entries_destroy = '{{ route('admin.doctors.mass_destroy') }}';
        // @endcan

    </script>
@endsection