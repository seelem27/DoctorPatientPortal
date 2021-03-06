@extends('layouts.app')

@section('content')
    <h3 class="page-title">Patient</h3>

    <section class="box">
        <div class="box-header">
            <h3 class="box-title">View Patient</h3>
        </div>

        <div class="box">
            <div class="box-header">
                <div class="col-md-6 box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>Name</th>
                            <td>{{ $patient->name }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $patient->phone }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $patient->users->email }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $patient->address }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            <ul class="nav nav-tabs" role="tablist">    
                <li role="presentation" class="active"><a href="#appointments" aria-controls="appointments" role="tab" data-toggle="tab">Appointments</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
    
            <div role="tabpanel" class="box-body table-responsive no-padding active" id="appointments">
            <table class="table table-bordered table-striped {{ count($appointments) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>Patient name</th>
                        <th>Patient Phone</th>
                        <th>Patient Email</th>
                        <th>Doctor Name</th>
                        <th>Start Time</th>
                        <th>Finish Time</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>Blood Pressure</th>
                        <th>Comments</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                @if (count($appointments) > 0)
                    @foreach ($appointments as $appointment)
                    <tr data-entry-id="{{ $appointment->id }}">
                        <td>{{ $appointment->patient->name or '' }}</td>
                        <td>{{ isset($appointment->patient) ? $appointment->patient->phone : '' }}</td>
                        <td>{{ isset($appointment->patient) ? $appointment->patient->users->email : '' }}</td>
                        <td>{{ $appointment->doctor->name or '' }}</td>
                        <td>{{ $appointment->start_time }}</td>
                        <td>{{ $appointment->finish_time }}</td>
                        <td>{{ $appointment->weight }}</td>
                        <td>{{ $appointment->height }}</td>
                        <td>{{ $appointment->bloodPressure }}</td>
                        <td>{!! $appointment->comments !!}</td>
                        <td>
                            @can('appointment_view')
                                <a href="{{ route('admin.appointments.show',[$appointment->id]) }}" class="btn btn-xs btn-primary">View</a>
                            @endcan

                            @can('appointment_edit')
                                <a href="{{ route('admin.appointments.edit',[$appointment->id]) }}" class="btn btn-xs btn-info">Edit</a>
                            @endcan

                            @can('appointment_delete')
                                {!! Form::open(array(
                                    'style' => 'display: inline-block;',
                                    'method' => 'DELETE',
                                    'onsubmit' => "return confirm('".trans("Are_you_sure?")."');",
                                    'route' => ['admin.appointments.destroy', $appointment->id])) !!}
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
        <a href="{{ route('admin.patients.index') }}" class="btn btn-default">Back to list</a>
    </div>
</section>
@stop