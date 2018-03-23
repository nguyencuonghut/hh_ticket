<?php
namespace App\Repositories\Ticket;

use App\Models\Ticket;
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
    const MANAGER_APPROVED = 'manager_approved';
    const MANAGER_REJECTED = 'manager_rejected';

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
                'image_path' => $filename,]
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
     * Manager confirm the ticket
     * @param  \Illuminate\Http\Request  $requestData
     * @param $id
     * @return mixed
     */
    public function managerConfirm($id, $requestData)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->manager_confirmation_result = $requestData->manager_confirmation_result;
        $ticket->manager_confirmation_comment = $requestData->manager_confirmation_comment;
        $ticket->save();
        $ticket = $ticket->fresh();
        if('Đồng ý' == $requestData->manager_confirmation_result){
            event(new \App\Events\TicketAction($ticket, self::MANAGER_APPROVED));
        } else {
            event(new \App\Events\TicketAction($ticket, self::MANAGER_REJECTED));
        }
    }
}
