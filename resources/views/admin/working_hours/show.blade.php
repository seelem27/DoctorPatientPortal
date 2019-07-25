@extends('layouts.app')

@section('content')
    <h3 class="page-title">Working Hours</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            View
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Doctor Name</th>
                            <td>{{ $working_hour->doctor->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>Working Date</th>
                            <td>{{ $working_hour->date }}</td>
                        </tr>
                        <tr>
                            <th>Start Time</th>
                            <td>{{ $working_hour->start_time }}</td>
                        </tr>
                        <tr>
                            <th>Finish Time</th>
                            <td>{{ $working_hour->finish_time }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.working_hours.index') }}" class="btn btn-default">Back to list</a>
        </div>
    </div>
@stop