@extends('layouts.master')

@section('content')
    <div class="col-lg-12 currenttask">
        <table class="table table-hover">
            <h3>Tất cả phòng/ban</h3>
            <thead>
            <thead>
            <tr>
                <th>{{ __('Tên') }}</th>
                <th>{{ __('Mô tả') }}</th>
                @if(Entrust::hasRole('administrator'))
                    <th>{{ __('Thao tác') }}</th>
                @endif
            </tr>
            </thead>
            <tbody>

            @foreach($department as $dep)
                <tr>
                    <td>{{$dep->name}}</td>
                    <td>{{Str_limit($dep->description, 50)}}</td>
                    @if(Entrust::hasRole('administrator'))
                        <td>   {!! Form::open([
            'method' => 'DELETE',
            'route' => ['departments.destroy', $dep->id]
        ]); !!}
                            {!! Form::submit( __('Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?")']); !!}

                            {!! Form::close(); !!}</td></td>
                    @endif
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>

@stop