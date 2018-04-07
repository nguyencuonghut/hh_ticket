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
                'assigned_troubleshooter_id' => $requestData->director_id,
                'assigned_preventer_id' => $requestData->director_id,
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
        $ticket->root_cause_type_id = $requestData->root_cause_type_id;
        $ticket->evaluation_id = $requestData->evaluation_id;
        $ticket->root_cause = $requestData->root_cause;
        $ticket->save();
        $ticket = $ticket->fresh();
        event(new \App\Events\TicketAction($ticket, self::REQ_APPROVE_ROOT_CAUSE));
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
            event(new \App\Events\TicketAction($ticket, self::PREVENTION_APPROVED));
        } else {
            event(new \App\Events\TicketAction($ticket, self::PREVENTION_REJECTED));
        }
    }
}
