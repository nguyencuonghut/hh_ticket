<?php

namespace App\Http\Controllers;

use App\Models\Prevention;
use Illuminate\Http\Request;
use App\Http\Requests\Prevention\StorePreventionRequest;
use App\Http\Requests\Prevention\UpdatePreventionRequest;
use App\Repositories\Prevention\PreventionRepositoryContract;

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

        return redirect()->route("tickets.show", $id);
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

        return redirect()->route("tickets.show", $ticket_id);
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

        return redirect()->route("tickets.show", $ticket_id);
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
        return redirect()->back();
    }
}
