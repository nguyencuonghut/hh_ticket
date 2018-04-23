<br/><br/>
<div class="col-md-12">
    {!! Form::open([
        'route' => 'tickets.effectivenessfiltered',
        'files'=>true,
        'enctype' => 'multipart/form-data'
    ]) !!}
    <div class="form-group">
        <select name="department_id">
            <option value= " 0 "> Tất cả </option>
            @foreach($departments as $id => $name)
                <option value= " {{ $id }} "> {{$name}} </option>
            @endforeach
        </select>
        <span>
            {!! Form::submit('Lọc', ['class' => 'btn btn-success btn-xs']) !!}
        </span>
    </div>

</div>
{!! Form::close() !!}

<div class="col-sm-6">


        <div class="panel panel-primary">
            <div class="panel-heading"><b>Tổng hợp SKPH theo Phòng/Ban </b><span style="color:blue" class="badge">{{$allDepartmentTickets->sum()}}</span></div>
            <div class="panel-body">
                <pie :statistics="{{$allDepartmentTickets}}"></pie>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading"><b>Tổng hợp SKPH theo mức độ hiệu quả <i style="color: gold">({{$department_name}})</i></b>&nbsp;<span style="color:blue" class="badge">{{$allEffectivenessTickets->sum()}}</span></div>
            <div class="panel-body">
                <pie3 :statistics="{{$allEffectivenessTickets}}"></pie3>
            </div>
        </div>
</div>
<div class="col-sm-6">


        <div class="panel panel-primary">
            <div class="panel-heading"><b>Tổng hợp SKPH theo nguyên nhân</b></div>
            <div class="panel-body">
                <pie2 :statistics="{{$allReasonTickets}}" ></pie2>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading"><b>Tổng hợp SKPH hàng tháng</b></div>
            <div class="panel-body">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">Tổng hợp SKPH hàng tháng</h4>
                        <div class="box-tools pull-right">
                            <button type="button" id="collapse1" class="btn btn-box-tool" data-toggle="collapse"
                                    data-target="#collapseOne"><i id="toggler1" class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div id="collapseOne" class="panel-collapse">
                        <div class="box-body">
                            <div>
                                <?php $createdTicketEachMonths = array(); $ticketCreated = array();?>
                                @foreach($createdTicketsMonthly as $ticket)
                                    <?php $createdTicketEachMonths[] = date('F', strTotime($ticket->created_at)) ?>
                                    <?php $ticketCreated[] = $ticket->month;?>
                                @endforeach
                                <?php $completedTicketEachMonths = array(); $ticketCompleted = array();?>

                                @foreach($completedTicketsMonthly as $tickets)
                                    <?php $completedTicketEachMonths[] = date('F', strTotime($tickets->updated_at)) ?>
                                    <?php $ticketCompleted[] = $tickets->month;?>
                                @endforeach

                                <graphline class="chart" :labels="{{json_encode($createdTicketEachMonths)}}"
                                           :values="{{json_encode($ticketCreated)}}"
                                           :valuesextra="{{json_encode($ticketCompleted)}}"></graphline>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
@push('scripts')
    <script type="text/javascript">
        $("#department_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
@endpush
<!-- /.info-box -->
    
