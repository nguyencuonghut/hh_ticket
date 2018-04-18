<?php

namespace App\Http\Controllers;

use App\Models\Prevention;
use Illuminate\Http\Request;
use App\Http\Requests\Prevention\StorePreventionRequest;
use App\Http\Requests\Prevention\UpdatePreventionRequest;
use App\Repositories\Prevention\PreventionRepositoryContract;
use Datatables;
use Carbon;

class PreventionsController extends Controller
{
    protected $request;
    protected $actions;

    public function __construct(
        PreventionRepositoryContract $actions
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
    public function store(StorePreventionRequest $request, $id)
    {
        $this->actions->create($id, $request);

        return redirect()->route("tickets.show", $id)->with('tab', 'prevention');
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
    public function update(UpdatePreventionRequest $request, $id)
    {
        $ticket_id = $this->actions->update($id, $request);

        return redirect()->route("tickets.show", $ticket_id)->with('tab', 'prevention');
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

        return redirect()->route("tickets.show", $ticket_id)->with('tab', 'prevention');
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
            'preventor_id' => 'required',
        ];
        $messages = [
            'preventor_id.required' => 'Yêu cầu bạn PHẢI điền "Người thực hiện"',
        ];
        $this->validate($request, $rules, $messages);

        $this->actions->updateAssign($id, $request);
        Session()->flash('flash_message', 'Cập nhật thành công!');
        return redirect()->back()->with('tab', 'prevention');
    }

    /**
     * List all prevention actions for each user
     */
    public function myActionsData()
    {
        $actions = Prevention::select(
            ['id', 'name', 'budget', 'preventor_id', 'ticket_id', 'status_id', 'when', 'is_on_time']
        )->where('preventor_id', \Auth::id());
        return Datatables::of($actions)
            ->addColumn('name', function ($actions) {
                if($actions->is_on_time == true) {
                    return '<span><i class="fa fa-check-circle" style="color:green"></i></span>' .  ' ' . $actions->name;
                } else {
                    return '<span><i class="fa fa-clock-o" style="color:red"></i></span>' .  ' '  . $actions->name;
                }
            })
            ->editColumn('preventor_id', function ($actions) {
                return $actions->preventor->name;
            })
            ->editColumn('status', function ($actions) {
                return $actions->status->name;
            })
            ->editColumn('when', function ($actions) {
                return $actions->when ? with(new Carbon($actions->when))
                    ->format('d/m/Y') : '';
            })
            ->add_column('edit', '
                <a href="{{ route(\'preventions.edit\', $id) }}" class="btn btn-warning btn-xs" ><i class="fa fa-edit"></i></a>')
            ->add_column('markCompleted', '
                <form action="{{ route(\'preventionMarkComplete\', $id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field(\'PATCH\') }}
                    <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i></button>
                </form>                ')
            ->make(true);
    }
}
