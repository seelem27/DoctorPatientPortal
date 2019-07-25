@extends('layouts.app')

@section('content')
    <h3 class="page-title">Services</h3>
    @can('service_create')
    <p>
        <a href="{{ route('admin.services.create') }}" class="btn btn-success">Add New</a>
        
    </p>
    @endcan

    <section class="box">
        <div class="box-header">
            <h3 class="box-title">Service List</h3>
        </div>

        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Service Name</th>
                        <th>Price (RM)</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($services) > 0)
                        @foreach ($services as $service)
                            <tr data-entry-id="{{ $service->id }}">
                                <td>{{ $service->id }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->price }}</td>
                                <td>
                                    @can('service_view')
                                    <a href="{{ route('admin.services.show',[$service->id]) }}" class="btn btn-xs btn-primary">View</a>
                                    @endcan

                                    @can('service_edit')
                                    <a href="{{ route('admin.services.edit',[$service->id]) }}" class="btn btn-xs btn-info">Edit</a>
                                    @endcan
                                    
                                    @can('service_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("Are you sure")."');",
                                        'route' => ['admin.services.destroy', $service->id])) !!}
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
    </section>
@stop

@section('javascript') 
    <script>
        @can('service_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.services.mass_destroy') }}';
        @endcan

    </script>
@endsection