<?php

namespace App\Http\Controllers;

use App\Models\Troubleshoot;
use Illuminate\Http\Request;
use App\Http\Requests\Troubleshoot\StoreTroubleshootRequest;
use App\Http\Requests\Troubleshoot\UpdateTroubleshootRequest;
use App\Repositories\Troubleshoot\TroubleshootRepositoryContract;

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
    public function update(UpdateTroubleshootRequest $request, $id)
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
        $troubleshoot = Troubleshoot::findOrFail($id);
        if(\Auth::id() == $troubleshoot->troubleshooter_id) {
            $troubleshoot->status = true;
            $troubleshoot->is_on_time = (strtotime($troubleshoot->deadline .  "+ 1 days") >= time()) ? true:false;
            $troubleshoot->save();

            Session()->flash('flash_message', 'Đã hoàn thành một hành động khắc phục!');
            return redirect()->route("tickets.show", $troubleshoot->ticket_id);
        }else{
            Session()->flash('flash_message_warning', 'Bạn không có quyền đánh dấu hoàn thành!');
            return redirect()->route("tickets.show", $troubleshoot->ticket_id);
        }
    }
}