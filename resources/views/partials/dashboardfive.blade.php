<br/><br/>
<div class="col-sm-6">


        <div class="panel panel-primary">
            <div class="panel-heading"><b>Tổng hợp SKPH theo mức độ hiệu quả </b><span style="color:blue" class="badge">{{$allEffectivenessTickets->sum()}}</span></div>
            <div class="panel-body">
                <pie3 :statistics="{{$allEffectivenessTickets}}"></pie3>
            </div>
        </div>
</div>
<div class="col-sm-6">


        <div class="panel panel-primary">
            <div class="panel-heading"><b>Tổng hợp SKPH hàng tháng</b></div>
            <div class="panel-body">

            </div>
        </div>


</div>

<!-- /.info-box -->
    
