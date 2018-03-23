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

@push('scripts')
    <script type="text/javascript">
        $("#source_id").select2({
            placeholder: "Chọn nguồn gốc",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#manager_id").select2({
            placeholder: "Chọn trưởng bộ phận",
            allowClear: true
        });
    </script>
@endpush
