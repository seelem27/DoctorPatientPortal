@extends('layouts.app')

@section('content')
    <h3 class="page-title">Services</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.services.store']]) !!}

    <section class="panel panel-default">
        <div class="box-header">
            <h3 class="box-title">Create Service</h3>
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
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
                    {!! Form::label('price', 'Price*', ['class' => 'control-label']) !!}
                    {!! Form::text('price', old('price'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('price'))
                        <p class="help-block">
                            {{ $errors->first('price') }}
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
                Create
            </button>
            <a class="btn btn-default btn-close"
                href="{{ route('admin.services.index') }}"
                style="margin-right: 15px; background-color:red; color:white ">
                Cancel
            </a>
        </div>
    </div>

    {{-- {!! Form::submit(trans('Save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!} --}}
@stop

