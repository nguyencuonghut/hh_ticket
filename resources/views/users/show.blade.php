@extends('layouts.master')
@section('content')

    <div class="col-sm-12">
        <br>
        <div class="col-sm-6 removeleft">
            <div class="panel panel-primary">
                <div class="panel-heading">Ticket tôi tạo</div>
                <div class="panel-body">
                    <table class="table table-hover " id="my-created-table">
                        <thead>
                        <tr>
                            <th>{{ __('Tiêu đề') }}</th>
                            <th>{{ __('Ngày tạo') }}</th>
                            <th>{{ __('Hạn trả lời') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">Hành động khắc phục của tôi</div>
                <div class="panel-body">
                    <table class="table table-hover " id="my-troubleshootactions-table">
                        <thead>
                        <tr>
                            <th>{{ __('Tiêu đề') }}</th>
                            <th>{{ __('Trạng thái') }}</th>
                            <th>{{ __('Sửa') }}</th>
                            <th>{{ __('Đóng') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">Ticket tạo gần đây</div>
                <div class="panel-body">
                    @foreach($tickets->slice(0, 5) as $ticket)
                        <div class="media">
                            <div class="media-left">
                                <a href="{{route('tickets.show', $ticket->id)}}">
                                    @if($ticket->image_path)
                                        <img class="media-object" style="width: 100px;" src={{url('/upload/' . $ticket->image_path)}} alt="...">
                                    @else
                                        <img class="media-object" style="width: 100px;" src={{url('/images/no-evidence.jpg')}} alt="...">
                                    @endif
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="{{route('tickets.show', $ticket->id)}}"><h5 class="media-heading">{{str_limit($ticket->title, 40)}}</h5></a>
                                <i class="fa fa-check-circle" style="color:green">
                                    <i style="color: #333333">
                                        @if(date_diff(new DateTime('now'), $ticket->created_at)->y)
                                            {{ date_diff(new DateTime('now'), $ticket->created_at)->y }} năm
                                        @endif
                                        @if(date_diff(new DateTime('now'), $ticket->created_at)->m)
                                            {{ date_diff(new DateTime('now'), $ticket->created_at)->m }} tháng
                                        @endif
                                        @if(date_diff(new DateTime('now'), $ticket->created_at)->d)
                                            {{ date_diff(new DateTime('now'), $ticket->created_at)->d }} ngày
                                        @endif
                                        @if(date_diff(new DateTime('now'), $ticket->created_at)->h)
                                            {{ date_diff(new DateTime('now'), $ticket->created_at)->h }} giờ
                                        @endif
                                        @if(date_diff(new DateTime('now'), $ticket->created_at)->i)
                                            {{ date_diff(new DateTime('now'), $ticket->created_at)->i }} phút
                                        @else
                                            0 phút
                                        @endif
                                        trước bởi <b>{{$ticket->creator->name}}</b>
                                    </i>
                                </i>
                                <br>
                                <?php
                                $troubleshoot_action_cnt = \Illuminate\Support\Facades\DB::table('troubleshoots')->where('ticket_id', $ticket->id)->count();
                                $troubleshoot_completed_action_cnt = \Illuminate\Support\Facades\DB::table('troubleshoots')->where('ticket_id', $ticket->id)->where('status_id', '2')->count();
                                if(0 == $troubleshoot_action_cnt) {
                                    $troubleshoot_per = 0;
                                } else {
                                    $troubleshoot_per = (int)(($troubleshoot_completed_action_cnt/$troubleshoot_action_cnt)*100);
                                }

                                $prevention_action_cnt = \Illuminate\Support\Facades\DB::table('preventions')->where('ticket_id', $ticket->id)->count();
                                $prevention_completed_action_cnt = \Illuminate\Support\Facades\DB::table('preventions')->where('ticket_id', $ticket->id)->where('status_id', '2')->count();
                                if(0 == $prevention_action_cnt) {
                                    $prevention_per = 0;
                                } else {
                                    $prevention_per = (int)(($prevention_completed_action_cnt/$prevention_action_cnt)*100);
                                }
                                ?>
                                <i class="fa fa-wrench" style="color:red; float: left;"><i style="color: #333333"> {{$troubleshoot_per}}%</i></i>
                                <span style="float: left;">&nbsp;</span>
                                <div class="progress" style=".progress {
                             position: relative;
                             height: 8px;
                             }; margin-top: 4px" >
                                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow={{$troubleshoot_per}} aria-valuemin="0" aria-valuemax="100" style="width: {{$troubleshoot_per}}%">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                                <i class="fa fa-shield" style="float: left;color:green;margin-top: -13px"><i style="color: #333333"> {{$prevention_per}}%</i></i>
                                <span style="float: left;">&nbsp;</span>
                                <div class="progress" style=".progress {
                             position: relative;
                             height: 8px;
                             }; margin-top: -11px; margin-left: 40px" >
                                    <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="{{$prevention_per}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$prevention_per}}%">
                                        <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        {!! $tickets->render() !!}
                </div>
            </div>
        </div>
        <div class="col-sm-6 removeright">
            <div class="panel panel-primary">
                <div class="panel-heading">Ticket tôi xác nhận</div>
                <div class="panel-body">
                    <table class="table table-hover " id="my-confirmed-table">
                        <thead>
                        <tr>
                            <th>{{ __('Tiêu đề') }}</th>
                            <th>{{ __('Ngày tạo') }}</th>
                            <th>{{ __('Hạn trả lời') }}</th>
                            <th>{{ __('Kết quả') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">Hành động phòng ngừa của tôi</div>
                <div class="panel-body">
                    <table class="table table-hover " id="my-preventionactions-table">
                        <thead>
                        <tr>
                            <th>{{ __('Tiêu đề') }}</th>
                            <th>{{ __('Trạng thái') }}</th>
                            <th>{{ __('Sửa') }}</th>
                            <th>{{ __('Đóng') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <hr style="color:#337ab7; border-color:#337ab7; background-color:#337ab7">


    </div>

@stop
@push('scripts')
    <script>
        $(function () {
            $('#my-created-table').DataTable({
                processing: true,
                serverSide: true,

                ajax: '{!! route('tickets.mycreateddata') !!}',
                columns: [
                    {data: 'titlelink', name: 'title'},
                    {data: 'issue_date', name: 'issue_date'},
                    {data: 'answer_date', name: 'answer_date'},
                ],
                createdRow: function ( row, data, index ) {
                    if ( data['ticket_status'] == '1' ) {
                        $('td', row).addClass('success');
                    } else {
                        $('td', row).addClass('primary');
                    }
                },
            });

            $('#my-troubleshootactions-table').DataTable({
                processing: true,
                serverSide: true,

                ajax: '{!! route('troubleshoots.myactionsdata') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'status'},
                    { data: 'edit', name: 'edit', orderable: false, searchable: false},
                    { data: 'markCompleted', name: 'markCompleted', orderable: false, searchable: false},
                ],
                createdRow: function ( row, data, index ) {
                    if ( data['status'] == 'Open' ) {
                        $('td', row).addClass('success');
                    } else {
                        $('td', row).addClass('primary');
                    }
                },
            });

            $('#my-confirmed-table').DataTable({
                processing: true,
                serverSide: true,

                ajax: '{!! route('tickets.myconfirmeddata') !!}',
                columns: [
                    {data: 'titlelink', name: 'title'},
                    {data: 'issue_date', name: 'issue_date'},
                    {data: 'answer_date', name: 'answer_date'},
                    {data: 'confirmation_result', name: 'confirmation_result'},
                ],
                createdRow: function ( row, data, index ) {
                    if ( data['ticket_status_id'] == '1' ) {
                        $('td', row).addClass('success');
                    } else {
                        $('td', row).addClass('primary');
                    }
                },
            });

            $('#my-preventionactions-table').DataTable({
                processing: true,
                serverSide: true,

                ajax: '{!! route('preventions.myactionsdata') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'status'},
                    { data: 'edit', name: 'edit', orderable: false, searchable: false},
                    { data: 'markCompleted', name: 'markCompleted', orderable: false, searchable: false},
                ],
                createdRow: function ( row, data, index ) {
                    if ( data['status'] == 'Open' ) {
                        $('td', row).addClass('success');
                    } else {
                        $('td', row).addClass('primary');
                    }
                },
            });
        });
    </script>
@endpush


