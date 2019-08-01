@extends('layouts.app')

@section('content')
    <h3 class="page-title">Doctor</h3>

    {!! Form::model($doctor, ['method' => 'PUT', 'route' => ['admin.doctors.update', $doctor->id]]) !!}

    <section class="box">
        <div class="box-header">
            <h3 class="box-title">Edit Doctor</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('phone', 'Phone', ['class' => 'control-label']) !!}
                    {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('phone'))
                        <p class="help-block">
                            {{ $errors->first('phone') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('address', 'Address', ['class' => 'control-label']) !!}
                    {!! Form::textarea('address', old('address'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address'))
                        <p class="help-block">
                            {{ $errors->first('address') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('service_id', 'Services*', ['class' => 'control-label']) !!}
                    {!! Form::select('service_id', $services, old('service_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('service_id'))
                        <p class="help-block">
                            {{ $errors->first('service_id') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="form-group">
        <div class="container-fluid">
            <button type="submit"
                class="btn btn-success"
                style="margin-right: 15px;">
                Update
            </button>
            <a class="btn btn-default btn-close"
                href="{{ route('admin.doctors.index') }}"
                style="margin-right: 15px; background-color:red; color:white ">
                Cancel
            </a>
        </div>
    </div>
    {{-- {!! Form::submit(trans('Update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!} --}}
@stop

@section('javascript')
    @parent
    <script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>
    $(function() {
      $('input[name="dob"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10),
        dateFormat: "{{ config('app.date_format_js') }}"
      }, function(start, end, label) {
        var years = moment().diff(start, 'years');
      });
    });
  </script>
@stop
