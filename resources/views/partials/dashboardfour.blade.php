<br/><br/>
<div class="col-sm-12">
    <div class="panel panel-primary">
        <div class="panel-heading"><b>Trạng thái phiếu C.A.R</b></div>
        <div class="panel-body">
            <table class="table">
                <tr>
                    <th rowspan="2">Bộ phận</th>
                    <th rowspan="2">Tổng số phiếu C.A.R</th>
                    <th colspan="4" style="text-align: center">Trạng thái</th>
                    <!--
                    <th colspan="6" style="text-align: center">Phân loại nguyên nhân</th>
                    -->
                </tr>
                <tr><strong>
                        <td><strong>Chưa được chỉ định người phân tích nguyên nhân và đề xuất hành động KPPN</strong></td>
                        <td><strong>Chưa được duyệt nguyên nhân gốc rễ</strong></td>
                        <td><strong>Chưa đc duyệt hành động KPPN</strong></td>
                        <td><strong>Chưa hoàn thành hành động KPPN gồm cả chưa đến hạn, quá hạn</strong></td>
                        <!--
                        <td><strong>Con người</strong></td>
                        <td><strong>Máy móc</strong></td>
                        <td><strong>Nguyên liệu</strong></td>
                        <td><strong>Phương pháp</strong></td>
                        <td><strong>Đo lường</strong></td>
                        <td><strong>Môi trường</strong></td>
                        -->
                    </strong>
                </tr>
                <tr>
                    <td>HCNS</td>
                    <td>{{$allDepartmentTickets[0]}}</td>
                    <td>{{$allDepartmentStateTickets[0][0]}} <i>({{$allDepartmentStateTickets[0]->sum() ? (int)(100 * $allDepartmentStateTickets[0][0]/$allDepartmentStateTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[0][1]}} <i>({{$allDepartmentStateTickets[0]->sum() ? (int)(100 * $allDepartmentStateTickets[0][1]/$allDepartmentStateTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[0][2]}} <i>({{$allDepartmentStateTickets[0]->sum() ? (int)(100 * $allDepartmentStateTickets[0][2]/$allDepartmentStateTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[0][3]}} <i>({{$allDepartmentStateTickets[0]->sum() ? (int)(100 * $allDepartmentStateTickets[0][3]/$allDepartmentStateTickets[0]->sum()) : 0}} %)</i></td>

                    <!--
                    <td>{{$allDepartmentReasonTickets[0][0]}} <i>({{$allDepartmentReasonTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][0]/$allDepartmentReasonTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[0][1]}} <i>({{$allDepartmentReasonTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][1]/$allDepartmentReasonTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[0][2]}} <i>({{$allDepartmentReasonTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][2]/$allDepartmentReasonTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[0][3]}} <i>({{$allDepartmentReasonTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][3]/$allDepartmentReasonTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[0][4]}} <i>({{$allDepartmentReasonTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][4]/$allDepartmentReasonTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[0][5]}} <i>({{$allDepartmentReasonTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][5]/$allDepartmentReasonTickets[0]->sum()) : 0}} %)</i></td>
                    -->
                </tr>
                <tr>
                    <td>Kinh Doanh</td>
                    <td>{{$allDepartmentTickets[1]}}</td>
                    <td>{{$allDepartmentStateTickets[1][0]}} <i>({{$allDepartmentStateTickets[1]->sum() ? (int)(100 * $allDepartmentStateTickets[1][0]/$allDepartmentStateTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[1][1]}} <i>({{$allDepartmentStateTickets[1]->sum() ? (int)(100 * $allDepartmentStateTickets[1][1]/$allDepartmentStateTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[1][2]}} <i>({{$allDepartmentStateTickets[1]->sum() ? (int)(100 * $allDepartmentStateTickets[1][2]/$allDepartmentStateTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[1][3]}} <i>({{$allDepartmentStateTickets[1]->sum() ? (int)(100 * $allDepartmentStateTickets[1][3]/$allDepartmentStateTickets[1]->sum()) : 0}} %)</i></td>

                <!--
                    <td>{{$allDepartmentReasonTickets[1][0]}} <i>({{$allDepartmentReasonTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][0]/$allDepartmentReasonTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[1][1]}} <i>({{$allDepartmentReasonTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][1]/$allDepartmentReasonTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[1][2]}} <i>({{$allDepartmentReasonTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][2]/$allDepartmentReasonTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[1][3]}} <i>({{$allDepartmentReasonTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][3]/$allDepartmentReasonTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[1][4]}} <i>({{$allDepartmentReasonTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][4]/$allDepartmentReasonTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[1][5]}} <i>({{$allDepartmentReasonTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][5]/$allDepartmentReasonTickets[1]->sum()) : 0}} %)</i></td>
                    -->
                </tr>
                <tr>
                    <td>Kế Toán</td>
                    <td>{{$allDepartmentTickets[2]}}</td>
                    <td>{{$allDepartmentStateTickets[2][0]}} <i>({{$allDepartmentStateTickets[2]->sum() ? (int)(100 * $allDepartmentStateTickets[2][0]/$allDepartmentStateTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[2][1]}} <i>({{$allDepartmentStateTickets[2]->sum() ? (int)(100 * $allDepartmentStateTickets[2][1]/$allDepartmentStateTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[2][2]}} <i>({{$allDepartmentStateTickets[2]->sum() ? (int)(100 * $allDepartmentStateTickets[2][2]/$allDepartmentStateTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[2][3]}} <i>({{$allDepartmentStateTickets[2]->sum() ? (int)(100 * $allDepartmentStateTickets[2][3]/$allDepartmentStateTickets[2]->sum()) : 0}} %)</i></td>

                    <!--
                    <td>{{$allDepartmentReasonTickets[2][0]}} <i>({{$allDepartmentReasonTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][0]/$allDepartmentReasonTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[2][1]}} <i>({{$allDepartmentReasonTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][1]/$allDepartmentReasonTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[2][2]}} <i>({{$allDepartmentReasonTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][2]/$allDepartmentReasonTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[2][3]}} <i>({{$allDepartmentReasonTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][3]/$allDepartmentReasonTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[2][4]}} <i>({{$allDepartmentReasonTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][4]/$allDepartmentReasonTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[2][5]}} <i>({{$allDepartmentReasonTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][5]/$allDepartmentReasonTickets[2]->sum()) : 0}} %)</i></td>
                    -->
                </tr>
                <tr>
                    <td>KSNB</td>
                    <td>{{$allDepartmentTickets[3]}}</td>
                    <td>{{$allDepartmentStateTickets[3][0]}} <i>({{$allDepartmentStateTickets[3]->sum() ? (int)(100 * $allDepartmentStateTickets[3][0]/$allDepartmentStateTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[3][1]}} <i>({{$allDepartmentStateTickets[3]->sum() ? (int)(100 * $allDepartmentStateTickets[3][1]/$allDepartmentStateTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[3][2]}} <i>({{$allDepartmentStateTickets[3]->sum() ? (int)(100 * $allDepartmentStateTickets[3][2]/$allDepartmentStateTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[3][3]}} <i>({{$allDepartmentStateTickets[3]->sum() ? (int)(100 * $allDepartmentStateTickets[3][3]/$allDepartmentStateTickets[3]->sum()) : 0}} %)</i></td>

                    <!--
                    <td>{{$allDepartmentReasonTickets[3][0]}} <i>({{$allDepartmentReasonTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][0]/$allDepartmentReasonTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[3][1]}} <i>({{$allDepartmentReasonTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][1]/$allDepartmentReasonTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[3][2]}} <i>({{$allDepartmentReasonTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][2]/$allDepartmentReasonTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[3][3]}} <i>({{$allDepartmentReasonTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][3]/$allDepartmentReasonTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[3][4]}} <i>({{$allDepartmentReasonTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][4]/$allDepartmentReasonTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[3][5]}} <i>({{$allDepartmentReasonTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][5]/$allDepartmentReasonTickets[3]->sum()) : 0}} %)</i></td>
                    -->
                </tr>
                <tr>
                    <td>Bảo Trì</td>
                    <td>{{$allDepartmentTickets[4]}}</td>
                    <td>{{$allDepartmentStateTickets[4][0]}} <i>({{$allDepartmentStateTickets[4]->sum() ? (int)(100 * $allDepartmentStateTickets[4][0]/$allDepartmentStateTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[4][1]}} <i>({{$allDepartmentStateTickets[4]->sum() ? (int)(100 * $allDepartmentStateTickets[4][1]/$allDepartmentStateTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[4][2]}} <i>({{$allDepartmentStateTickets[4]->sum() ? (int)(100 * $allDepartmentStateTickets[4][2]/$allDepartmentStateTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[4][3]}} <i>({{$allDepartmentStateTickets[4]->sum() ? (int)(100 * $allDepartmentStateTickets[4][3]/$allDepartmentStateTickets[4]->sum()) : 0}} %)</i></td>

                    <!--
                    <td>{{$allDepartmentReasonTickets[4][0]}} <i>({{$allDepartmentReasonTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][0]/$allDepartmentReasonTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[4][1]}} <i>({{$allDepartmentReasonTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][1]/$allDepartmentReasonTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[4][2]}} <i>({{$allDepartmentReasonTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][2]/$allDepartmentReasonTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[4][3]}} <i>({{$allDepartmentReasonTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][3]/$allDepartmentReasonTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[4][4]}} <i>({{$allDepartmentReasonTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][4]/$allDepartmentReasonTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[4][5]}} <i>({{$allDepartmentReasonTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][5]/$allDepartmentReasonTickets[4]->sum()) : 0}} %)</i></td>
                    -->
                </tr>
                <tr>
                    <td>Sản Xuất</td>
                    <td>{{$allDepartmentTickets[5]}}</td>
                    <td>{{$allDepartmentStateTickets[5][0]}} <i>({{$allDepartmentStateTickets[5]->sum() ? (int)(100 * $allDepartmentStateTickets[5][0]/$allDepartmentStateTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[5][1]}} <i>({{$allDepartmentStateTickets[5]->sum() ? (int)(100 * $allDepartmentStateTickets[5][1]/$allDepartmentStateTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[5][2]}} <i>({{$allDepartmentStateTickets[5]->sum() ? (int)(100 * $allDepartmentStateTickets[5][2]/$allDepartmentStateTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[5][3]}} <i>({{$allDepartmentStateTickets[5]->sum() ? (int)(100 * $allDepartmentStateTickets[5][3]/$allDepartmentStateTickets[5]->sum()) : 0}} %)</i></td>

                    <!--
                    <td>{{$allDepartmentReasonTickets[5][0]}} <i>({{$allDepartmentReasonTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][0]/$allDepartmentReasonTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[5][1]}} <i>({{$allDepartmentReasonTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][1]/$allDepartmentReasonTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[5][2]}} <i>({{$allDepartmentReasonTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][2]/$allDepartmentReasonTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[5][3]}} <i>({{$allDepartmentReasonTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][3]/$allDepartmentReasonTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[5][4]}} <i>({{$allDepartmentReasonTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][4]/$allDepartmentReasonTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[5][5]}} <i>({{$allDepartmentReasonTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][5]/$allDepartmentReasonTickets[5]->sum()) : 0}} %)</i></td>
                    -->
                </tr>
                <tr>
                    <td>Thu Mua</td>
                    <td>{{$allDepartmentTickets[6]}}</td>
                    <td>{{$allDepartmentStateTickets[6][0]}} <i>({{$allDepartmentStateTickets[6]->sum() ? (int)(100 * $allDepartmentStateTickets[6][0]/$allDepartmentStateTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[6][1]}} <i>({{$allDepartmentStateTickets[6]->sum() ? (int)(100 * $allDepartmentStateTickets[6][1]/$allDepartmentStateTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[6][2]}} <i>({{$allDepartmentStateTickets[6]->sum() ? (int)(100 * $allDepartmentStateTickets[6][2]/$allDepartmentStateTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[6][3]}} <i>({{$allDepartmentStateTickets[6]->sum() ? (int)(100 * $allDepartmentStateTickets[6][3]/$allDepartmentStateTickets[6]->sum()) : 0}} %)</i></td>

                    <!--
                    <td>{{$allDepartmentReasonTickets[6][0]}} <i>({{$allDepartmentReasonTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][0]/$allDepartmentReasonTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[6][1]}} <i>({{$allDepartmentReasonTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][1]/$allDepartmentReasonTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[6][2]}} <i>({{$allDepartmentReasonTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][2]/$allDepartmentReasonTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[6][3]}} <i>({{$allDepartmentReasonTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][3]/$allDepartmentReasonTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[6][4]}} <i>({{$allDepartmentReasonTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][4]/$allDepartmentReasonTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[6][5]}} <i>({{$allDepartmentReasonTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][5]/$allDepartmentReasonTickets[6]->sum()) : 0}} %)</i></td>
                    -->
                </tr>
                <tr>
                    <td>Kỹ Thuật</td>
                    <td>{{$allDepartmentTickets[7]}}</td>
                    <td>{{$allDepartmentStateTickets[7][0]}} <i>({{$allDepartmentStateTickets[7]->sum() ? (int)(100 * $allDepartmentStateTickets[7][0]/$allDepartmentStateTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[7][1]}} <i>({{$allDepartmentStateTickets[7]->sum() ? (int)(100 * $allDepartmentStateTickets[7][1]/$allDepartmentStateTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[7][2]}} <i>({{$allDepartmentStateTickets[7]->sum() ? (int)(100 * $allDepartmentStateTickets[7][2]/$allDepartmentStateTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[7][3]}} <i>({{$allDepartmentStateTickets[7]->sum() ? (int)(100 * $allDepartmentStateTickets[7][3]/$allDepartmentStateTickets[7]->sum()) : 0}} %)</i></td>

                    <!--
                    <td>{{$allDepartmentReasonTickets[7][0]}} <i>({{$allDepartmentReasonTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][0]/$allDepartmentReasonTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[7][1]}} <i>({{$allDepartmentReasonTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][1]/$allDepartmentReasonTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[7][2]}} <i>({{$allDepartmentReasonTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][2]/$allDepartmentReasonTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[7][3]}} <i>({{$allDepartmentReasonTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][3]/$allDepartmentReasonTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[7][4]}} <i>({{$allDepartmentReasonTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][4]/$allDepartmentReasonTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[7][5]}} <i>({{$allDepartmentReasonTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][5]/$allDepartmentReasonTickets[7]->sum()) : 0}} %)</i></td>
                    -->
                </tr>
                <tr>
                    <td>QLCL</td>
                    <td>{{$allDepartmentTickets[8]}}</td>
                    <td>{{$allDepartmentStateTickets[8][0]}} <i>({{$allDepartmentStateTickets[8]->sum() ? (int)(100 * $allDepartmentStateTickets[8][0]/$allDepartmentStateTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[8][1]}} <i>({{$allDepartmentStateTickets[8]->sum() ? (int)(100 * $allDepartmentStateTickets[8][1]/$allDepartmentStateTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[8][2]}} <i>({{$allDepartmentStateTickets[8]->sum() ? (int)(100 * $allDepartmentStateTickets[8][2]/$allDepartmentStateTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[8][3]}} <i>({{$allDepartmentStateTickets[8]->sum() ? (int)(100 * $allDepartmentStateTickets[8][3]/$allDepartmentStateTickets[8]->sum()) : 0}} %)</i></td>

                    <!--
                    <td>{{$allDepartmentReasonTickets[8][0]}} <i>({{$allDepartmentReasonTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][0]/$allDepartmentReasonTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[8][1]}} <i>({{$allDepartmentReasonTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][1]/$allDepartmentReasonTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[8][2]}} <i>({{$allDepartmentReasonTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][2]/$allDepartmentReasonTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[8][3]}} <i>({{$allDepartmentReasonTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][3]/$allDepartmentReasonTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[8][4]}} <i>({{$allDepartmentReasonTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][4]/$allDepartmentReasonTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[8][5]}} <i>({{$allDepartmentReasonTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][5]/$allDepartmentReasonTickets[8]->sum()) : 0}} %)</i></td>
                    -->
                </tr>
                <tr>
                    <td>Kho</td>
                    <td>{{$allDepartmentTickets[9]}}</td>
                    <td>{{$allDepartmentStateTickets[9][0]}} <i>({{$allDepartmentStateTickets[9]->sum() ? (int)(100 * $allDepartmentStateTickets[9][0]/$allDepartmentStateTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[9][1]}} <i>({{$allDepartmentStateTickets[9]->sum() ? (int)(100 * $allDepartmentStateTickets[9][1]/$allDepartmentStateTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[9][2]}} <i>({{$allDepartmentStateTickets[9]->sum() ? (int)(100 * $allDepartmentStateTickets[9][2]/$allDepartmentStateTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[9][3]}} <i>({{$allDepartmentStateTickets[9]->sum() ? (int)(100 * $allDepartmentStateTickets[9][3]/$allDepartmentStateTickets[9]->sum()) : 0}} %)</i></td>

                    <!--
                    <td>{{$allDepartmentReasonTickets[9][0]}} <i>({{$allDepartmentReasonTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][0]/$allDepartmentReasonTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[9][1]}} <i>({{$allDepartmentReasonTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][1]/$allDepartmentReasonTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[9][2]}} <i>({{$allDepartmentReasonTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][2]/$allDepartmentReasonTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[9][3]}} <i>({{$allDepartmentReasonTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][3]/$allDepartmentReasonTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[9][4]}} <i>({{$allDepartmentReasonTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][4]/$allDepartmentReasonTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[9][5]}} <i>({{$allDepartmentReasonTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][5]/$allDepartmentReasonTickets[9]->sum()) : 0}} %)</i></td>
                    -->
                </tr>
                <tr>
                    <td>Pháp chế</td>
                    <td>{{$allDepartmentTickets[10]}}</td>
                    <td>{{$allDepartmentStateTickets[10][0]}} <i>({{$allDepartmentStateTickets[10]->sum() ? (int)(100 * $allDepartmentStateTickets[10][0]/$allDepartmentStateTickets[10]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[10][1]}} <i>({{$allDepartmentStateTickets[10]->sum() ? (int)(100 * $allDepartmentStateTickets[10][1]/$allDepartmentStateTickets[10]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[10][2]}} <i>({{$allDepartmentStateTickets[10]->sum() ? (int)(100 * $allDepartmentStateTickets[10][2]/$allDepartmentStateTickets[10]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStateTickets[10][3]}} <i>({{$allDepartmentStateTickets[10]->sum() ? (int)(100 * $allDepartmentStateTickets[10][3]/$allDepartmentStateTickets[10]->sum()) : 0}} %)</i></td>

                <!--
                    <td>{{$allDepartmentReasonTickets[10][0]}} <i>({{$allDepartmentReasonTickets[10]->sum() ? (int)(100 * $allDepartmentReasonTickets[10][0]/$allDepartmentReasonTickets[10]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[10][1]}} <i>({{$allDepartmentReasonTickets[10]->sum() ? (int)(100 * $allDepartmentReasonTickets[10][1]/$allDepartmentReasonTickets[10]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[10][2]}} <i>({{$allDepartmentReasonTickets[10]->sum() ? (int)(100 * $allDepartmentReasonTickets[10][2]/$allDepartmentReasonTickets[10]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[10][3]}} <i>({{$allDepartmentReasonTickets[10]->sum() ? (int)(100 * $allDepartmentReasonTickets[10][3]/$allDepartmentReasonTickets[10]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[10][4]}} <i>({{$allDepartmentReasonTickets[10]->sum() ? (int)(100 * $allDepartmentReasonTickets[10][4]/$allDepartmentReasonTickets[10]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[10][5]}} <i>({{$allDepartmentReasonTickets[10]->sum() ? (int)(100 * $allDepartmentReasonTickets[10][5]/$allDepartmentReasonTickets[10]->sum()) : 0}} %)</i></td>
                    -->
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- /.info-box -->
    
