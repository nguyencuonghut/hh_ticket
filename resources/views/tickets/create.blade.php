@extends('layouts.master')
@section('heading')
    <h1>Tạo mới phiếu C.A.R</h1>
@stop
@section('content')

    {!! Form::open([
            'route' => 'tickets.store',
            'files'=>true,
            'enctype' => 'multipart/form-data'
    ]) !!}
    @include('tickets.form', ['submitButtonText' => __('Tạo mới')])
    {!! Form::close() !!}

@stop

