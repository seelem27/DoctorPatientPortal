@extends('layouts.auth')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <div class="row" style="background-color:#3c8dbc">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ ucfirst(config('app.name')) }} Register</div>
                <div class="panel-body">

                    <form class="form-horizontal"
                        role="form"
                        method="POST"
                        action="/register">
                        {{ csrf_field() }}

                        @include('partials.formerrors')

                        <div class="form-group">
                            <label class="col-md-4 control-label">Name</label>
    
                            <div class="col-md-6">
                                <input type="text"
                                    class="form-control"
                                    name="name"
                                    id="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Email</label>

                            <div class="col-md-6">
                                <input type="email"
                                    class="form-control"
                                    name="email"
                                    id="email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Password</label>
    
                            <div class="col-md-6">
                                <input type="password"
                                    class="form-control"
                                    name="password"
                                    id="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Password Confirmation</label>
    
                            <div class="col-md-6">
                                <input type="password"
                                    class="form-control"
                                    name="password_confirmation"
                                    id="password_confirmation">
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <label class="col-md-4 control-label">Date of Birth</label>                            
                            <div class='col-sm-6'>
                                <div class='input-group date' id='datetimepicker3'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar-o open-datetimepicker"></span>
                                    </span>
                                </div>
                            </div>                           
                        </div> --}}

                        <div class="form-group">
                            <label class="col-md-4 control-label">Phone</label>
    
                            <div class="col-md-6">
                                <input type="text"
                                    class="form-control"
                                    {{-- pattern="^0(10|12|13|14|16|17|18)\d{7}$" --}}
                                    name="phone"
                                    id="phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Address</label>
    
                            <div class="col-md-6">
                                <textarea row="3"
                                    cols="40"
                                    class="form-control"
                                    style="resize: none"
                                    name="address"
                                    id="address"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit"
                                    class="btn btn-success"
                                    style="margin-right: 15px;">
                                    Submit
                                </button>
                                <a class="btn btn-default btn-close"
                                    href="{{ route('auth.login') }}"
                                    style="margin-right: 15px; background-color:red; color:white ">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
                            
@section('javascript')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#datetimepicker3').datetimepicker({
                format: 'DD-MM-YYYY',
            });
        });
    </script>
@stop
                    