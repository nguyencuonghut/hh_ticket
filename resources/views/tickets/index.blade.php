@extends('layouts.master')
@section('heading')

@stop

@section('content')

    <table class="table table-hover " id="tickets-table">
        <thead>
        <tr>
            <th>{{ __('Tiêu đề') }}</th>
            <th>{{ __('Ngày tạo') }}</th>
            <th>{{ __('Hạn trả lời') }}</th>
            <th>{{ __('Nguồn gốc') }}</th>
            <th>{{ __('Người tạo') }}</th>
        </tr>
        </thead>
    </table>

@stop

@push('scripts')
<script>
    $(function () {
        var table = $('#tickets-table').DataTable({
            processing: true,
            serverSide: true,

            ajax: '{!! route('tickets.data') !!}',
            columns: [
                {data: 'titlelink', name: 'title'},
                {data: 'created_at', name: 'created_at', searchable:false},
                {data: 'deadline', name: 'deadline', searchable:false},
                {data: 'source', name: 'source.name'},
                {data: 'name', name: 'creator.name'},
            ]
        });
    });
</script>
@endpush
