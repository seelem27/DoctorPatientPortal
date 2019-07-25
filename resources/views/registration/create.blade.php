@extends('layouts.auth')

@section('content')
    <div class="row">
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

                        <div class="form-group">
                            <label class="col-md-4 control-label">Date of Birth</label>
    
                            <div class="col-md-6">
                                <style>
                                    ::-webkit-datetime-edit-year-field:not([aria-valuenow]),
                                    ::-webkit-datetime-edit-month-field:not([aria-valuenow]),
                                    ::-webkit-datetime-edit-day-field:not([aria-valuenow]) {
                                        color: transparent;
                                    }
                                </style>
                                <input type="date"
                                    class="form-control"
                                    name="dob"
                                    id="dob">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Phone</label>
    
                            <div class="col-md-6">
                                <input type="text"
                                    class="form-control"
                                    pattern="^0(10|12|13|14|16|17|18)\d{7}$"
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
                                    class="btn btn-primary"
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
                            

                    