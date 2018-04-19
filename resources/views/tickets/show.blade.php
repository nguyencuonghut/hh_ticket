@extends('layouts.master')
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 12px;
    }
    th, td {
        padding: 2px;
        padding-top: 2px;
        padding-bottom: 2px;
        text-align: left;
        font-weight: normal;
    }
</style>

@section('heading')

@stop

@section('content')
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-primary shadow">
                <div class="panel-heading"><h3><b><i class="glyphicon glyphicon-tags" aria-hidden="true"></i>  Ticket #{{$ticket->id}}: {{$ticket->title}}</b></h3></div>
                <div class="panel-body">

                    <!-- Tab for each ticket -->
                    <div class="col-md-12">
                        <el-tabs active-name=<?php
                                switch (Session::get('tab')) {
                                    case 'description':
                                        echo("description");
                                        break;
                                    case 'troubleshoot':
                                        echo("troubleshoot");
                                        break;
                                    case 'prevention':
                                        echo("prevention");
                                        break;
                                    default:
                                        echo("description");
                                        break;
                                }
                        ?> style="width:100%">
                            <el-tab-pane label="Mô tả vấn đề" name="description">
                                <div class="col-md-12 col-md-6"></div>
                                <div class="contactleft">
                                    <p><b>Ngày phát hành:</b> {{date('d F, Y', strtotime($ticket->created_at))}}</p>
                                    <p><b>Thời hạn trả lời:</b> {{date('d F, Y', strtotime($ticket->deadline))}}</p>
                                </div>
                                <div class="contactright col-md-6">
                                    <p><b>Nguồn gốc:</b> {{$ticket->source->name}}</p>
                                    <p><b>Người tạo phiếu:</b> {{$ticket->creator->name}}</p>
                                    <br>
                                    <br>
                                </div>
                                <h5><b style="color:blue;float: left;">1. Mô tả vấn đề:</b>
                                    @if(\Auth::id() == $ticket->creator_id)
                                        <span>
                                            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#description_edit"><i class="fa fa-edit"><b> Cập nhật</b></i></button>
                                        </span>
                                        <div class="modal fade" id="description_edit" role="dialog" aria-labelledby="DescriptionEditModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="DescriptionEditModalLabel">Cập nhật phiếu C.A.R</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! Form::model($ticket, [
                                                                'method' => 'PATCH',
                                                                'route' => ['tickets.update', $ticket->id],
                                                                'files'=>true,
                                                                'enctype' => 'multipart/form-data'
                                                                ]) !!}
                                                        @include('tickets.form', ['submitButtonText' => __('Cập nhật')])
                                                        {!! Form::close() !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </h5>
                                <table style="width:100%">
                                    <tr>
                                        <th class="col-md-3"><b>Có gì đã xảy ra?</b></th>
                                        <td class="col-md-4">{{$ticket->what}}</td>
                                        @if($ticket->image_path)
                                        <th rowspan="5"><img class="img-responsive" src={{url('/upload/' . $ticket->image_path)}}></th>
                                        @else
                                            <th rowspan="5"><img class="img-responsive" src={{url('/images/no-evidence.jpg')}}></th>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th class="col-md-3"><b>Tại sao đây là một vấn đề?</b></th>
                                        <td class="col-md-4">{{$ticket->why}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3"><b>Nó xảy ra khi nào?</b></th>
                                        <td class="col-md-4">{{date('d F, Y', strtotime($ticket->when))}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3"><b>Ai phát hiện ra?</b></th>
                                        <td class="col-md-4">{{$ticket->who}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3"><b>Phát hiện ra ở đâu?</b></th>
                                        <td class="col-md-4">{{$ticket->where}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3"><b>Bằng cách nào?</b></th>
                                        <td class="col-md-4">{{$ticket->how_1}}</td>
                                        <th rowspan="2">
                                            @if(\Auth::id() == $ticket->director_id)
                                                <span>
                                                    <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#director_confirmation" style="margin-top: 2px;margin-left: 2px"><i class="fa fa-check-circle"><b> Xác nhận</b></i></button>
                                                </span>
                                                <div class="modal fade" id="director_confirmation" style="overflow:hidden;" role="dialog" aria-labelledby="DirectorConfirmationModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="DirectorConfirmationModalLabel">Xác nhận phiếu C.A.R</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                {!! Form::model($ticket, [
                                                                        'method' => 'PATCH',
                                                                        'route' => ['directorConfirm', $ticket->id],
                                                                        'files'=>true,
                                                                        'enctype' => 'multipart/form-data'
                                                                        ]) !!}
                                                                <div class="form-group">
                                                                    {!! Form::label('director_confirmation_result_id', __('Kết quả') , ['class' => 'control-label']) !!}
                                                                    {!! Form::select('director_confirmation_result_id', $results, null, ['placeholder' => '', 'id'=>'director_confirmation_result_id', 'name'=>'director_confirmation_result_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                                                </div>
                                                                <div class="form-group">
                                                                    {!! Form::label('director_confirmation_comment', __('Ý kiến'), ['class' => 'control-label']) !!}
                                                                    {!! Form::textarea('director_confirmation_comment', null, ['class' => 'form-control']) !!}                                                       </div>
                                                                {!! Form::submit(__('Cập nhật'), ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                            <div class="modal-footer">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($ticket->director_confirmation_result_id)
                                                <p><b>Xác nhận: </b><b style="color:{{$ticket->director_confirmation_result->color}}">{!! $ticket->director_confirmation_result->name !!}</b> <i>(bởi {{$ticket->director->name}})</i></p>
                                            @else
                                                <p style="color:red"> Chưa xác nhận!</p>
                                            @endif
                                            @if($ticket->director_confirmation_comment)
                                                <p><b>Ý kiến:</b><i>{!! $ticket->director_confirmation_comment !!}</i></p>
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3"><b>Có bao nhiêu sự không phù hợp?</b></th>
                                        <td class="col-md-4">{{$ticket->how_2}}</td>
                                    </tr>
                                </table>
                            </el-tab-pane>
                            <el-tab-pane label="Khắc phục" name="troubleshoot">
                                <h5><b style="color:blue;float: {{(\Auth::id() == $ticket->assigned_troubleshooter_id) ? 'left' : ''}}">2. Xác định trách nhiệm:</b></h5>
                                @if(\Auth::id() == $ticket->assigned_troubleshooter_id)
                                    <span>
                                        <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#set_responsibility"><i class="fa fa-edit"><b> Cập nhật</b></i></button>
                                    </span>
                                    <div class="modal fade" id="set_responsibility" role="dialog" aria-labelledby="SetResponsibilityModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="SetResponsibilityModalLabel">Xác định trách nhiệm</h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::model($ticket, [
                                                            'method' => 'PATCH',
                                                            'route' => ['setResponsibility', $ticket->id],
                                                            'files'=>true,
                                                            'enctype' => 'multipart/form-data'
                                                            ]) !!}

                                                    {!! Form::label('responsibility_id', __('Trách nhiệm'), ['class' => 'control-label']) !!}
                                                    {!! Form::select('responsibility_id', $responsibilities, null, ['placeholder' => '', 'id'=>'responsibility_id', 'name'=>'responsibility_id','class'=>'form-control', 'style' => 'width: 100%']) !!}
                                                    <br>
                                                    <br>
                                                    {!! Form::submit(__('Cập nhật'), ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($ticket->responsibility_id)
                                    <h5><b>Trách nhiệm:</b> {{$ticket->responsibility->name}}</h5>
                                @endif

                                <h5><b style="color:blue;float: {{(\Auth::id() == $ticket->assigned_troubleshooter_id) || (\Auth::id() == $ticket->director_id) ? 'left' : ''}};">3. Thực hiện biện pháp khắc phục:</b></h5>
                                @if(\Auth::id() == $ticket->assigned_troubleshooter_id)
                                    <span style="float: left">
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#troubleshootaction"><i class="fa fa-plus-circle"><b> Tạo thêm</b></i></button>
                                    </span>
                                    <div class="modal fade" id="troubleshootaction" role="dialog" aria-labelledby="TroubleshootModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="TroubleshootModalLabel"><b>Thêm biện pháp khắc phục</b></h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open([
                                                            'route' => ['troubleshoots.store', $ticket->id],
                                                            ]) !!}

                                                    {!! Form::label('name', __('Biện pháp khắc phục'), ['class' => 'control-label']) !!}
                                                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'action']) !!}
                                                    <div class="form-inline">
                                                        <div class="form-group col-sm-6 removeleft ">
                                                            {!! Form::label('troubleshooter_id', __('Người thực hiện'), ['class' => 'control-label']) !!}
                                                            {!! Form::select('troubleshooter_id', $users, null, ['placeholder' => '', 'id'=>'troubleshooter_id', 'name'=>'troubleshooter_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                                        </div>
                                                        <div class="form-group col-sm-6 removeright ">
                                                            {!! Form::label('deadline', __('Thời hạn'), ['class' => 'control-label']) !!}
                                                            {!! Form::date('deadline', \Carbon\Carbon::now()->addDays(3), ['class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    {!! Form::submit( __('Thêm') , ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span style="float: left">
                                        &nbsp;
                                    </span>

                                    <span>
                                        <form style="float: left;" action="{{ route('requestToApproveTroubleshoot', $ticket->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-paper-plane"> Yêu cầu duyệt</i></button>
                                        </form>
                                    </span>
                                @endif

                                @if(\Auth::id() == $ticket->director_id)
                                    <span style="float: left">
                                        &nbsp;
                                    </span>
                                    <span style="float: left">
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#approve_troubleshoot"><i class="fa fa-check-circle"><b> Duyệt</b></i></button>
                                    </span>
                                    <div class="modal fade" id="approve_troubleshoot" role="dialog" aria-labelledby="ApproveTroubleshootModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="ApproveTroubleshootModalLabel"><b>Duyệt biện pháp khắc phục</b></h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::model($ticket, [
                                                            'method' => 'PATCH',
                                                            'route' => ['approveTroubleshoot', $ticket->id],
                                                            'files'=>true,
                                                            'enctype' => 'multipart/form-data'
                                                            ]) !!}

                                                    {!! Form::label('approve_troubleshoot_result_id', __('Kết quả duyệt'), ['class' => 'control-label']) !!}
                                                    {!! Form::select('approve_troubleshoot_result_id', $results, null, ['placeholder' => '', 'id'=>'approve_troubleshoot_result_id', 'name'=>'approve_troubleshoot_result_id','class'=>'form-control', 'style' => 'width:100%']) !!}

                                                    {!! Form::label('approve_troubleshoot_comment', __('Ý kiến'), ['class' => 'control-label']) !!}
                                                    {!! Form::textarea('approve_troubleshoot_comment', null, ['class' => 'form-control']) !!}

                                                    {!! Form::submit( __('Duyệt') , ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($ticket->assigned_troubleshooter_id)
                                    <div class="contactleft">
                                        <p><b>Người đề xuất:</b> {{$ticket->assigned_troubleshooter->name}}</p>
                                    </div>
                                @endif
                                <div class="contactright">
                                    @if($ticket->approve_troubleshoot_result_id)
                                    <p><b>Kết quả duyệt:</b> <b style="color: {{$ticket->approve_troubleshoot_result->color}}">{{$ticket->approve_troubleshoot_result->name}}</b> (bởi {{$ticket->director->name}})</p>
                                    @endif
                                    @if($ticket->approve_troubleshoot_comment)
                                        <p><b>Ý kiến người duyệt:</b> <i>{!! $ticket->approve_troubleshoot_comment !!}</i></p>
                                    @endif
                                </div>
                                @if($troubleshoots->count())
                                    @include('tickets.troubleshoots.index', ['subject' => $ticket])
                                @endif

                            </el-tab-pane>
                            <el-tab-pane label="Phòng ngừa" name="prevention">
                                <h5><b style="color:blue; float: {{(\Auth::id() == $ticket->assigned_preventer_id) || ((\Auth::id() == $ticket->director_id)) ? 'left' : ''}};">4. Đánh giá sự không phù hợp:</b></h5>
                                @if(\Auth::id() == $ticket->assigned_preventer_id)
                                    <span style="float: left">
                                        <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#evaluation"><i class="fa fa-edit"><b> Cập nhật</b></i></button>
                                    </span>
                                    <div class="modal fade" id="evaluation" role="dialog" aria-labelledby="EvaluationModalLabel">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="EvaluationModalLabel"><b>Xem xét mức độ SKPH</b></h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::model($ticket, [
                                                            'method' => 'PATCH',
                                                            'route' => ['evaluateTicket', $ticket->id],
                                                            'files'=>true,
                                                            'enctype' => 'multipart/form-data'
                                                            ]) !!}

                                                    <div class="form-group">
                                                        {!! Form::label('evaluation_id', __('Mức độ'), ['class' => 'control-label']) !!}
                                                        {!! Form::select('evaluation_id', $evaluations, null, ['placeholder' => '', 'id'=>'evaluation_id', 'name'=>'evaluation_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                                    </div>

                                                    {!! Form::submit( __('Cập nhật') , ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <br>
                                @if($ticket->evaluation_id)
                                    <p><b>Mức độ:</b> <b style="color:{{$ticket->evaluation->color}}">{{$ticket->evaluation->name}}</b> (đánh giá bởi <b>{{$ticket->assigned_preventer->name}}</b>)</p>
                                @endif

                                <h5><b style="color:blue;float: {{(\Auth::id() == $ticket->assigned_preventer_id) || (\Auth::id() == $ticket->director_id)? 'left' : ''}};">5. Hoạt động phòng ngừa:</b></h5>
                                @if(\Auth::id() == $ticket->assigned_preventer_id)
                                    <span style="float: left">
                                        <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#update_root_cause"><i class="fa fa-edit"><b> Cập nhật nguyên nhân gốc</b></i></button>
                                    </span>
                                    <div class="modal fade" id="update_root_cause" role="dialog" aria-labelledby="UpdateRootCauseModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="UpdateRootCauseModalLabel"><b>Cập nhật nguyên nhân gốc rễ</b></h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::model($ticket, [
                                                            'method' => 'PATCH',
                                                            'route' => ['updateRootCause', $ticket->id],
                                                            'files'=>true,
                                                            'enctype' => 'multipart/form-data'
                                                            ]) !!}

                                                    <div class="form-group">
                                                        {!! Form::label('root_cause_type_id', __('Phân loại'), ['class' => 'control-label']) !!}
                                                        {!! Form::select('root_cause_type_id', $root_cause_types, null, ['placeholder' => '', 'id'=>'root_cause_type_id', 'name'=>'root_cause_type_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('root_cause', __('Nguyên nhân gốc'), ['class' => 'control-label']) !!}
                                                        {!! Form::textarea('root_cause', null, ['class' => 'form-control']) !!}
                                                    </div>

                                                    {!! Form::submit( __('Cập nhật') , ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <span style="float: left">
                                        &nbsp;
                                </span>
                                @if(\Auth::id() == $ticket->assigned_preventer_id)
                                    <span style="float: left">
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#preventionaction"><i class="fa fa-plus-circle"><b> Thêm HĐ phòng ngừa</b></i></button>
                                    </span>
                                    <div class="modal fade" id="preventionaction" role="dialog" aria-labelledby="PreventionModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="PreventionModalLabel"><b>Thêm biện pháp phòng ngừa</b></h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open([
                                                            'route' => ['preventions.store', $ticket->id],
                                                            ]) !!}

                                                    {!! Form::label('name', __('Biện pháp phòng ngừa'), ['class' => 'control-label']) !!}
                                                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'action']) !!}
                                                    <div class="form-inline">
                                                        <div class="form-group col-sm-6 removeleft ">
                                                            {!! Form::label('budget', __('Ngân sách'), ['class' => 'control-label']) !!}
                                                            {!! Form::number('budget', null, ['class' => 'form-control', 'id' => 'action']) !!}
                                                        </div>
                                                        <div class="form-group col-sm-6 removeright ">
                                                            {!! Form::label('where', __('Làm ở đâu?'), ['class' => 'control-label']) !!}
                                                            {!! Form::text('where', null, ['class' => 'form-control', 'id' => 'action']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-inline">
                                                        <div class="form-group col-sm-6 removeleft ">
                                                            {!! Form::label('when', __('Làm khi nào?'), ['class' => 'control-label']) !!}
                                                            {!! Form::date('when', \Carbon\Carbon::now()->addDays(3), ['class' => 'form-control', 'style' => 'width:100%']) !!}
                                                        </div>
                                                        <div class="form-group col-sm-6 removeright ">
                                                            {!! Form::label('how', __('Làm như thế nào?'), ['class' => 'control-label']) !!}
                                                            {!! Form::text('how', null, ['class' => 'form-control', 'id' => 'action', 'style' => 'width:100%']) !!}
                                                        </div>
                                                    </div>

                                                        <div class="form-group">
                                                            {!! Form::label('preventor_id', __('Ai làm?'), ['class' => 'control-label']) !!}
                                                            {!! Form::select('preventor_id', $users, null, ['placeholder' => '', 'id'=>'preventor_id', 'name'=>'preventor_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                                        </div>
                                                    {!! Form::submit( __('Thêm') , ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span style="float: left">
                                        &nbsp;
                                    </span>
                                    <span style="float: left">
                                        <form style="float: left;" action="{{ route('requestToApprovePrevention', $ticket->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-paper-plane"> Yêu cầu duyệt</i></button>
                                        </form>
                                    </span>

                                    <span style="float: left">
                                        &nbsp;
                                    </span>
                                @endif

                                @if(\Auth::id() == $ticket->director_id)
                                    <span style="float: left">
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#approve_prevention"><i class="fa fa-check-circle"><b> Duyệt</b></i></button>
                                    </span>
                                    <div class="modal fade" id="approve_prevention" role="dialog" aria-labelledby="ApprovePreventionModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="ApprovePreventionModalLabel"><b>Duyệt biện pháp phòng ngừa</b></h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::model($ticket, [
                                                            'method' => 'PATCH',
                                                            'route' => ['approvePrevention', $ticket->id],
                                                            'files'=>true,
                                                            'enctype' => 'multipart/form-data'
                                                            ]) !!}

                                                    {!! Form::label('approve_prevention_result_id', __('Kết quả duyệt'), ['class' => 'control-label']) !!}
                                                    {!! Form::select('approve_prevention_result_id', $results, null, ['placeholder' => '', 'id'=>'approve_prevention_result_id', 'name'=>'approve_prevention_result_id','class'=>'form-control', 'style' => 'width:100%']) !!}

                                                    {!! Form::label('approve_prevention_comment', __('Ý kiến'), ['class' => 'control-label']) !!}
                                                    {!! Form::textarea('approve_prevention_comment', null, ['class' => 'form-control']) !!}

                                                    {!! Form::submit( __('Duyệt') , ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                @endif
                                <div class="contactleft">
                                    @if($ticket->assigned_preventer_id)
                                        <p><b>Người đề xuất:</b> {{$ticket->assigned_preventer->name}}</p>
                                    @endif
                                </div>
                                <div class="contactright">
                                    @if($ticket->root_cause_type_id)
                                        <p><b>Phân loại nguyên nhân:</b> {{$ticket->root_cause_type->name}}</p>
                                    @endif
                                </div>
                                <br>
                                @if($ticket->root_cause)
                                    <p><b>Nguyên nhân gốc rễ:</b>
                                        @if($ticket->approve_prevention_result_id)
                                            (<b style="color: {{$ticket->approve_prevention_result->color}};">{{$ticket->approve_prevention_result->name}}</b> bởi <b>{{$ticket->director->name}}</b>)
                                        @else
                                            (<b style="color:red">Chưa được duyệt</b>)
                                        @endif
                                        <div class="col-md-12">
                                            <i>{!! $ticket->root_cause !!}</i>
                                        </div>
                                    </p>
                                @endif
                                @if($ticket->approve_prevention_comment)
                                    <p><b>Ý kiến:</b>
                                        <div class="col-md-12">
                                            <i>{!! $ticket->approve_prevention_comment !!}</i>
                                        </div>
                                    </p>
                                @endif

                                <br>
                                @if($preventions->count())
                                    @include('tickets.preventions.index', ['subject' => $ticket])
                                @endif
                                <br>

                                <h5><b style="color:blue;float: left;">6. Đánh giá hiệu quả: &nbsp;</b></h5>
                                <span>
                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#effectiveness"><i class="fa fa-edit"><b> Cập nhật</b></i></button>
                                </span>
                                <div class="modal fade" id="effectiveness" role="dialog" aria-labelledby="EffectivenessModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="EffectivenessModalLabel">Đánh giá hiệu quả</h4>
                                            </div>
                                            <div class="modal-body">
                                                {!! Form::model($ticket, [
                                                        'method' => 'PATCH',
                                                        'route' => ['assetEffectiveness', $ticket->id],
                                                        'files'=>true,
                                                        'enctype' => 'multipart/form-data'
                                                        ]) !!}

                                                {!! Form::label('effectiveness_id', __('Hiệu quả'), ['class' => 'control-label']) !!}
                                                {!! Form::select('effectiveness_id', $effectivenesses, null, ['placeholder' => '', 'id'=>'effectiveness_id', 'name'=>'effectiveness_id','class'=>'form-control', 'style' => 'width: 100%']) !!}

                                                {!! Form::label('effectiveness_comment', __('Ý kiến'), ['class' => 'control-label']) !!}
                                                {!! Form::textarea('effectiveness_comment', null, ['class' => 'form-control']) !!}

                                                {!! Form::submit(__('Cập nhật'), ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
                                                {!! Form::close() !!}
                                            </div>
                                            <div class="modal-footer">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    @if($ticket->effectiveness_id)
                                        <p>Ticket được đánh giá hiệu quả <b style="color: {{$ticket->effectiveness->color}}"> {{$ticket->effectiveness->name}}</b> (bởi {{$ticket->director->name}}).
                                        @if($ticket->effectiveness_comment)
                                            <br>
                                            <b>Với ý kiến:</b> <i>{!! $ticket->effectiveness_comment !!}</i>
                                        @endif
                                        </p>
                                    @endif
                                </div>

                            </el-tab-pane>
                        </el-tabs>
                    </div>
                    <!-- ~ Tab for each ticket-->

                </div>
            </div>
            @include('partials.comments', ['subject' => $ticket])

        </div>
        <div class="col-md-3">
            <div class="sidebarheader" style="margin-top: 0px; background-color:#337ab7;">
                <p style="text-align: center">{{ __('Phân công người xử lý') }}</p>
            </div>
            @if(\Auth::id() == $ticket->director_id)
                <button type="button" class="btn btn-success form-control closebtn" data-toggle="modal" data-target="#AssignTroubleshooterModal">Giao cho người khắc phục</button>
                <div class="modal fade" id="AssignTroubleshooterModal" role="dialog" aria-labelledby="AssignTroubleshooterModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="AssignTroubleshooterModalLabel">Chọn người khắc phục</h4>
                            </div>
                            <div class="modal-body" style="text-align: left">
                                {!! Form::model($ticket, [
                                        'method' => 'PATCH',
                                        'route' => ['assignTroubleshooter', $ticket->id],
                                    ]) !!}
                                {!! Form::select('assigned_troubleshooter_id', $users, null, ['placeholder' => '', 'id'=>'assigned_troubleshooter_id', 'name'=>'assigned_troubleshooter_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                <br>
                                <br>
                                {!! Form::submit(__('Cập nhật'), ['class' => 'btn btn-primary closebtn','style' => 'width:100%']) !!}
                                {!! Form::close() !!}
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-warning form-control closebtn" data-toggle="modal" data-target="#AssignPreventerModal">Giao cho người phòng ngừa</button>
                <div class="modal fade" id="AssignPreventerModal" role="dialog" aria-labelledby="AssignPreventerModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="AssignPreventerModalLabel">Chọn người phòng ngừa</h4>
                            </div>
                            <div class="modal-body" style="text-align: left">
                                {!! Form::model($ticket, [
                                        'method' => 'PATCH',
                                        'route' => ['assignPreventer', $ticket->id],
                                    ]) !!}
                                {!! Form::select('assigned_preventer_id', $users, null, ['placeholder' => '', 'id'=>'assigned_preventer_id', 'name'=>'assigned_preventer_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                <br>
                                <br>
                                {!! Form::submit(__('Cập nhật'), ['class' => 'btn btn-primary closebtn','style' => 'width:100%']) !!}
                                {!! Form::close() !!}
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <div class="activity-feed movedown">
                @foreach($activities as $activity)
                    <div class="feed-item">
                        <div class="activity-date">{{date('d, F Y H:i', strTotime($activity->created_at))}}</div>
                        <div class="activity-text">{!! $activity->text !!}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $("#director_confirmation_result_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#responsibility_id").select2({
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
    <script type="text/javascript">
        $("#root_cause_type_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#evaluation_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#evaluation_result_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#preventor_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#effectiveness_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#assigned_troubleshooter_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#troubleshoot_approve_result_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#assigned_preventer_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
@endpush