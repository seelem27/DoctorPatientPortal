@extends('layouts.app')

@section('content')
    <h3 class="page-title">Roles</h3>
    
    {!! Form::model($role, ['method' => 'PUT', 'route' => ['admin.roles.update', $role->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            Edit
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('title', 'Title*', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title'))
                        <p class="help-block">
                            {{ $errors->first('title') }}
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
                href="{{ route('admin.roles.index') }}"
                style="margin-right: 15px; background-color:red; color:white ">
                Cancel
            </a>
        </div>
    </div>
    {{-- {!! Form::submit(trans('Update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!} --}}
@stop

