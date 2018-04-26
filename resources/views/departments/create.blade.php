@extends('layouts.master')

@section('content')
    {!! Form::open([
            'route' => 'departments.store',
            ]) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        {!! Form::label( __('Name'), 'Tên phòng/ban', ['class' => 'control-label']) !!}
        {!! Form::text('name', null,['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label( __('Description'), 'Mô tả:', ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
    {!! Form::submit("Tạo mới", ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}

@endsection