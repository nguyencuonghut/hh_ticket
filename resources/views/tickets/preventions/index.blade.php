<div class="row">
    <div class="col-md-12">
        <h5><b style="float: left">Tiến độ:</b></h5>
        <?php
        $total_actions = $preventions->count();
        $completed_actions = $preventions->where('status_id', '2')->count();
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
            <thead style="background-color: purple; color: white">
            <th><b>Biện pháp phòng ngừa</b></th>
            <th><b>Ngân sách dự kiến</b></th>
            <th><b>Ai làm?</b></th>
            <th><b>Làm ở đâu?</b></th>
            <th><b>Làm khi nào?</b></th>
            <th><b>Làm như thế nào?</b></th>
            <th><b>Trạng thái</b></th>
            <th><b>Sửa</b></th>
            <th><b>Đánh dấu hoàn thành</b></th>
            <th><b>Giao cho người khác</b></th>
            </thead>
            @foreach($preventions as $action)
                <tr style="background-color: {{('Closed' == $action->status->name) ? '#C6CBCB' : '#adebad'}}">
                    @if('Closed' == $action->status->name)
                        @if($action->is_on_time == true)
                            <td><i class="fa fa-check-circle" style="color:green"></i> {{ $action->name }}</td>
                        @else
                            <td><i class="fa fa-clock-o" style="color:red"></i> {{ $action->name }}</td>
                        @endif
                    @else
                        <td><i></i> {{ $action->name }}</td>
                    @endif
                    <td>{{ number_format($action->budget,  0)}} VNĐ</td>
                    <td>{{ $action->preventor->name }}</td>
                    <td>{{ $action->where }}</td>
                    @if('Open' == $action->status->name)
                        <td>{{date('d, F Y', strTotime($action->when))}} <i style="color: {{(0 < $action->DaysUntilDeadline) ? 'blue' : 'red'}}">({{$action->DaysUntilDeadline}} ngày)</i></td>
                    @else
                        <td>{{date('d, F Y', strTotime($action->when))}}</td>
                    @endif
                    <td>{{ $action->how }}</td>
                    <td style="color: {{'Open' == $action->status->name ? "green": "black"}}">{{ $action->status->name}}</td>
                    <td style="text-align: center">
                        @if(\Auth::id() == $action->preventor_id)
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#PreventionActionEditModal-{{$action->id}}"
                                    data-id="{{ $action->id }}"><i class="fa fa-edit"></i>
                            </button>
                        @else
                            <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-lock"></i></button>
                        @endif
                        <div class="modal fade" id="PreventionActionEditModal-{{$action->id}}" role="dialog" aria-labelledby="PreventionActionEditModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="PreventionActionEditModalLabel">Sửa biện pháp phòng ngừa</h4>
                                    </div>
                                    <div class="modal-body" style="text-align: left">
                                        {!! Form::model($action, [
                                            'method' => 'PATCH',
                                            'route' => ['preventions.update', $action->id],
                                            'files'=>true,
                                            'enctype' => 'multipart/form-data'
                                            ]) !!}

                                        {!! Form::label('name', __('Biện pháp phòng ngừa'), ['class' => 'control-label']) !!}
                                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'action']) !!}

                                        <div class="form-inline">
                                            <div class="form-group col-sm-4 removeleft ">
                                                {!! Form::label('budget', __('Ngân sách'), ['class' => 'control-label']) !!}
                                                {!! Form::number('budget', null, ['class' => 'form-control', 'id' => 'action']) !!}
                                            </div>
                                            <div class="form-group col-sm-4 removeleft">
                                                {!! Form::label('preventor_id', __('Ai làm?'), ['class' => 'control-label']) !!}
                                                {!! Form::select('preventor_id', $users, null, ['placeholder' => '', 'id'=>'preventor_id', 'name'=>'preventor_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                            </div>
                                            <div class="form-group col-sm-4 removeleft removeright">
                                                {!! Form::label('where', __('Làm ở đâu?'), ['class' => 'control-label']) !!}
                                                {!! Form::text('where', null, ['class' => 'form-control', 'id' => 'action', 'style' => 'width:100%']) !!}
                                            </div>
                                        </div>

                                        <div class="form-inline">
                                            <div class="form-group col-sm-4 removeleft ">
                                                {!! Form::label('where', __('Làm ở đâu?'), ['class' => 'control-label']) !!}
                                                {!! Form::text('where', null, ['class' => 'form-control', 'id' => 'action', 'style' => 'width:100%']) !!}
                                            </div>
                                            <div class="form-group col-sm-4 removeleft">
                                                {!! Form::label('when', __('Làm khi nào?'), ['class' => 'control-label']) !!}
                                                {!! Form::date('when', \Carbon\Carbon::parse($action->when), ['class' => 'form-control', 'style' => 'width:100%']) !!}
                                            </div>
                                            <div class="form-group col-sm-4 removeleft removeright">
                                                {!! Form::label('how', __('Làm như thế nào?'), ['class' => 'control-label']) !!}
                                                {!! Form::text('how', null, ['class' => 'form-control', 'id' => 'action', 'style' => 'width:100%']) !!}
                                            </div>
                                        </div>

                                        <div class="form-inline">
                                            <div class="form-group col-sm-4 removeleft removeright ">
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
                                @if(\Auth::id() == $action->preventor_id)
                                    <form action="{{ route('preventionMarkComplete', $action->id) }}" method="POST">
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
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#UpdatePreventionAssignModal-{{$action->id}}"
                                    data-id="{{ $action->id }}"><i class="fa fa-random"></i>
                            </button>
                        @else
                            <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-lock"></i></button>
                        @endif
                        <div class="modal fade" id="UpdatePreventionAssignModal-{{$action->id}}" role="dialog" aria-labelledby="UpdatePreventionAssignModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="UpdatePreventionAssignModalLabel">Sửa biện pháp phòng ngừa</h4>
                                    </div>
                                    <div class="modal-body" style="text-align: left">
                                        {!! Form::model($action, [
                                            'method' => 'PATCH',
                                            'route' => ['preventionUpdateAssign', $action->id],
                                            'files'=>true,
                                            'enctype' => 'multipart/form-data'
                                            ]) !!}
                                        <div class="form-group">
                                            {!! Form::label('preventor_id', __('Người thực hiện'), ['class' => 'control-label']) !!}
                                            {!! Form::select('preventor_id', $users, null, ['placeholder' => '', 'id'=>'preventor_id', 'name'=>'preventor_id','class'=>'form-control', 'style' => 'width:100%']) !!}
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
        $("#preventor_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#status_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
@endpush