@extends('layouts.app')

@section('content')
    <h3 class="page-title">Working Hours</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.working_hours.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            Create
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('doctor_id', 'Doctor*', ['class' => 'control-label']) !!}
					<select name="doctor_id" id="doctor_id" value="{{ old('doctor_id') }}" class="form-control" required>
						<option value="">Please select</option>
						@foreach($doctors as $doctor)
						<option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
						@endforeach
					</select>
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
                    {!! Form::text('date', null, ['class' => 'form-control date', 'placeholder' => '', 'required' => '']) !!}
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
                    {!! Form::label('start_time', 'Start time*', ['class' => 'control-label']) !!}
                    {!! Form::text('start_time', old('start_time'), ['class' => 'form-control timepicker', 'placeholder' => '', 'required' => '']) !!}
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
                    {!! Form::label('finish_time', 'Finish time', ['class' => 'control-label']) !!}
                    {!! Form::text('finish_time', old('finish_time'), ['class' => 'form-control timepicker', 'placeholder' => '']) !!}
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

    {!! Form::submit(trans('Save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>  
    <script>
        $('.timepicker').datetimepicker({
            autoclose: true,
            interval: 60,
            timeFormat: 'HH:mm:ss',
            dynamic: false,
            dropdown: true,
            scrollbar: true           
        });
    </script>
    <script>
        $(function() {
          $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            // minYear: 1901,
            // maxYear: parseInt(moment().format('YYYY'),10),
            minDate: 0,
            locale: {
                format: "YYYY-MM-DD",
            }
          }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            console.log(start, end, label);
          });
        });
    </script>
@stop