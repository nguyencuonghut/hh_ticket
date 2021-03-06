<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Models\Activity;
use App\Models\ApproveResult;
use App\Models\Department;
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
            ->withDirectors($directors)
            ->withDepartments(Department::all()->pluck('name', 'id'));
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
            ->withResults(ApproveResult::all()->pluck('name', 'id'))
            ->withDepartments(Department::all()->pluck('name', 'id'));;
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
        ];
        $messages = [
            'evaluation_id.required' => 'Yêu cầu bạn PHẢI điền "Mức độ"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->evaluateTicket($id, $request);
        Session()->flash('flash_message', 'Xem xét mức độ SKPH thành công!');
        return redirect()->back()->with('tab', 'prevention');
    }

    /**
     * Update the root cause
     */
    public function updateRootCause(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'root_cause_type_id' => 'required',
            'root_cause' => 'required',
        ];
        $messages = [
            'root_cause_type_id.required' => 'Yêu cầu bạn PHẢI điền "Phân loại nguyên nhân"',
            'root_cause.required' => 'Yêu cầu bạn PHẢI điền "Nguyên nhân gốc"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->updateRootCause($id, $request);
        Session()->flash('flash_message', 'Cập nhật nguyên nhân gốc rễ thành công!');
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
            'effectiveness_comment' => 'required'
        ];
        $messages = [
            'effectiveness_id.required' => 'Yêu cầu bạn PHẢI điền "Hiệu quả"',
            'effectiveness_comment.required' => 'Yêu cầu bạn PHẢI điền "Ý kiến"',
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
        $tickets = Ticket::with(['creator', 'source', 'department', 'ticket_status'])->select(
            ['id', 'title', 'created_at', 'source_id', 'creator_id', 'department_id', 'ticket_status_id']
        )->orderBy('id', 'desc');
        return Datatables::of($tickets)
            ->addColumn('titlelink', function ($tickets) {
                return '<a href="tickets/' . $tickets->id . '" ">' . str_limit($tickets->title, 40) . '</a>';
            })
            ->editColumn('created_at', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
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
            })
            ->editColumn('ticket_status', function ($tickets) {
                return $tickets->ticket_status->name;
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

    /**
     * Request to approve troubleshoot action
     * @param $id
     * @return mixed
     */
    public function requestToApproveTroubleshoot(Request $request, $id)
    {
        $this->tickets->requestToApproveTroubleshoot($id, $request);
        Session()->flash('flash_message', 'Yêu cầu phê duyệt thành công!');
        return redirect()->back()->with('tab', 'troubleshoot');
    }

    /**
     * Approve  the troubleshoot actions
     */
    public function approveTroubleshoot(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'approve_troubleshoot_result_id' => 'required',
        ];
        $messages = [
            'approve_troubleshoot_result_id.required' => 'Yêu cầu bạn PHẢI điền "Kết quả duyệt"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->approveTroubleshoot($id, $request);
        Session()->flash('flash_message', 'Duyệt biện pháp khắc phục thành công!');
        return redirect()->back()->with('tab', 'troubleshoot');

    }

    /**
     * Assign preventer
     * @param $id
     * @return mixed
     */
    public function assignPreventer(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'assigned_preventer_id' => 'required',
        ];
        $messages = [
            'assigned_preventer_id.required' => 'Yêu cầu bạn PHẢI điền "Người phòng ngừa"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->assignPreventer($id, $request);
        Session()->flash('flash_message', 'Giao cho người đề xuất hành động phòng ngừa thành công!');
        return redirect()->back()->with('tab', 'prevention');
    }

    /**
     * Request to approve prevention actions
     * @param $id
     * @return mixed
     */
    public function requestToApprovePrevention(Request $request, $id)
    {
        $this->tickets->requestToApprovePrevention($id, $request);
        Session()->flash('flash_message', 'Yêu cầu phê duyệt thành công!');
        return redirect()->back()->with('tab', 'prevention');
    }

    /**
     * Approve  the prevention actions
     */
    public function approvePrevention(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'approve_prevention_result_id' => 'required',
        ];
        $messages = [
            'approve_prevention_result_id.required' => 'Yêu cầu bạn PHẢI điền "Kết quả duyệt"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->approvePrevention($id, $request);
        Session()->flash('flash_message', 'Duyệt biện pháp phòng ngừa thành công!');
        return redirect()->back()->with('tab', 'prevention');

    }

    /**
     * List all created ticket for each user
     */
    public function myCreatedData()
    {
        $tickets = Ticket::select(
            ['id', 'title', 'created_at', 'source_id', 'ticket_status_id']
        )->where('creator_id', \Auth::id())->orderBy('id', 'desc');
        return Datatables::of($tickets)
            ->addColumn('titlelink', function ($tickets) {
                return '<a href="../tickets/' . $tickets->id . '" ">' . $tickets->title . '</a>';

            })
            ->editColumn('issue_date', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('source_id', function ($tickets) {
                return $tickets->source->name;
            })
            ->editColumn('ticket_status', function ($tickets) {
                return $tickets->ticket_status_id;
            })->make(true);
    }

    /**
     * List all ticket that user has to confirm
     */
    public function myConfirmedData()
    {
        $tickets = Ticket::select(
            ['id', 'title', 'created_at', 'source_id', 'director_confirmation_result_id', 'ticket_status_id']
        )->where('director_id', \Auth::id())->orderBy('id', 'desc');
        return Datatables::of($tickets)
            ->addColumn('titlelink', function ($tickets) {
                return '<a href="../tickets/' . $tickets->id . '" ">' . $tickets->title . '</a>';

            })
            ->editColumn('issue_date', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('source_id', function ($tickets) {
                return $tickets->source->name;
            })
            ->addColumn('confirmation_result', function ($tickets) {
                return $tickets->director_confirmation_result->name;
            })
            ->addColumn('ticket_status_id', function ($tickets) {
                return $tickets->ticket_status_id;
            })->make(true);
    }

    /**
     * Mark ticket completed
     */
    public function markTicketCompleted(Request $request, $id)
    {
        //Validate the input value
        $rules = [
            'ticket_status_id' => 'required',
        ];
        $messages = [
            'ticket_status_id.required' => 'Yêu cầu bạn PHẢI điền "Trạng thái"',
        ];
        $this->validate($request, $rules, $messages);

        $this->tickets->markTicketCompleted($id, $request);
        Session()->flash('flash_message', 'Cập nhật trạng thái ticket thành công!');
        return redirect()->back()->with('tab', 'prevention');

    }

    /**
     * Apply filter for tickets
     */
    public function ticketStatisticFiltered(Request $request)
    {
        $allDepartmentTickets = $this->tickets->allDepartmentStatistic();
        $allReasonTickets = $this->tickets->allReasonStatisticFiltered($request);
        $allDepartmentStateTickets = $this->tickets->allDepartmentStateStatistic();
        $allDepartmentReasonTickets = $this->tickets->allDepartmentReasonStatistic($request);
        $allEffectivenessTickets = $this->tickets->allEffectivenessFilteredStatistic($request);
        $createdTicketsMonthly = $this->tickets->createdTicketsMothlyFiltered($request);
        $completedTicketsMonthly = $this->tickets->completedTicketsMothlyFiltered($request);
        $departments = Department::all()->pluck('name', 'id');
        if(0 == $request->department_id) { // All departments
            $department_name = 'Tất cả';
            $opened_tickets_cnt = Ticket::all()->where('ticket_status_id', '1')->count();
            $closed_tickets_cnt = Ticket::all()->where('ticket_status_id', '2')->count();
        } else {
            $department_name = Department::findOrFail($request->department_id)->name;
            $opened_tickets_cnt = Ticket::all()
                ->where('department_id', $request->department_id)
                ->count();
            $closed_tickets_cnt = Ticket::all()
                ->where('department_id', $request->department_id)
                ->where('ticket_status_id', '2')
                ->count();
        }
        return view('pages.dashboard', compact(
            'allDepartmentTickets',
            'allReasonTickets',
            'allDepartmentStateTickets',
            'allDepartmentReasonTickets',
            'allEffectivenessTickets',
            'createdTicketsMonthly',
            'completedTicketsMonthly',
            'departments',
            'department_name',
            'opened_tickets_cnt',
            'closed_tickets_cnt'
        ));
    }
}
