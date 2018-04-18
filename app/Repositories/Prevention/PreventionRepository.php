<?php
namespace App\Repositories\Prevention;

use App\Models\Ticket;
use App\Models\Prevention;
use Illuminate\Support\Facades\Session;
use Gate;
use Datatables;
use Carbon;
use Auth;
use DB;

/**
 * Class TicketRepository
 * @package App\Repositories\Prevention
 */
class PreventionRepository implements PreventionRepositoryContract
{
    const CREATED = 'created';
    const UPDATED = 'updated';
    const COMPLETED = 'completed';
    const UPDATED_ASSIGN = 'updated_assign';

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return Prevention::findOrFail($id);
    }

    /**
     * @param $requestData
     * @return static
     */
    public function create($ticket_id, $requestData)
    {
        $input = $requestData = array_merge(
            $requestData->all(),
            ['ticket_id' => $ticket_id,
                'pre_preventor_id' => $requestData->preventor_id,
                'creator_id' => \Auth::id(),
                'status_id' => 1, // Status is Open
                'is_on_time' => true]
        );

        $prevention = Prevention::create($input);

        Session::flash('flash_message', 'Tạo hành động phòng ngừa thành công!');
        event(new \App\Events\PreventionAction($prevention, self::CREATED));
    }

    /**
     * @param $id
     * @param $requestData
     * @return mixed
     */
    public function update($id, $requestData)
    {
        $prevention = Prevention::findOrFail($id);
        $prevention->name = $requestData->name;
        $prevention->budget = $requestData->budget;
        $prevention->where = $requestData->where;
        $prevention->when = $requestData->when;
        $prevention->how = $requestData->how;
        $prevention->status_id = $requestData->status_id;
        if($requestData->status_id == 2){ // Action is finished
            $prevention->finished_at = \Carbon\Carbon::now();
            $days_util_deadline = Carbon\Carbon::now()
                ->startOfDay()
                ->diffInDays(Carbon\Carbon::parse($prevention->when), false);
            if($days_util_deadline >= 0) {
                $prevention->is_on_time = true;
            } else {
                $prevention->is_on_time = false;
            }

            //Update the flag of ticket
            $this->updateTicketState($prevention->ticket_id);
        } else {
            $prevention->finished_at = NULL;
            $prevention->is_on_time = true;
        }
        $prevention->save();

        Session::flash('flash_message', 'Sửa hành động phòng ngừa thành công!');
        event(new \App\Events\PreventionAction($prevention, self::UPDATED));
        return $prevention->ticket_id;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($request, $id)
    {
    }

    /**
     * @param $id
     * @return mixed
     */
    public function markComplete($id)
    {
        $prevention = Prevention::findOrFail($id);
        if(\Auth::id() == $prevention->preventor_id) {
            $prevention->status_id = 2; //Status: Closed
            $prevention->finished_at = \Carbon\Carbon::now();
            $days_util_deadline = Carbon\Carbon::now()
                ->startOfDay()
                ->diffInDays(Carbon\Carbon::parse($prevention->when), false);
            if($days_util_deadline >= 0) {
                $prevention->is_on_time = true;
            } else {
                $prevention->is_on_time = false;
            }
            $prevention->save();

            //Update the flag of ticket
            $this->updateTicketState($prevention->ticket_id);

            Session()->flash('flash_message', 'Đã hoàn thành một hành động phòng ngừa!');
        }else{
            Session()->flash('flash_message_warning', 'Bạn không có quyền đánh dấu hoàn thành!');
        }
        event(new \App\Events\PreventionAction($prevention, self::COMPLETED));
        return $prevention->ticket_id;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function updateAssign($id, $requestData)
    {
        $prevention = Prevention::findOrFail($id);
        $prevention->pre_preventor_id = $prevention->preventor_id;
        $prevention->preventor_id = $requestData->preventor_id;
        $prevention->save();
        event(new \App\Events\PreventionAction($prevention, self::UPDATED_ASSIGN));
    }

    /**
     * @param $id
     * @return mixed
     */
    private function updateTicketState($ticket_id)
    {
        $is_all_completed = true;
        //Find all the actions according to description id
        $actions = Prevention::all()->where('ticket_id', $ticket_id);
        foreach ($actions as $action) {
            if('Open' == $action->status->name){
                $is_all_completed = false;
            }
        }
        if(true == $is_all_completed) {
            $ticket = Ticket::findOrFail($ticket_id);
            $ticket->state_id = 5; //Phiếu CAR đã hoàn thành hành động KPPN
            $ticket->save();
        }
    }
}
