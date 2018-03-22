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
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($request, $id)
    {
    }
}
