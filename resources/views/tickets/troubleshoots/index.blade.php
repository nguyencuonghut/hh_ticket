<div class="row">
    <div class="col-md-12">
        <h5><b style="float: left">Tiến độ:</b></h5>
        <?php
        $total_actions = $troubleshoots->count();
        $completed_actions = $troubleshoots->where('status_id', '2')->count();
        $completed_percentage = (int)(100 * $completed_actions/$total_actions);
        ?>
        <span>
            <div class="progress">
                <div class="progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="$completed_percentage" aria-valuemin="0" aria-valuemax="100" style="width: {{$completed_percentage}}%;">
                    {{$completed_percentage}}%
                </div>
            </div>
        </span>
        <table class="table" style="font-size: 12px">
            <thead>
            <th><b>Biện pháp khắc phục</b></th>
            <th><b>Người thực hiện</b></th>
            <th><b>Thời hạn</b></th>
            <th><b>Trạng thái</b></th>
            <th><b>Sửa</b></th>
            <th><b>Đánh dấu hoàn thành</b></th>
            <th><b>Giao cho người khác</b></th>
            </thead>
            @foreach($troubleshoots as $action)
                <tr>
                    @if($action->is_on_time == true)
                        <td><i class="fa fa-check-circle" style="color:green"></i> {{ $action->name }}</td>
                    @else
                        <td><i class="fa fa-clock-o" style="color:red"></i> {{ $action->name }}</td>
                    @endif
                    <td>{{ $action->troubleshooter->name }}</td>
                    <td>{{date('d, F Y', strTotime($action->deadline))}}</td>
                    <td style="color: {{'Open' == $action->status->name ? "green": "black"}}">{{ $action->status->name}}</td>
                    <td style="text-align: center">
                        @if(\Auth::id() == $action->troubleshooter_id)
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#TroubleshootActionEditModal-{{$action->id}}"
                                    data-id="{{ $action->id }}"><i class="fa fa-edit"></i>
                            </button>
                        @else
                            <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-lock"></i></button>
                        @endif
                        <div class="modal fade" id="TroubleshootActionEditModal-{{$action->id}}" role="dialog" aria-labelledby="TroubleshootActionEditModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="TroubleshootActionEditModalLabel">Sửa biện pháp khắc phục</h4>
                                    </div>
                                    <div class="modal-body" style="text-align: left">
                                        {!! Form::model($action, [
                                            'method' => 'PATCH',
                                            'route' => ['troubleshoots.update', $action->id],
                                            'files'=>true,
                                            'enctype' => 'multipart/form-data'
                                            ]) !!}

                                        {!! Form::label('name', __('Biện pháp khắc phục'), ['class' => 'control-label']) !!}
                                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'action']) !!}

                                        <div class="form-inline">
                                            <div class="form-group col-sm-6 removeleft ">
                                                {!! Form::label('deadline', __('Thời hạn'), ['class' => 'control-label']) !!}
                                                {!! Form::date('deadline', \Carbon\Carbon::parse($action->deadline), ['class' => 'form-control']) !!}
                                            </div>
                                            <div class="form-group col-sm-6 removeleft removeright ">
                                                {!! Form::label('status_id', __('Trạng thái'), ['class' => 'control-label']) !!}
                                                {!! Form::select('status_id', $statuses, null, ['placeholder' => '', 'id'=>'status_id', 'name'=>'status_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                            </div>
                                        </div>
                                        {!! Form::submit('Cập nhật', ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}

                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: center">
                            <span>
                                @if(\Auth::id() == $action->troubleshooter_id)
                                    <form action="{{ route('troubleshootMarkComplete', $action->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i></button>
                                    </form>
                                @else
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-lock"></i></button>
                                @endif
                            </span>
                    </td>
                    <td style="text-align: center">
                        @if(\Auth::id() == $action->creator_id)
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#UpdateAssignModal-{{$action->id}}"
                                    data-id="{{ $action->id }}"><i class="fa fa-random"></i>
                            </button>
                        @else
                            <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-lock"></i></button>
                        @endif
                        <div class="modal fade" id="UpdateAssignModal-{{$action->id}}" role="dialog" aria-labelledby="UpdateAssignModalModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="UpdateAssignModalLabel">Giao cho người khác</h4>
                                    </div>
                                    <div class="modal-body" style="text-align: left">
                                        {!! Form::model($action, [
                                            'method' => 'PATCH',
                                            'route' => ['troubleshootUpdateAssign', $action->id],
                                            'files'=>true,
                                            'enctype' => 'multipart/form-data'
                                            ]) !!}
                                        <div class="form-group">
                                            {!! Form::label('troubleshooter_id', __('Người thực hiện'), ['class' => 'control-label']) !!}
                                            {!! Form::select('troubleshooter_id', $users, null, ['placeholder' => '', 'id'=>'troubleshooter_id', 'name'=>'troubleshooter_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                        </div>
                                        {!! Form::submit('Cập nhật', ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}

                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $("#status_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
<script type="text/javascript">
    $("#troubleshooter_id").select2({
        placeholder: "Chọn",
        allowClear: true
    });
</script>
@endpush