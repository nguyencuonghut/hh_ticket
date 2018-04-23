<?php
namespace App\Repositories\Ticket;

use App\Models\RootCauseType;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Gate;
use Datatables;
use Carbon;
use Auth;
use DB;

/**
 * Class TicketRepository
 * @package App\Repositories\Ticket
 */
class TicketRepository implements TicketRepositoryContract
{
    const CREATED = 'created';
    const UPDATED_DESCRIPTION = 'updated_description';
    const DIRECTOR_APPROVED = 'director_approved';
    const DIRECTOR_REJECTED = 'director_rejected';
    const REQ_APPROVE_ROOT_CAUSE = 'req_approve_root_cause';
    const ROOT_CAUSE_APPROVED = 'root_cause_approved';
    const ROOT_CAUSE_REJECTED = 'root_cause_rejected';
    const ASSET_EFFECTIVENESS = 'asset_effectiveness';
    const ASSIGNED_TROUBLESHOOTER = 'assigned_troubleshooter';
    const REQUEST_TO_APPROVE_TROUBLESHOOT = 'request_to_approve_troubleshoot';
    const TROUBLESHOOT_APPROVED = 'troubleshoot_approved';
    const TROUBLESHOOT_REJECTED = 'troubleshoot_rejected';
    const ASSIGNED_PREVENTER = 'assigned_preventer';
    const REQUEST_TO_APPROVE_PREVENTION = 'request_to_approve_prevention';
    const PREVENTION_APPROVED = 'prevention_approved';
    const PREVENTION_REJECTED = 'prevention_rejected';
    const EVALUATED = 'evaluated';
    const MARK_TICKET_COMPLETED = 'mark_ticket_completed';

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return Ticket::findOrFail($id);
    }

    /**
     * @param $requestData
     * @return static
     */
    public function create($requestData)
    {
        $filename = null;
        if ($requestData->hasFile('image_path')) {
            if (!is_dir(public_path(). '/upload/')) {
                mkdir(public_path(). '/upload/', 0777, true);
            }
            $file =  $requestData->file('image_path');

            $destinationPath = public_path(). '/upload/';
            $filename = str_random(8) . '_' . $file->getClientOriginalName() ;
            $file->move($destinationPath, $filename);
        }

        $input = $requestData = array_merge(
            $requestData->all(),
            ['creator_id' => auth()->id(),
                'image_path' => $filename,
                'department_id' => User::findOrFail($requestData->director_id)->department->first()->id,
                'director_confirmation_result_id' => 3, //Default value
                'assigned_troubleshooter_id' => $requestData->director_id,
                'assigned_preventer_id' => $requestData->director_id,
                'state_id' => 1,
                'ticket_status_id' => 1,
            ]
        );

        $ticket = Ticket::create($input);

        Session::flash('flash_message', 'Tạo phiếu C.A.R thành công!');
        event(new \App\Events\TicketAction($ticket, self::CREATED));
        return $ticket->id;
    }

    /**
     * @param $id
     * @param $requestData
     * @return mixed
     */
    public function update($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $filename = null;
        if ($requestData->hasFile('image_path')) {
            if (!is_dir(public_path(). '/upload/')) {
                mkdir(public_path(). '/upload/', 0777, true);
            }
            $file =  $requestData->file('image_path');

            $destinationPath = public_path(). '/upload/';
            $filename = str_random(8) . '_' . $file->getClientOriginalName() ;
            $file->move($destinationPath, $filename);
        } else { //Use the current image
            $filename = $ticket->image_path;
        }

        $input = $requestData = array_merge(
            $requestData->all(),
            ['creator_id' => auth()->id(),
                'image_path' => $filename,]
        );

        $ticket->fill($input)->save();

        Session::flash('flash_message', 'Sửa phiếu C.A.R thành công!');
        event(new \App\Events\TicketAction($ticket, self::UPDATED_DESCRIPTION));
        return $ticket->id;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($request, $id)
    {
    }

    /**
     * Director confirm the ticket
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function directorConfirm($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->director_confirmation_result_id = $requestData->director_confirmation_result_id;
        $ticket->director_confirmation_comment = $requestData->director_confirmation_comment;
        $ticket->save();
        $ticket = $ticket->fresh();
        if('Đồng ý' == $ticket->director_confirmation_result->name){
            event(new \App\Events\TicketAction($ticket, self::DIRECTOR_APPROVED));
        } else {
            event(new \App\Events\TicketAction($ticket, self::DIRECTOR_REJECTED));
        }
    }

    /**
     * Director confirm the ticket
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function setResponsibility($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->responsibility_id = $requestData->responsibility_id;
        $ticket->save();
        $ticket = $ticket->fresh();
    }

    /**
     * Director confirm the ticket
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function evaluateTicket($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->evaluation_id = $requestData->evaluation_id;
        $ticket->save();
        $ticket = $ticket->fresh();
        event(new \App\Events\TicketAction($ticket, self::EVALUATED));
    }

    /**
     * Update root cause
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function updateRootCause($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->root_cause_type_id = $requestData->root_cause_type_id;
        $ticket->root_cause = $requestData->root_cause;
        $ticket->save();
        $ticket = $ticket->fresh();
    }

    /**
     * @param $id
     * @param
     */
    public function getAllRootCauseTypesWithDescription()
    {
        return RootCauseType::all()
            ->pluck('nameAndDescription', 'id');
    }

    /**
     * Approver confirm the root cause
     * @param $id
     * @return mixed
     */
    public function rootCauseApprove($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->evaluation_result_id = $requestData->evaluation_result_id;
        $ticket->save();
        $ticket = $ticket->fresh();
        if('Đồng ý' == $ticket->evaluation_result->name){
            event(new \App\Events\TicketAction($ticket, self::ROOT_CAUSE_APPROVED));
        } else {
            //Update the status
            $ticket = Ticket::findOrFail($id);
            $ticket->state_id = 2; //Phiếu CAR chua được duyệt nguyên nhân gốc rễ
            $ticket->save();
            event(new \App\Events\TicketAction($ticket, self::ROOT_CAUSE_REJECTED));
        }
    }


    /**
     * Asset the effectiveness of ticket
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function assetEffectiveness($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->effectiveness_id = $requestData->effectiveness_id;
        $ticket->effectiveness_comment = $requestData->effectiveness_comment;
        $ticket->save();
        $ticket = $ticket->fresh();
        event(new \App\Events\TicketAction($ticket, self::ASSET_EFFECTIVENESS));
    }

    /**
     * Assign troubleshooter
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function assignTroubleshooter($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->assigned_troubleshooter_id = $requestData->assigned_troubleshooter_id;
        $ticket->save();
        $ticket = $ticket->fresh();
        event(new \App\Events\TicketAction($ticket, self::ASSIGNED_TROUBLESHOOTER));
    }

    /**
     * Request to approve troubleshoot actions
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function requestToApproveTroubleshoot($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        event(new \App\Events\TicketAction($ticket, self::REQUEST_TO_APPROVE_TROUBLESHOOT));
    }

    /**
     * Approve troubleshoot actions
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function approveTroubleshoot($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->approve_troubleshoot_result_id = $requestData->approve_troubleshoot_result_id;
        $ticket->approve_troubleshoot_comment = $requestData->approve_troubleshoot_comment;
        $ticket->save();
        $ticket = $ticket->fresh();
        if('Đồng ý' == $ticket->approve_troubleshoot_result->name){
            event(new \App\Events\TicketAction($ticket, self::TROUBLESHOOT_APPROVED));
        } else {
            event(new \App\Events\TicketAction($ticket, self::TROUBLESHOOT_REJECTED));
        }
    }

    /**
     * Assign preventer
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function assignPreventer($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->assigned_preventer_id = $requestData->assigned_preventer_id;
        $ticket->save();
        $ticket = $ticket->fresh();
        event(new \App\Events\TicketAction($ticket, self::ASSIGNED_PREVENTER));
    }

    /**
     * Request to approve prevention actions
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function requestToApprovePrevention($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        event(new \App\Events\TicketAction($ticket, self::REQUEST_TO_APPROVE_PREVENTION));
    }

    /**
     * Approve prevention actions
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function approvePrevention($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->approve_prevention_result_id = $requestData->approve_prevention_result_id;
        $ticket->approve_prevention_comment = $requestData->approve_prevention_comment;
        $ticket->save();
        $ticket = $ticket->fresh();
        if('Đồng ý' == $ticket->approve_prevention_result->name){
            //Update the status
            $ticket = Ticket::findOrFail($id);
            $ticket->state_id = 4; //Phiếu CAR chưa hoàn thành hành động KPPN (gồm cả chưa đến hạn, quá hạn)
            $ticket->save();
            event(new \App\Events\TicketAction($ticket, self::PREVENTION_APPROVED));
        } else {
            //Update the status
            $ticket = Ticket::findOrFail($id);
            $ticket->state_id = 3; //Phiếu CAR chưa được duyệt hành động KPPN
            $ticket->save();
            event(new \App\Events\TicketAction($ticket, self::PREVENTION_REJECTED));
        }
    }


    /**
     * @param
     */
    public function allDepartmentStatistic()
    {
        $hcns_cnt =  Ticket::all()->where('department_id', 1)->count();
        $sale_cnt =  Ticket::all()->where('department_id', 2)->count();
        $ketoan_cnt =  Ticket::all()->where('department_id', 3)->count();
        $ksnb_cnt =  Ticket::all()->where('department_id', 4)->count();
        $baotri_cnt =  Ticket::all()->where('department_id', 5)->count();
        $sx_cnt =  Ticket::all()->where('department_id', 6)->count();
        $thumua_cnt =  Ticket::all()->where('department_id', 7)->count();
        $kythuat_cnt =  Ticket::all()->where('department_id', 8)->count();
        $qlcl_cnt =  Ticket::all()->where('department_id', 9)->count();
        $kho_cnt =  Ticket::all()->where('department_id', 10)->count();

        return collect([$hcns_cnt, $sale_cnt, $ketoan_cnt, $ksnb_cnt, $baotri_cnt,
            $sx_cnt, $thumua_cnt, $kythuat_cnt, $qlcl_cnt, $kho_cnt]);
        //return collect([12, 20, 31, 14, 55, 26, 57, 88, 9, 10]);
    }
    /**
     * @param
     */
    public function allReasonStatistic()
    {
        $human_cnt =  Ticket::all()->where('root_cause_type_id', 1)->count();
        $machine_cnt =  Ticket::all()->where('root_cause_type_id', 2)->count();
        $material_cnt =  Ticket::all()->where('root_cause_type_id', 3)->count();
        $method_cnt =  Ticket::all()->where('root_cause_type_id', 4)->count();
        $measurement_cnt =  Ticket::all()->where('root_cause_type_id', 5)->count();
        $environment_cnt =  Ticket::all()->where('root_cause_type_id', 6)->count();

        return collect([$human_cnt, $machine_cnt, $material_cnt, $method_cnt, $measurement_cnt, $environment_cnt]);
        //return collect([24, 7, 55, 16, 25, 86]);
    }


    /**
     * @param
     */
    public function allDepartmentStateStatistic()
    {
        $hcns_status_1_cnt =  Ticket::all()->where('department_id', 1)->where('state_id', 1)->count();
        $hcns_status_2_cnt =  Ticket::all()->where('department_id', 1)->where('state_id', 2)->count();
        $hcns_status_3_cnt =  Ticket::all()->where('department_id', 1)->where('state_id', 3)->count();
        $hcns_status_4_cnt =  Ticket::all()->where('department_id', 1)->where('state_id', 4)->count();
        $hcns_status_5_cnt =  Ticket::all()->where('department_id', 1)->where('state_id', 5)->count();
        $hcns_cnt = collect([$hcns_status_1_cnt, $hcns_status_2_cnt, $hcns_status_3_cnt, $hcns_status_4_cnt, $hcns_status_5_cnt]);
        //$hcns_cnt = collect([0, 1, 2, 3]);

        $sale_status_1_cnt =  Ticket::all()->where('department_id', 2)->where('state_id', 1)->count();
        $sale_status_2_cnt =  Ticket::all()->where('department_id', 2)->where('state_id', 2)->count();
        $sale_status_3_cnt =  Ticket::all()->where('department_id', 2)->where('state_id', 3)->count();
        $sale_status_4_cnt =  Ticket::all()->where('department_id', 2)->where('state_id', 4)->count();
        $sale_status_5_cnt =  Ticket::all()->where('department_id', 2)->where('state_id', 5)->count();
        $sale_cnt = collect([$sale_status_1_cnt, $sale_status_2_cnt, $sale_status_3_cnt, $sale_status_4_cnt, $sale_status_5_cnt]);
        //$sale_cnt = collect([10, 11, 12, 13]);


        $ketoan_status_1_cnt =  Ticket::all()->where('department_id', 3)->where('state_id', 1)->count();
        $ketoan_status_2_cnt =  Ticket::all()->where('department_id', 3)->where('state_id', 2)->count();
        $ketoan_status_3_cnt =  Ticket::all()->where('department_id', 3)->where('state_id', 3)->count();
        $ketoan_status_4_cnt =  Ticket::all()->where('department_id', 3)->where('state_id', 4)->count();
        $ketoan_status_5_cnt =  Ticket::all()->where('department_id', 3)->where('state_id', 5)->count();
        $ketoan_cnt = collect([$ketoan_status_1_cnt, $ketoan_status_2_cnt, $ketoan_status_3_cnt, $ketoan_status_4_cnt, $ketoan_status_5_cnt]);
        //$ketoan_cnt = collect([20, 21, 22, 23]);


        $ksnb_status_1_cnt =  Ticket::all()->where('department_id', 4)->where('state_id', 1)->count();
        $ksnb_status_2_cnt =  Ticket::all()->where('department_id', 4)->where('state_id', 2)->count();
        $ksnb_status_3_cnt =  Ticket::all()->where('department_id', 4)->where('state_id', 3)->count();
        $ksnb_status_4_cnt =  Ticket::all()->where('department_id', 4)->where('state_id', 4)->count();
        $ksnb_status_5_cnt =  Ticket::all()->where('department_id', 4)->where('state_id', 5)->count();
        $ksnb_cnt = collect([$ksnb_status_1_cnt, $ksnb_status_2_cnt, $ksnb_status_3_cnt, $ksnb_status_4_cnt, $ksnb_status_5_cnt]);
        //$ksnb_cnt = collect([30, 31, 32, 33]);

        $baotri_status_1_cnt =  Ticket::all()->where('department_id', 5)->where('state_id', 1)->count();
        $baotri_status_2_cnt =  Ticket::all()->where('department_id', 5)->where('state_id', 2)->count();
        $baotri_status_3_cnt =  Ticket::all()->where('department_id', 5)->where('state_id', 3)->count();
        $baotri_status_4_cnt =  Ticket::all()->where('department_id', 5)->where('state_id', 4)->count();
        $baotri_status_5_cnt =  Ticket::all()->where('department_id', 5)->where('state_id', 5)->count();
        $baotri_cnt = collect([$baotri_status_1_cnt, $baotri_status_2_cnt, $baotri_status_3_cnt, $baotri_status_4_cnt, $baotri_status_5_cnt]);
        //$baotri_cnt = collect([40, 41, 42, 43]);

        $sx_status_1_cnt =  Ticket::all()->where('department_id', 6)->where('state_id', 1)->count();
        $sx_status_2_cnt =  Ticket::all()->where('department_id', 6)->where('state_id', 2)->count();
        $sx_status_3_cnt =  Ticket::all()->where('department_id', 6)->where('state_id', 3)->count();
        $sx_status_4_cnt =  Ticket::all()->where('department_id', 6)->where('state_id', 4)->count();
        $sx_status_5_cnt =  Ticket::all()->where('department_id', 6)->where('state_id', 5)->count();
        $sx_cnt = collect([$sx_status_1_cnt, $sx_status_2_cnt, $sx_status_3_cnt, $sx_status_4_cnt, $sx_status_5_cnt]);
        //$sx_cnt = collect([50, 51, 52, 53]);

        $thumua_status_1_cnt =  Ticket::all()->where('department_id', 7)->where('state_id', 1)->count();
        $thumua_status_2_cnt =  Ticket::all()->where('department_id', 7)->where('state_id', 2)->count();
        $thumua_status_3_cnt =  Ticket::all()->where('department_id', 7)->where('state_id', 3)->count();
        $thumua_status_4_cnt =  Ticket::all()->where('department_id', 7)->where('state_id', 4)->count();
        $thumua_status_5_cnt =  Ticket::all()->where('department_id', 7)->where('state_id', 5)->count();
        $thumua_cnt = collect([$thumua_status_1_cnt, $thumua_status_2_cnt, $thumua_status_3_cnt, $thumua_status_4_cnt, $thumua_status_5_cnt]);
        //$thumua_cnt = collect([60, 61, 62, 63]);

        $kythuat_status_1_cnt =  Ticket::all()->where('department_id', 8)->where('state_id', 1)->count();
        $kythuat_status_2_cnt =  Ticket::all()->where('department_id', 8)->where('state_id', 2)->count();
        $kythuat_status_3_cnt =  Ticket::all()->where('department_id', 8)->where('state_id', 3)->count();
        $kythuat_status_4_cnt =  Ticket::all()->where('department_id', 8)->where('state_id', 4)->count();
        $kythuat_status_5_cnt =  Ticket::all()->where('department_id', 8)->where('state_id', 5)->count();
        $kythuat_cnt = collect([$kythuat_status_1_cnt, $kythuat_status_2_cnt, $kythuat_status_3_cnt, $kythuat_status_4_cnt, $kythuat_status_5_cnt]);
        //$kythuat_cnt = collect([70, 71, 72, 73]);

        $qlcl_status_1_cnt =  Ticket::all()->where('department_id', 9)->where('state_id', 1)->count();
        $qlcl_status_2_cnt =  Ticket::all()->where('department_id', 9)->where('state_id', 2)->count();
        $qlcl_status_3_cnt =  Ticket::all()->where('department_id', 9)->where('state_id', 3)->count();
        $qlcl_status_4_cnt =  Ticket::all()->where('department_id', 9)->where('state_id', 4)->count();
        $qlcl_status_5_cnt =  Ticket::all()->where('department_id', 9)->where('state_id', 5)->count();
        $qlcl_cnt = collect([$qlcl_status_1_cnt, $qlcl_status_2_cnt, $qlcl_status_3_cnt, $qlcl_status_4_cnt, $qlcl_status_5_cnt]);
        //$qlcl_cnt = collect([80, 81, 82, 83]);

        $kho_status_1_cnt =  Ticket::all()->where('department_id', 10)->where('state_id', 1)->count();
        $kho_status_2_cnt =  Ticket::all()->where('department_id', 10)->where('state_id', 2)->count();
        $kho_status_3_cnt =  Ticket::all()->where('department_id', 10)->where('state_id', 3)->count();
        $kho_status_4_cnt =  Ticket::all()->where('department_id', 10)->where('state_id', 4)->count();
        $kho_status_5_cnt =  Ticket::all()->where('department_id', 10)->where('state_id', 5)->count();
        $kho_cnt = collect([$kho_status_1_cnt, $kho_status_2_cnt, $kho_status_3_cnt, $kho_status_4_cnt, $kho_status_5_cnt]);
        //$kho_cnt = collect([90, 91, 92, 93]);

        return collect([$hcns_cnt, $sale_cnt, $ketoan_cnt, $ksnb_cnt, $baotri_cnt,
            $sx_cnt, $thumua_cnt, $kythuat_cnt, $qlcl_cnt, $kho_cnt]);
    }


    /**
     * @param
     */
    public function allDepartmentReasonStatistic()
    {
        $hcns_reason_type_1_cnt = Ticket::all()->where('department_id', 1)->where('root_cause_type_id', 1)->count();
        $hcns_reason_type_2_cnt = Ticket::all()->where('department_id', 1)->where('root_cause_type_id', 2)->count();
        $hcns_reason_type_3_cnt = Ticket::all()->where('department_id', 1)->where('root_cause_type_id', 3)->count();
        $hcns_reason_type_4_cnt = Ticket::all()->where('department_id', 1)->where('root_cause_type_id', 4)->count();
        $hcns_reason_type_5_cnt = Ticket::all()->where('department_id', 1)->where('root_cause_type_id', 5)->count();
        $hcns_reason_type_6_cnt = Ticket::all()->where('department_id', 1)->where('root_cause_type_id', 6)->count();
        $hcns_cnt = collect([$hcns_reason_type_1_cnt, $hcns_reason_type_2_cnt, $hcns_reason_type_3_cnt,
            $hcns_reason_type_4_cnt, $hcns_reason_type_5_cnt, $hcns_reason_type_6_cnt]);
        //$hcns_cnt = collect([0, 1, 2, 3, 4]);

        $sale_reason_type_1_cnt = Ticket::all()->where('department_id', 2)->where('root_cause_type_id', 1)->count();
        $sale_reason_type_2_cnt = Ticket::all()->where('department_id', 2)->where('root_cause_type_id', 2)->count();
        $sale_reason_type_3_cnt = Ticket::all()->where('department_id', 2)->where('root_cause_type_id', 3)->count();
        $sale_reason_type_4_cnt = Ticket::all()->where('department_id', 2)->where('root_cause_type_id', 4)->count();
        $sale_reason_type_5_cnt = Ticket::all()->where('department_id', 2)->where('root_cause_type_id', 5)->count();
        $sale_reason_type_6_cnt = Ticket::all()->where('department_id', 2)->where('root_cause_type_id', 6)->count();
        $sale_cnt = collect([$sale_reason_type_1_cnt, $sale_reason_type_2_cnt, $sale_reason_type_3_cnt,
            $sale_reason_type_4_cnt, $sale_reason_type_5_cnt, $sale_reason_type_6_cnt]);
        //$sale_cnt = collect([10, 11, 12, 13, 14]);

        $ketoan_reason_type_1_cnt = Ticket::all()->where('department_id', 3)->where('root_cause_type_id', 1)->count();
        $ketoan_reason_type_2_cnt = Ticket::all()->where('department_id', 3)->where('root_cause_type_id', 2)->count();
        $ketoan_reason_type_3_cnt = Ticket::all()->where('department_id', 3)->where('root_cause_type_id', 3)->count();
        $ketoan_reason_type_4_cnt = Ticket::all()->where('department_id', 3)->where('root_cause_type_id', 4)->count();
        $ketoan_reason_type_5_cnt = Ticket::all()->where('department_id', 3)->where('root_cause_type_id', 5)->count();
        $ketoan_reason_type_6_cnt = Ticket::all()->where('department_id', 3)->where('root_cause_type_id', 6)->count();
        $ketoan_cnt = collect([$ketoan_reason_type_1_cnt, $ketoan_reason_type_2_cnt, $ketoan_reason_type_3_cnt,
            $ketoan_reason_type_4_cnt, $ketoan_reason_type_5_cnt, $ketoan_reason_type_6_cnt]);
        //$ketoan_cnt = collect([20, 21, 22, 23, 24]);

        $ksnb_reason_type_1_cnt = Ticket::all()->where('department_id', 4)->where('root_cause_type_id', 1)->count();
        $ksnb_reason_type_2_cnt = Ticket::all()->where('department_id', 4)->where('root_cause_type_id', 2)->count();
        $ksnb_reason_type_3_cnt = Ticket::all()->where('department_id', 4)->where('root_cause_type_id', 3)->count();
        $ksnb_reason_type_4_cnt = Ticket::all()->where('department_id', 4)->where('root_cause_type_id', 4)->count();
        $ksnb_reason_type_5_cnt = Ticket::all()->where('department_id', 4)->where('root_cause_type_id', 5)->count();
        $ksnb_reason_type_6_cnt = Ticket::all()->where('department_id', 4)->where('root_cause_type_id', 6)->count();
        $ksnb_cnt = collect([$ksnb_reason_type_1_cnt, $ksnb_reason_type_2_cnt, $ksnb_reason_type_3_cnt,
            $ksnb_reason_type_4_cnt, $ksnb_reason_type_5_cnt, $ksnb_reason_type_6_cnt]);
        //$ksnb_cnt = collect([30, 31, 32, 33, 34]);

        $baotri_reason_type_1_cnt = Ticket::all()->where('department_id', 5)->where('root_cause_type_id', 1)->count();
        $baotri_reason_type_2_cnt = Ticket::all()->where('department_id', 5)->where('root_cause_type_id', 2)->count();
        $baotri_reason_type_3_cnt = Ticket::all()->where('department_id', 5)->where('root_cause_type_id', 3)->count();
        $baotri_reason_type_4_cnt = Ticket::all()->where('department_id', 5)->where('root_cause_type_id', 4)->count();
        $baotri_reason_type_5_cnt = Ticket::all()->where('department_id', 5)->where('root_cause_type_id', 5)->count();
        $baotri_reason_type_6_cnt = Ticket::all()->where('department_id', 5)->where('root_cause_type_id', 6)->count();
        $baotri_cnt = collect([$baotri_reason_type_1_cnt, $baotri_reason_type_2_cnt, $baotri_reason_type_3_cnt,
            $baotri_reason_type_4_cnt, $baotri_reason_type_5_cnt, $baotri_reason_type_6_cnt]);
        //$baotri_cnt = collect([40, 41, 42, 43, 44]);

        $sx_reason_type_1_cnt = Ticket::all()->where('department_id', 6)->where('root_cause_type_id', 1)->count();
        $sx_reason_type_2_cnt = Ticket::all()->where('department_id', 6)->where('root_cause_type_id', 2)->count();
        $sx_reason_type_3_cnt = Ticket::all()->where('department_id', 6)->where('root_cause_type_id', 3)->count();
        $sx_reason_type_4_cnt = Ticket::all()->where('department_id', 6)->where('root_cause_type_id', 4)->count();
        $sx_reason_type_5_cnt = Ticket::all()->where('department_id', 6)->where('root_cause_type_id', 5)->count();
        $sx_reason_type_6_cnt = Ticket::all()->where('department_id', 6)->where('root_cause_type_id', 6)->count();
        $sx_cnt = collect([$sx_reason_type_1_cnt, $sx_reason_type_2_cnt, $sx_reason_type_3_cnt,
            $sx_reason_type_4_cnt, $sx_reason_type_5_cnt, $sx_reason_type_6_cnt]);
        //$sx_cnt = collect([50, 51, 52, 53, 54]);

        $thumua_reason_type_1_cnt = Ticket::all()->where('department_id', 7)->where('root_cause_type_id', 1)->count();
        $thumua_reason_type_2_cnt = Ticket::all()->where('department_id', 7)->where('root_cause_type_id', 2)->count();
        $thumua_reason_type_3_cnt = Ticket::all()->where('department_id', 7)->where('root_cause_type_id', 3)->count();
        $thumua_reason_type_4_cnt = Ticket::all()->where('department_id', 7)->where('root_cause_type_id', 4)->count();
        $thumua_reason_type_5_cnt = Ticket::all()->where('department_id', 7)->where('root_cause_type_id', 5)->count();
        $thumua_reason_type_6_cnt = Ticket::all()->where('department_id', 7)->where('root_cause_type_id', 6)->count();
        $thumua_cnt = collect([$thumua_reason_type_1_cnt, $thumua_reason_type_2_cnt, $thumua_reason_type_3_cnt,
            $thumua_reason_type_4_cnt, $thumua_reason_type_5_cnt, $thumua_reason_type_6_cnt]);
        //$thumua_cnt = collect([60, 61, 62, 63, 64]);

        $kythuat_reason_type_1_cnt = Ticket::all()->where('department_id', 8)->where('root_cause_type_id', 1)->count();
        $kythuat_reason_type_2_cnt = Ticket::all()->where('department_id', 8)->where('root_cause_type_id', 2)->count();
        $kythuat_reason_type_3_cnt = Ticket::all()->where('department_id', 8)->where('root_cause_type_id', 3)->count();
        $kythuat_reason_type_4_cnt = Ticket::all()->where('department_id', 8)->where('root_cause_type_id', 4)->count();
        $kythuat_reason_type_5_cnt = Ticket::all()->where('department_id', 8)->where('root_cause_type_id', 5)->count();
        $kythuat_reason_type_6_cnt = Ticket::all()->where('department_id', 8)->where('root_cause_type_id', 6)->count();
        $kythuat_cnt = collect([$kythuat_reason_type_1_cnt, $kythuat_reason_type_2_cnt, $kythuat_reason_type_3_cnt,
            $kythuat_reason_type_4_cnt, $kythuat_reason_type_5_cnt, $kythuat_reason_type_6_cnt]);
        //$kythuat_cnt = collect([70, 71, 72, 73, 74]);

        $qlcl_reason_type_1_cnt = Ticket::all()->where('department_id', 9)->where('root_cause_type_id', 1)->count();
        $qlcl_reason_type_2_cnt = Ticket::all()->where('department_id', 9)->where('root_cause_type_id', 2)->count();
        $qlcl_reason_type_3_cnt = Ticket::all()->where('department_id', 9)->where('root_cause_type_id', 3)->count();
        $qlcl_reason_type_4_cnt = Ticket::all()->where('department_id', 9)->where('root_cause_type_id', 4)->count();
        $qlcl_reason_type_5_cnt = Ticket::all()->where('department_id', 9)->where('root_cause_type_id', 5)->count();
        $qlcl_reason_type_6_cnt = Ticket::all()->where('department_id', 9)->where('root_cause_type_id', 6)->count();
        $qlcl_cnt = collect([$qlcl_reason_type_1_cnt, $qlcl_reason_type_2_cnt, $qlcl_reason_type_3_cnt,
            $qlcl_reason_type_4_cnt, $qlcl_reason_type_5_cnt, $qlcl_reason_type_6_cnt]);
        //$qlcl_cnt = collect([80, 81, 82, 83, 84]);

        $kho_reason_type_1_cnt = Ticket::all()->where('department_id', 10)->where('root_cause_type_id', 1)->count();
        $kho_reason_type_2_cnt = Ticket::all()->where('department_id', 10)->where('root_cause_type_id', 2)->count();
        $kho_reason_type_3_cnt = Ticket::all()->where('department_id', 10)->where('root_cause_type_id', 3)->count();
        $kho_reason_type_4_cnt = Ticket::all()->where('department_id', 10)->where('root_cause_type_id', 4)->count();
        $kho_reason_type_5_cnt = Ticket::all()->where('department_id', 10)->where('root_cause_type_id', 5)->count();
        $kho_reason_type_6_cnt = Ticket::all()->where('department_id', 10)->where('root_cause_type_id', 6)->count();
        $kho_cnt = collect([$kho_reason_type_1_cnt, $kho_reason_type_2_cnt, $kho_reason_type_3_cnt,
            $kho_reason_type_4_cnt, $kho_reason_type_5_cnt, $kho_reason_type_6_cnt]);
        //$kho_cnt = collect([00, 91, 92, 93, 94]);


        return collect([$hcns_cnt, $sale_cnt, $ketoan_cnt, $ksnb_cnt, $baotri_cnt,
            $sx_cnt, $thumua_cnt, $kythuat_cnt, $qlcl_cnt, $kho_cnt]);
    }

    /**
     * Mark ticket completed
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function markTicketCompleted($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->ticket_status_id = $requestData->ticket_status_id;
        $ticket->mark_completed_comment = $requestData->mark_completed_comment;
        $ticket->save();
        $ticket = $ticket->fresh();
        event(new \App\Events\TicketAction($ticket, self::MARK_TICKET_COMPLETED));
    }

    /**
     * Effectiveness statistic
     * @param
     */
    public function allEffectivenessStatistic()
    {
        $high_cnt =  Ticket::all()->where('effectiveness_id', 1)->count();
        $medium_cnt =  Ticket::all()->where('effectiveness_id', 2)->count();
        $low_cnt =  Ticket::all()->where('effectiveness_id', 3)->count();

        return collect([$high_cnt, $medium_cnt, $low_cnt]);
        //return collect([24, 7, 55]);
    }

    /**
     * Effectiveness statistic with filter based on department
     * @param
     */
    public function allEffectivenessFilteredStatistic($requestData)
    {
        $department_id = $requestData->department_id;
        if(0 == $department_id) {
            $high_cnt =  Ticket::all()->where('effectiveness_id', 1)->count();
            $medium_cnt =  Ticket::all()->where('effectiveness_id', 2)->count();
            $low_cnt =  Ticket::all()->where('effectiveness_id', 3)->count();
        } else {
            $high_cnt =  Ticket::all()->where('department_id', $department_id)->where('effectiveness_id', 1)->count();
            $medium_cnt =  Ticket::all()->where('department_id', $department_id)->where('effectiveness_id', 2)->count();
            $low_cnt =  Ticket::all()->where('department_id', $department_id)->where('effectiveness_id', 3)->count();
        }

        return collect([$high_cnt, $medium_cnt, $low_cnt]);
        //return collect([24, 7, 55]);
    }

    /**
     * @return mixed
     */
    public function createdTicketsMothly()
    {
        return DB::table('tickets')
            ->select(DB::raw('count(*) as month, created_at'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();
    }

    /**
     * @return mixed
     */
    public function completedTicketsMothly()
    {
        return DB::table('tickets')
            ->select(DB::raw('count(*) as month, updated_at'))
            ->where('ticket_status_id', 2)
            ->groupBy(DB::raw('YEAR(updated_at), MONTH(updated_at)'))
            ->get();
    }
}
