@extends('layouts.master')
@section('heading')
    <h1>{{ __('Tạo người dùng') }}</h1>
@stop

@section('content')
    {!! Form::open([
            'route' => 'users.store',
            'files'=>true,
            'enctype' => 'multipart/form-data'

            ]) !!}
    @include('users.form', ['submitButtonText' => __('Tạo mới')])

    {!! Form::close() !!}


@stop