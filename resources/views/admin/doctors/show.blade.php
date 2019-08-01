@extends('layouts.app')

@section('content')
    <h3 class="page-title">Doctor</h3>

    <section class="box">
        <div class="box-header">
            <h3 class="box-title">View Doctor</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Name</th>
                            <td>{{ $doctor->name }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $doctor->phone }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $doctor->users->email }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $doctor->address }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            <ul class="nav nav-tabs" role="tablist">    
                <li role="presentation" class="active"><a href="#workinghours" aria-controls="workinghours" role="tab" data-toggle="tab">Working hours</a></li>
                <li role="presentation" class=""><a href="#appointments" aria-controls="appointments" role="tab" data-toggle="tab">Appointments</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">    
            <div role="tabpanel" class="tab-pane active" id="workinghours">
            <table class="table table-bordered table-striped {{ count($working_hours) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>Doctor Name</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>Finish Time</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($working_hours) > 0)
                        @foreach ($working_hours as $working_hour)
                            <tr data-entry-id="{{ $working_hour->id }}">
                                <td>{{ $working_hour->doctor->name or '' }}</td>
                                <td>{{ $working_hour->date }}</td>
                                <td>{{ $working_hour->start_time }}</td>
                                <td>{{ $working_hour->finish_time }}</td>
                                <td>
                                    @can('working_hour_view')
                                    <a href="{{ route('admin.working_hours.show',[$working_hour->id]) }}" class="btn btn-xs btn-primary">View</a>
                                    @endcan

                                    @can('working_hour_edit')
                                    <a href="{{ route('admin.working_hours.edit',[$working_hour->id]) }}" class="btn btn-xs btn-info">Edit</a>
                                    @endcan

                                    @can('working_hour_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.working_hours.destroy', $working_hour->id])) !!}
                                    {!! Form::submit(trans('Delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
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

            <div role="tabpanel" class="tab-pane " id="appointments">
            <table class="table table-bordered table-striped {{ count($appointments) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Patient Phone</th>
                        <th>Patient Email</th>
                        <th>Doctor Name</th>
                        <th>Start Time</th>
                        <th>Finish Time</th>
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
                                            'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
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
            <a href="{{ route('admin.doctors.index') }}" class="btn btn-default">Back to list</a>
        </div>
    </section>
@stop