@extends('layouts.app')

@section('content')
    <h3 class="page-title">Services</h3>

    <section class="box">
        <div class="box-header">
            <h3 class="box-title">View Service</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Service Name</th>
                            <td>{{ $service->name }}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>{{ $service->price }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.services.index') }}" class="btn btn-default">Back to list</a>
        </div>
    </section>
@stop