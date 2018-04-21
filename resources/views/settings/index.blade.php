@extends('layouts.master')
@section('heading')
    <h1>{{ __('Cấu hình') }}</h1>
@stop
@section('content')
    <div class="row">
    <div class="col-lg-12">
        
    </div>
    @foreach($roles as $role) 
    <div class="col-lg-12">
    {!! Form::model($permission, [
        'method' => 'PATCH',
        'url'    => 'settings/permissionsUpdate',
    ]) !!}

        <table class="table table-responsive table-hover table_wrapper" id="permissions-table">
            <thead>
            <tr>
            <th></th>
                @foreach($permission as $perm)
             <th>{{$perm->display_name}}</th>

                @endforeach
                <th></th>
            </tr>

            </thead>
            <tbody>
        <input type="hidden" name="role_id" value="{{ $role->id }}"/>
                <tr>
                        <th>{{$role->display_name}}</th>
                        @foreach($permission as $perm)
                            <?php $isEnabled = !current(
                                    array_filter(
                                            $role->permissions->toArray(),
                                            function ($element) use ($perm) {
                                                return $element['id'] === $perm->id;
                                            }
                                    )
                            );  ?>

                            <td><input type="checkbox"
                                       <?php if (!$isEnabled) echo 'checked' ?> name="permissions[ {{ $perm->id }} ]"
                                       value="1" data-role="{{ $role->id }}">
                                <span class="perm-name"></span><br/></td>

                
                    @endforeach        
    <td>{!! Form::submit( __('Lưu') , ['class' => 'btn btn-primary']) !!}</td>
   
            </tr>
      </tbody>
    </table>
     {!! Form::close() !!}
     </div>
     @endforeach
</div>

@stop

