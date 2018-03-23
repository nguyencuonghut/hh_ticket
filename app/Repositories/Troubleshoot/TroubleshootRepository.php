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
        $ticket = Ticket::findOrFail($ticket_id);
        $input = $requestData = array_merge(
            $requestData->all(),
            ['ticket_id' => $ticket_id,
                'creator_id' => $ticket->manager_id,
                'status' => false,
                'is_on_time' => false]
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
        $troubleshoot->status = ($requestData->status === 'Open') ? 0:1;
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
}
