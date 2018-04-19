@extends('layouts.master')

@section('heading')
    <h1>{{ __('Sửa người dùng') }}</h1>
@stop

@section('content')


    {!! Form::model($user, [
            'method' => 'PATCH',
            'route' => ['users.update', $user->id],
            'files'=>true,
            'enctype' => 'multipart/form-data'
            ]) !!}

    @include('users.form', ['submitButtonText' =>  __('Cập nhật')])

    {!! Form::close() !!}

@stop