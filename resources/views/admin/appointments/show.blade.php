@extends('layouts.app')

@section('content')
    <h3 class="page-title">Appointments</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            View
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Patient Name</th>
                            <td>{{ $appointment->patient->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ isset($appointment->patient) ? $appointment->patient->phone : '' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ isset($appointment->patient) ? $appointment->patient->users->email : '' }}</td>
                        </tr>
                        <tr>
                            <th>Doctor Name</th>
                            <td>{{ $appointment->doctor->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>Start Time</th>
                            <td>{{ $appointment->start_time }}</td>
                        </tr>
                        <tr>
                            <th>Finish Time</th>
                            <td>{{ $appointment->finish_time }}</td>
                        </tr>
                        <tr>
                            <th>Comments</th>
                            <td>{!! $appointment->comments !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.appointments.index') }}" class="btn btn-default">Back to list</a>
        </div>
    </div>
@stop