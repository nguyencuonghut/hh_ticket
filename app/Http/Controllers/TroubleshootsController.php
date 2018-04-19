<?php

namespace App\Http\Controllers;

use App\Models\Troubleshoot;
use Illuminate\Http\Request;
use App\Http\Requests\Troubleshoot\StoreTroubleshootRequest;
use App\Http\Requests\Troubleshoot\UpdateTroubleshootRequest;
use App\Repositories\Troubleshoot\TroubleshootRepositoryContract;
use Datatables;
use Carbon;

class TroubleshootsController extends Controller
{
    protected $request;
    protected $actions;

    public function __construct(
        TroubleshootRepositoryContract $actions
    )
    {
        $this->actions = $actions;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTroubleshootRequest $request, $id)
    {
        $this->actions->create($id, $request);

        return redirect()->route("tickets.show", $id)->with('tab', 'troubleshoot');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTroubleshootRequest $request, $id)
    {
        $ticket_id = $this->actions->update($id, $request);

        return redirect()->route("tickets.show", $ticket_id)->with('tab', 'troubleshoot');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markComplete($id)
    {
        $ticket_id = $this->actions->markComplete($id);

        return redirect()->route("tickets.show", $ticket_id)->with('tab', 'troubleshoot');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAssign(Request $request,$id)
    {
        //Validate the input value
        $rules = [
            'troubleshooter_id' => 'required',
        ];
        $messages = [
            'troubleshooter_id.required' => 'Yêu cầu bạn PHẢI điền "Người thực hiện"',
        ];
        $this->validate($request, $rules, $messages);

        $this->actions->updateAssign($id, $request);
        Session()->flash('flash_message', 'Cập nhật thành công!');
        return redirect()->back()->with('tab', 'troubleshoot');
    }

    /**
     * List all the actions for each user
     */

    public function myActionsData()
    {
        $actions = Troubleshoot::select(
            ['id', 'name', 'troubleshooter_id', 'ticket_id', 'status_id', 'deadline','is_on_time']
        )->where('troubleshooter_id', \Auth::id())->orderBy('id', 'desc');
        return Datatables::of($actions)
            ->editColumn('name', function ($actions) {
                if($actions->is_on_time == true) {
                    return '<span><i class="fa fa-check-circle" style="color:green"></i></span>' .  ' ' . $actions->name;
                } else {
                    return '<span><i class="fa fa-clock-o" style="color:red"></i></span>' .  ' '  . $actions->name;
                }
            })
            ->editColumn('troubleshooter_id', function ($actions) {
                return $actions->troubleshooter->name;
            })
            ->editColumn('status', function ($actions) {
                return $actions->status->name;
            })
            ->editColumn('deadline', function ($actions) {
                return $actions->deadline ? with(new Carbon($actions->deadline))
                    ->format('d/m/Y') : '';
            })
            ->add_column('edit', '
                <a href="{{ route(\'troubleshoots.edit\', $id) }}" class="btn btn-warning btn-xs" ><i class="fa fa-edit"></i></a>')
            ->add_column('markCompleted', '
                <form action="{{ route(\'troubleshootMarkComplete\', $id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field(\'PATCH\') }}
                    <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i></button>
                </form>
            ')
            ->make(true);
    }
}
