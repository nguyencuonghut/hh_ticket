<?php
namespace App\Repositories\Troubleshoot;

use App\Models\Ticket;
use App\Models\Troubleshoot;
use Illuminate\Support\Facades\Session;
use Gate;
use Datatables;
use Carbon;
use Auth;
use DB;

/**
 * Class TicketRepository
 * @package App\Repositories\Troubleshoot
 */
class TroubleshootRepository implements TroubleshootRepositoryContract
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
        return Troubleshoot::findOrFail($id);
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
                'pre_troubleshooter_id' => $requestData->troubleshooter_id,
                'creator_id' => \auth::id(),
                'status_id' => 1, // Status is Open
                'is_on_time' => true]
        );

        $troubleshoot = Troubleshoot::create($input);

        Session::flash('flash_message', 'Tạo hành động khắc phục thành công!');
        event(new \App\Events\TroubleshootAction($troubleshoot, self::CREATED));
    }

    /**
     * @param $id
     * @param $requestData
     * @return mixed
     */
    public function update($id, $requestData)
    {
        $troubleshoot = Troubleshoot::findOrFail($id);
        $troubleshoot->name = $requestData->name;
        $troubleshoot->deadline = $requestData->deadline;
        $troubleshoot->status_id = $requestData->status_id;
        if($requestData->status_id == 2){ // Action is finished
            $troubleshoot->finished_at = \Carbon\Carbon::now();
            $days_util_deadline = Carbon\Carbon::now()
                                            ->startOfDay()
                                            ->diffInDays(Carbon\Carbon::parse($troubleshoot->deadline), false);
            if($days_util_deadline >= 0) {
                $troubleshoot->is_on_time = true;
            } else {
                $troubleshoot->is_on_time = false;
            }
        } else {
            $troubleshoot->is_on_time = true;
        }
        $troubleshoot->save();

        Session::flash('flash_message', 'Sửa hành động khắc phục thành công!');
        event(new \App\Events\TroubleshootAction($troubleshoot, self::UPDATED));
        return $troubleshoot->ticket_id;
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
        $troubleshoot = Troubleshoot::findOrFail($id);
        if(\Auth::id() == $troubleshoot->troubleshooter_id) {
            $troubleshoot->status_id = 2; //Status: Closed
            $troubleshoot->finished_at = \Carbon\Carbon::now();
            $days_util_deadline = Carbon\Carbon::now()
                                            ->startOfDay()
                                            ->diffInDays(Carbon\Carbon::parse($troubleshoot->deadline), false);
            if($days_util_deadline >= 0) {
                $troubleshoot->is_on_time = true;
            } else {
                $troubleshoot->is_on_time = false;
            }
            $troubleshoot->save();
            Session()->flash('flash_message', 'Đã hoàn thành một hành động khắc phục!');
        }else{
            Session()->flash('flash_message_warning', 'Bạn không có quyền đánh dấu hoàn thành!');
        }
        event(new \App\Events\TroubleshootAction($troubleshoot, self::COMPLETED));
        return $troubleshoot->ticket_id;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function updateAssign($id, $requestData)
    {
        $troubleshoot = Troubleshoot::findOrFail($id);
        $troubleshoot->pre_troubleshooter_id = $troubleshoot->troubleshooter_id;
        $troubleshoot->troubleshooter_id = $requestData->troubleshooter_id;
        $troubleshoot->save();
        event(new \App\Events\TroubleshootAction($troubleshoot, self::UPDATED_ASSIGN));
    }
}
