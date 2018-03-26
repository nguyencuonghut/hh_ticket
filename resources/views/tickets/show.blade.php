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
                                    case 'prevents':
                                        echo("prevents");
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
                                    <span>
                                        <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#description_edit"><i class="fa fa-edit"><b> Cập nhật</b></i></button>
                                    </span>
                                    <div class="modal fade" id="description_edit" tabindex="-1" role="dialog" aria-labelledby="DescriptionEditModalLabel">
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
                                            <span>
                                                <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#manager_confirmation" style="margin-top: 2px;margin-left: 2px"><i class="fa fa-check-circle"><b> Xác nhận</b></i></button>
                                            </span>
                                            <div class="modal fade" id="manager_confirmation" tabindex="-1" role="dialog" aria-labelledby="ManagerConfirmationModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="ManagerConfirmationModalLabel">Xác nhận phiếu C.A.R</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            {!! Form::model($ticket, [
                                                                    'method' => 'PATCH',
                                                                    'route' => ['managerConfirm', $ticket->id],
                                                                    'files'=>true,
                                                                    'enctype' => 'multipart/form-data'
                                                                    ]) !!}

                                                            <div class="form-group">
                                                                <select name="manager_confirmation_result" id="manager_confirmation_result" class="form-control" style="width:100%">
                                                                    <option disabled selected value> {{ __('Chọn') }} </option>
                                                                    <option value="Đồng ý">Đồng ý</option>
                                                                    <option value="Từ chối">Từ chối</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                {!! Form::label('manager_confirmation_comment', __('Ý kiến'), ['class' => 'control-label']) !!}
                                                                {!! Form::textarea('manager_confirmation_comment', null, ['class' => 'form-control']) !!}
                                                            </div>
                                                            {!! Form::submit(__('Cập nhật'), ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($ticket->manager_confirmation_result)
                                                <p><b>Xác nhận: </b><b style="color:{{'Đồng ý' === $ticket->manager_confirmation_result ? 'blue':'red'}}">{!! $ticket->manager_confirmation_result !!}</b> <i>(bởi {{$ticket->manager->name}})</i></p>
                                            @else
                                                <p style="color:red"> Chưa xác nhận!</p>
                                            @endif
                                            @if($ticket->manager_confirmation_comment)
                                                <p><b>Góp ý:</b><i>{!! $ticket->manager_confirmation_comment !!}</i></p>
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
                                <h5><b style="color:blue; float: left;">2. Xác định trách nhiệm:</b></h5>
                                <span>
                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#set_responsibility"><i class="fa fa-edit"><b> Cập nhật</b></i></button>
                                </span>
                                <div class="modal fade" id="set_responsibility" tabindex="-1" role="dialog" aria-labelledby="SetResponsibilityModalLabel">
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

                                <div class="col-md-12">
                                    @if($ticket->responsibility_id)
                                        <h5><b>Trách nhiệm:</b> {{$ticket->responsibility->name}}</h5>
                                    @endif
                                </div>

                                <h5><b style="color:blue;float: left;">3. Thực hiện biện pháp khắc phục:</b></h5>
                                <span>
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#troubleshootaction"><i class="fa fa-plus-circle"><b> Tạo thêm</b></i></button>
                                </span>
                                <div class="modal fade" id="troubleshootaction" tabindex="-1" role="dialog" aria-labelledby="TroubleshootModalLabel">
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
                                                    <!-- TODO: fix the bug of searching the user -->
                                                    <div class="form-group col-sm-6 removeleft ">
                                                        {!! Form::label('troubleshooter_id', __('Người thực hiện'), ['class' => 'control-label']) !!}
                                                        {!! Form::select('troubleshooter_id', $users, null, ['placeholder' => '', 'id'=>'troubleshooter_id', 'name'=>'troubleshooter_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                                    </div>
                                                    <div class="form-group col-sm-6 removeright ">
                                                        {!! Form::label('deadline', __('Thời hạn'), ['class' => 'control-label']) !!}
                                                        {!! Form::date('deadline', \Carbon\Carbon::now()->addDays(3), ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                {!! Form::submit( __('Thêm') , ['class' => 'btn btn-primary']) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($troubleshoots->count())
                                    @include('tickets.troubleshoots.index', ['subject' => $ticket])
                                @endif

                            </el-tab-pane>
                            <el-tab-pane label="Phòng ngừa" name="prevents">
                                <h5><b style="color:blue; float: left;">4. Xem xét mức độ sự không phù hợp:</b></h5>
                                <span>
                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#evaluation"><i class="fa fa-plus-circle"><b> Cập nhật</b></i></button>
                                </span>
                                <div class="modal fade" id="evaluation" tabindex="-1" role="dialog" aria-labelledby="EvaluationModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
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
                                                    {!! Form::label('root_cause_type_id', __('Phân loại'), ['class' => 'control-label']) !!}
                                                    {!! Form::select('root_cause_type_id', $root_cause_types, null, ['placeholder' => '', 'id'=>'root_cause_type_id', 'name'=>'root_cause_type_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                                </div>
                                                <div class="form-inline">
                                                    <div class="form-group col-sm-6 removeleft">
                                                        {!! Form::label('evaluation_id', __('Mức độ'), ['class' => 'control-label']) !!}
                                                        {!! Form::select('evaluation_id', $evaluations, null, ['placeholder' => '', 'id'=>'evaluation_id', 'name'=>'evaluation_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                                    </div>
                                                    <div class="form-group col-sm-6 removeleft removeright">
                                                        {!! Form::label('root_cause_approver_id', __('Người duyệt'), ['class' => 'control-label']) !!}
                                                        {!! Form::select('root_cause_approver_id', $users, null, ['placeholder' => '', 'id'=>'root_cause_approver_id', 'name'=>'root_cause_approver_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                                    </div>
                                                </div>
                                                {!! Form::label('root_cause', __('Nguyên nhân gốc'), ['class' => 'control-label']) !!}
                                                {!! Form::textarea('root_cause', null, ['class' => 'form-control']) !!}


                                                {!! Form::submit( __('Thêm') , ['class' => 'btn btn-primary']) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span> </span>
                                <span>
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#root_cause_approve" style="margin-top: 2px;margin-left: 2px"><i class="fa fa-check-circle"><b> Phê duyệt</b></i></button>
                                </span>
                                <div class="modal fade" id="root_cause_approve" tabindex="-1" role="dialog" aria-labelledby="RootCauseApproveModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="RootCauseApproveModalLabel">Duyệt nguyên nhân gốc rễ</h4>
                                            </div>
                                            <div class="modal-body">
                                                {!! Form::model($ticket, [
                                                        'method' => 'PATCH',
                                                        'route' => ['rootCauseApprove', $ticket->id],
                                                        'files'=>true,
                                                        'enctype' => 'multipart/form-data'
                                                        ]) !!}

                                                <div class="form-group">
                                                    <select name="evaluation_result" id="evaluation_result" class="form-control" style="width:100%">
                                                        <option disabled selected value> {{ __('Chọn') }} </option>
                                                        <option value="Đồng ý">Đồng ý</option>
                                                        <option value="Từ chối">Từ chối</option>
                                                    </select>
                                                </div>
                                                {!! Form::submit(__('Duyệt'), ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
                                                {!! Form::close() !!}
                                            </div>
                                            <div class="modal-footer">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="contactleft col-md-6">
                                    @if($ticket->evaluation_id)
                                        <p><b>Mức độ:</b> {{$ticket->evaluation->name}}</p>
                                    @endif
                                    @if($ticket->root_cause_type_id)
                                        <p><b>Phân loại nguyên nhân:</b> {{$ticket->root_cause_type->name}}</p>
                                    @endif
                                </div>
                                <div class="contactright col-md-6">
                                    @if($ticket->root_cause_approver_id)
                                            <p><b>Người phê duyệt:</b> {{$ticket->root_cause_approver->name}}</p>
                                    @endif
                                    @if($ticket->root_cause_approver_id)
                                        <p><b>Kết quả duyệt:</b> {{$ticket->evaluation_result}}</p>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    @if($ticket->root_cause)
                                        <p><b>Nguyên nhân gốc rễ:</b>
                                            <i>{!! $ticket->root_cause !!}</i>
                                        </p>
                                    @endif
                                </div>
                                <h5><b style="color:blue;float: left;">5. Hoạt động phòng ngừa</b></h5>
                                <span>
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#preventionaction"><i class="fa fa-plus-circle"><b> Tạo thêm</b></i></button>
                                </span>
                                <div class="modal fade" id="preventionaction" tabindex="-1" role="dialog" aria-labelledby="PreventionModalLabel">
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
                                                    <div class="form-group col-sm-6 removeleft removeright ">
                                                        {!! Form::label('preventor_id', __('Ai làm?'), ['class' => 'control-label']) !!}
                                                        {!! Form::select('preventor_id', $users, null, ['placeholder' => '', 'id'=>'preventor_id', 'name'=>'preventor_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                                    </div>
                                                </div>

                                                <div class="form-inline">
                                                    <div class="form-group col-sm-6 removeleft ">
                                                        {!! Form::label('where', __('Làm ở đâu?'), ['class' => 'control-label']) !!}
                                                        {!! Form::text('where', null, ['class' => 'form-control', 'id' => 'action']) !!}
                                                    </div>
                                                    <div class="form-group col-sm-6 removeleft removeright ">
                                                        {!! Form::label('when', __('Làm khi nào?'), ['class' => 'control-label']) !!}
                                                        {!! Form::date('when', \Carbon\Carbon::now()->addDays(3), ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="form-inline">
                                                    <div class="form-group col-sm-6 removeleft ">
                                                        {!! Form::label('how', __('Làm như thế nào?'), ['class' => 'control-label']) !!}
                                                        {!! Form::text('how', null, ['class' => 'form-control', 'id' => 'action']) !!}
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
                                @if($preventions->count())
                                    @include('tickets.preventions.index', ['subject' => $ticket])
                                @endif

                                <h5><b style="color:blue;float: left;">6. Đánh giá hiệu quả: &nbsp;</b></h5>
                                <span>
                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#effectiveness"><i class="fa fa-edit"><b> Cập nhật</b></i></button>
                                </span>
                                <div class="modal fade" id="effectiveness" tabindex="-1" role="dialog" aria-labelledby="EffectivenessModalLabel">
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

                                <div class="col-md-12">
                                    @if($ticket->effectiveness_id)
                                        <p><b>Ticket được đánh giá hiệu quả <b style="color: {{$ticket->effectiveness->color}}"> {{$ticket->effectiveness->name}}</b></b> (bởi {{$ticket->effectiveness_assessor->name}})</p>
                                    @endif
                                </div>

                            </el-tab-pane>
                        </el-tabs>
                    </div>
                    <!-- ~ Tab for each ticket-->

                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="sidebarheader" style="margin-top: 0px; background-color:#337ab7;">
                <p style="text-align: center">{{ __('Phân công người xử lý') }}</p>
            </div>

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
        $("#manager_confirmation_result").select2({
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
        $("#root_cause_approver_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#evaluation_result").select2({
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
@endpush