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

                                </h5>
                                <table style="width:100%">
                                    <tr>
                                        <th class="col-md-3">Có gì đã xảy ra?</th>
                                        <td class="col-md-4">{{$ticket->what}}</td>
                                        @if($ticket->image)
                                        <th rowspan="5"><img class="img-responsive" src={{url('/upload/' . $ticket->image)}}></th>
                                        @else
                                            <th rowspan="5"><img class="img-responsive" src={{url('/images/no-evidence.jpg')}}></th>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Tại sao đây là một vấn đề?</th>
                                        <td class="col-md-4">{{$ticket->why}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Nó xảy ra khi nào?</th>
                                        <td class="col-md-4">{{date('d F, Y', strtotime($ticket->when))}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Ai phát hiện ra?</th>
                                        <td class="col-md-4">{{$ticket->who}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Phát hiện ra ở đâu?</th>
                                        <td class="col-md-4">{{$ticket->where}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Bằng cách nào?</th>
                                        <td class="col-md-4">{{$ticket->how_1}}</td>
                                        <th rowspan="2">{{$ticket->manager->name}}:<b style="color:red"> Chưa xác nhận!</b></th>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Có bao nhiêu sự không phù hợp?</th>
                                        <td class="col-md-4">{{$ticket->how_2}}</td>
                                    </tr>
                                </table>
                            </el-tab-pane>
                            <el-tab-pane label="Khắc phục" name="troubleshoot">
                                <h5><b style="color:blue; float: left;">2. Xác định trách nhiệm:</b></h5>

                                <h5><b style="color:blue;float: left;">3. Thực hiện biện pháp khắc phục:</b></h5>

                            </el-tab-pane>
                            <el-tab-pane label="Phòng ngừa" name="prevents">
                                <h5><b style="color:blue; float: left">4. Xem xét mức độ sự không phù hợp:</b></h5>

                                <br>
                                <hr style="color:#337ab7; border-color:#337ab7; background-color:#337ab7">
                                <h5><b style="color:blue">5. Hoạt động phòng ngừa</b></h5>

                                <h5><b style="color:blue;float: left;">6. Đánh giá hiệu quả: &nbsp;</b></h5>

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
                @foreach($ticket->activity as $activity)
                    @if($activity->action != 'effectiveness_asset')
                        <div class="feed-item">
                            <div class="activity-date">{{date('d, F Y H:i', strTotime($activity->created_at))}}</div>
                            <div class="activity-text">{!! $activity->text !!}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@stop

@push('scripts')

@endpush