@extends('layouts.app')

@section('content')
    <h3 class="page-title">Working Hours</h3>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    
    {!! Form::model($working_hour, ['method' => 'PUT', 'route' => ['admin.working_hours.update', $working_hour->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            Edit
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('doctor_id', 'Doctor*', ['class' => 'control-label']) !!}
                    {!! Form::select('doctor_id', $doctors, old('doctor_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('doctor_id'))
                        <p class="help-block">
                            {{ $errors->first('doctor_id') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('date', 'Date*', ['class' => 'control-label']) !!}
                    {!! Form::text('date', old('date'), ['class' => 'form-control date', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('date'))
                        <p class="help-block">
                            {{ $errors->first('date') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    <label>Start Time</label>
                    <div class="input-group datetime">
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o open-datetimepicker"></i>
                        </div>
                        {!! Form::text('start_time', old('start_time'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    </div>
                    <p class="help-block"></p>
                    @if($errors->has('start_time'))
                        <p class="help-block">
                            {{ $errors->first('start_time') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    <label>Finish Time</label>
                    <div class="input-group datetime">
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o open-datetimepicker"></i>
                        </div>
                        {!! Form::text('finish_time', old('finish_time'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    </div>
                    <p class="help-block"></p>
                    @if($errors->has('finish_time'))
                        <p class="help-block">
                            {{ $errors->first('finish_time') }}
                        </p>
                    @endif
                </div>
            </div>            
        </div>
    </div>

    <div class="form-group">
        <div class="container-fluid">
            <button type="submit"
                class="btn btn-success"
                style="margin-right: 15px;">
                Update
            </button>
            <a class="btn btn-default btn-close"
                href="{{ route('admin.working_hours.index') }}"
                style="margin-right: 15px; background-color:red; color:white ">
                Cancel
            </a>
        </div>
    </div>

    {{-- {!! Form::submit(trans('update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!} --}}
@stop

@section('javascript')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
    {{-- <script>
        $('.date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}"
        });
    </script> --}}
    {{-- <script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
    <script>
        $('.timepicker').datetimepicker({
            autoclose: true,
            timeFormat: "HH:mm:ss",
            timeOnly: true
        });
    </script> --}}
    <script>
        $('.datetime').datetimepicker({
            format: "HH:mm:ss",
        }).on('dp.show', function () {
            $('a.btn[data-action="incrementMinutes"], a.btn[data-action="decrementMinutes"]').removeAttr('data-action').attr('disabled', true);
            $('a.btn[data-action="incrementSeconds"], a.btn[data-action="decrementSeconds"]').removeAttr('data-action').attr('disabled', true);
            $('span.timepicker-minute[data-action="showMinutes"]').removeAttr('data-action').attr('disabled', true).text('00');
            $('span.timepicker-second[data-action="showSeconds"]').removeAttr('data-action').attr('disabled', true).text('00');
        }).on('dp.change', function () {
            $(this).val($(this).val().split(':')[0]+':00'+':00')
            $('span.timepicker-minute').text('00')
            $('span.timepicker-second').text('00')
        });
    </script>

    <script type="text/javascript">
        $('.date').datetimepicker({
            format: "YYYY-MM-DD",
        });
    </script>
@stop