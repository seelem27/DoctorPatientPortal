@extends('layouts.app')

@section('content')
    <h3 class="page-title">Nurse</h3>

    <section class="box">
        <div class="box-header">
            <h3 class="box-title">View Nurse</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Name</th>
                            <td>{{ $nurse->name }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $nurse->phone }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $nurse->users->email }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $nurse->address }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

            

        <p>&nbsp;</p>
        <a href="{{ route('admin.nurses.index') }}" class="btn btn-default">Back to list</a>
    </div>
</section>
@stop