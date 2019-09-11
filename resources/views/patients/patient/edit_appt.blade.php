@extends('layouts.app')

@section('content')
    <h3 class="page-title">Appointments</h3>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    {!! Form::model($appointment, ['method' => 'PUT', 'route' => ['admin.appointments.update_appt', $appointment->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            Edit
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('patient_id', 'Patient*', ['class' => 'control-label']) !!}
                    <text id="patient_id" name="patient_id" class="form-control select2" required>
						<text value="{{ $patient->id }}" {{ (old("patient_id") == $patient->id ? "selected":"") }}>{{ $patient->name }}</text>
					</text>
                    <p class="help-block"></p>
                    @if($errors->has('patient_id'))
                        <p class="help-block">
                            {{ $errors->first('patient_id') }}
                        </p>
                    @endif
                </div>
            </div>
            
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
                    <label>Start Time</label>
                    <div class="input-group datetime">
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
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
                        {!! Form::text('finish_time', old('finish_time'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    </div>
                    <p class="help-block"></p>
                    @if($errors->has('finish_time'))
                        <p class="help-block">
                            {{ $errors->first('finish_time') }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('comments', 'Comments', ['class' => 'control-label']) !!}
                    {!! Form::textarea('comments', old('comments'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('comments'))
                        <p class="help-block">
                            {{ $errors->first('comments') }}
                        </p>
                    @endif
                </div>
            </div>             --}}
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
                href="{{ route('admin.appointments.get_appt') }}"
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $('.datetime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm'
        }).on('dp.show', function () {
            $('a.btn[data-action="incrementMinutes"], a.btn[data-action="decrementMinutes"]').removeAttr('data-action').attr('disabled', true);
            $('span.timepicker-minute[data-action="showMinutes"]').removeAttr('data-action').attr('disabled', true).text('00');
        }).on('dp.change', function () {
            $(this).val($(this).val().split(':')[0]+':00')
            $('span.timepicker-minute').text('00')
        });
    </script>

    {{-- <script>
        $('.open-datetimepicker').click(function(event){
        event.preventDefault();
        $('.datetime').click();
    });
    </script> --}}


@stop