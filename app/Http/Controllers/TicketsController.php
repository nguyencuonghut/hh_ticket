<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Models\Activity;
use App\Models\Evaluation;
use App\Models\Responsibility;
use App\Models\RootCauseType;
use App\Models\Source;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\Troubleshoot;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Ticket\TicketRepositoryContract;


class TicketsController extends Controller
{
    protected $request;
    protected $tickets;

    public function __construct(
        TicketRepositoryContract $tickets
    )
    {
        $this->tickets = $tickets;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create')
            ->withSources(Source::all()->pluck('name', 'id'))
            ->withUsers(User::all()->pluck('name', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        $getInsertedId = $this->tickets->create($request);

        return redirect()->route("tickets.show", $getInsertedId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('tickets.show')
            ->withTicket($ticket)
            ->withSources(Source::all()->pluck('name', 'id'))
            ->withUsers(User::all()->pluck('name', 'id'))
            ->withResponsibilities(Responsibility::all()->pluck('name', 'id'))
            ->withTroubleshoots(Troubleshoot::all()->where('ticket_id', $id))
            ->withStatuses(Status::all()->pluck('name', 'id'))
            ->withActivities(Activity::all()->where('source_id', $ticket->id))
            ->withEvaluations(Evaluation::all()->pluck('name', 'id'))
            ->withRootCauseTypes($this->tickets->getAllRootCauseTypesWithDescription());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateTicketRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketRequest $request, $id)
    {
        $this->tickets->update($id, $request);
        Session()->flash('flash_message', 'Ticket được cập nhật thành công');
        return redirect()->route("tickets.show", $id);
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Manager confirm the ticket
     * @param $id
     * @return mixed
     */
    public function managerConfirm(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'manager_confirmation_result' => 'required',
        ];
        $messages = [
            'manager_confirmation_result.required' => 'Yêu cầu bạn PHẢI điền "Kết quả xác nhận"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->managerConfirm($id, $request);
        Session()->flash('flash_message', 'Xác nhận thành công!');
        return redirect()->back();
    }

    /**
     * Manager confirm the ticket
     * @param $id
     * @return mixed
     */
    public function setResponsibility(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'responsibility_id' => 'required',
        ];
        $messages = [
            'responsibility_id.required' => 'Yêu cầu bạn PHẢI điền "Trách nhiệm"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->setResponsibility($id, $request);
        Session()->flash('flash_message', 'Xác định trách nhiệm thành công!');
        return redirect()->back();
    }

    /**
     * Manager confirm the ticket
     * @param $id
     * @return mixed
     */
    public function evaluateTicket(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'evaluation_id' => 'required',
            'root_cause_type_id' => 'required',
            'root_cause' => 'required',
            'root_cause_approver_id' => 'required',
        ];
        $messages = [
            'evaluation_id.required' => 'Yêu cầu bạn PHẢI điền "Mức độ"',
            'root_cause_type_id.required' => 'Yêu cầu bạn PHẢI điền "Phân loại nguyên nhân"',
            'root_cause.required' => 'Yêu cầu bạn PHẢI điền "Nguyên nhân gốc"',
            'root_cause_approver_id.required' => 'Yêu cầu bạn PHẢI điền "Người phê duyệt"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->evaluateTicket($id, $request);
        Session()->flash('flash_message', 'Xem xét mức độ SKPH thành công!');
        return redirect()->back();
    }

    /**
     * Approver confirm the root cause
     * @param $id
     * @return mixed
     */
    public function rootCauseApprove(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'evaluation_result' => 'required',
        ];
        $messages = [
            'evaluation_result.required' => 'Yêu cầu bạn PHẢI điền kết quả phê duyệt',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->rootCauseApprove($id, $request);
        Session()->flash('flash_message', 'Duyệt thành công!');
        return redirect()->back();
    }
}
