<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Models\Activity;
use App\Models\ApproveResult;
use App\Models\Effectiveness;
use App\Models\Evaluation;
use App\Models\Prevention;
use App\Models\Responsibility;
use App\Models\RootCauseType;
use App\Models\Source;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\Troubleshoot;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Ticket\TicketRepositoryContract;
use Datatables;
use Carbon;
use Illuminate\Support\Facades\DB;


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
        return view('tickets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $directors = User::whereHas(
            'roles', function($q){
                    $q->where('name', 'director');
                    })->pluck('name', 'id');

        return view('tickets.create')
            ->withSources(Source::all()->pluck('name', 'id'))
            ->withUsers(User::all()->pluck('name', 'id'))
            ->withDirectors($directors);
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
        $directors = User::whereHas(
            'roles', function($q){
            $q->where('name', 'director');
        })->pluck('name', 'id');
        return view('tickets.show')
            ->withTicket($ticket)
            ->withSources(Source::all()->pluck('name', 'id'))
            ->withDirectors($directors)
            ->withUsers(User::all()->pluck('name', 'id'))
            ->withResponsibilities(Responsibility::all()->pluck('name', 'id'))
            ->withTroubleshoots(Troubleshoot::all()->where('ticket_id', $id))
            ->withStatuses(Status::all()->pluck('name', 'id'))
            ->withActivities(Activity::all()->where('source_id', $ticket->id))
            ->withEvaluations(Evaluation::all()->pluck('name', 'id'))
            ->withRootCauseTypes($this->tickets->getAllRootCauseTypesWithDescription())
            ->withPreventions(Prevention::all()->where('ticket_id', $id))
            ->withEffectivenesses(Effectiveness::all()->pluck('name', 'id'))
            ->withResults(ApproveResult::all()->pluck('name', 'id'));
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
     * Director confirm the ticket
     * @param $id
     * @return mixed
     */
    public function directorConfirm(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'director_confirmation_result_id' => 'required',
        ];
        $messages = [
            'director_confirmation_result_id.required' => 'Yêu cầu bạn PHẢI điền "Kết quả xác nhận"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->directorConfirm($id, $request);
        Session()->flash('flash_message', 'Xác nhận thành công!');
        return redirect()->back();
    }

    /**
     * Director confirm the ticket
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
        return redirect()->back()->with('tab', 'troubleshoot');
    }

    /**
     * Director confirm the ticket
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
        return redirect()->back()->with('tab', 'prevention');
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
            'evaluation_result_id' => 'required',
        ];
        $messages = [
            'evaluation_result_id.required' => 'Yêu cầu bạn PHẢI điền kết quả phê duyệt',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->rootCauseApprove($id, $request);
        Session()->flash('flash_message', 'Duyệt thành công!');
        return redirect()->back()->with('tab', 'prevention');
    }

    /**
     * Asset the effectiveness of the ticket
     * @param $id
     * @return mixed
     */
    public function assetEffectiveness(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'effectiveness_id' => 'required',
        ];
        $messages = [
            'effectiveness_id.required' => 'Yêu cầu bạn PHẢI điền "Hiệu quả"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->assetEffectiveness($id, $request);
        Session()->flash('flash_message', 'Đánh giá hiệu quả thành công!');
        return redirect()->back()->with('tab', 'prevention');
    }

    /**
     * Data table for all tickets
     * @return mixed
     */
    public function anyData()
    {
        $tickets = Ticket::with(['creator', 'source', 'department'])->select(
            ['id', 'title', 'created_at', 'deadline', 'source_id', 'creator_id', 'department_id']
        )->orderBy('id', 'desc');
        return Datatables::of($tickets)
            ->addColumn('titlelink', function ($tickets) {
                return '<a href="tickets/' . $tickets->id . '" ">' . str_limit($tickets->title, 40) . '</a>';
            })
            ->editColumn('created_at', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('deadline', function ($tickets) {
                return $tickets->deadline ? with(new Carbon($tickets->deadline))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('source', function ($tickets) {
                return $tickets->source->name;
            })
            ->editColumn('name', function ($tickets) {
                return $tickets->creator->name;
            })
            ->editColumn('department', function ($tickets) {
                return $tickets->department->name;
            })->make(true);
    }

    /**
     * Assign troubleshooter
     * @param $id
     * @return mixed
     */
    public function assignTroubleshooter(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'assigned_troubleshooter_id' => 'required',
        ];
        $messages = [
            'assigned_troubleshooter_id.required' => 'Yêu cầu bạn PHẢI điền "Người khắc phục"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->assignTroubleshooter($id, $request);
        Session()->flash('flash_message', 'Giao cho người khắc phục thành công!');
        return redirect()->back()->with('tab', 'troubleshoot');
    }
}
