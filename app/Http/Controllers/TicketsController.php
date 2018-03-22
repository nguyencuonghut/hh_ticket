<?php

namespace App\Http\Controllers;

use App\Models\Source;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|unique:tickets',
            'deadline' => 'required',
            'source_id' => 'required',
            'what' => 'required',
            'why' => 'required',
            'who' => 'required',
            'where' => 'required',
            'how_1' => 'required',
            'how_2' => 'required',
            'manager_id' => 'required',
        ];

        $messages = [
            'title.required' => 'Yêu cầu bạn PHẢI điền "Tiêu Đề"',
            'title.unique' => '"Tiêu Đề" đã tồn tại. Vui lòng chọn "Tiêu Đề" khác',
            'deadline.required' => 'Yêu cầu bạn PHẢI điền "Thời Hạn"',
            'source_id.required' => 'Yêu cầu bạn PHẢI điền "Nguồn Gốc"',
            'what.required' => 'Yêu cầu bạn PHẢI điền "Cái gì đã xảy ra?"',
            'why.required' => 'Yêu cầu bạn PHẢI điền "Tại sao đây là một vấn đề?"',
            'who.required' => 'Yêu cầu bạn PHẢI điền "Ai phát hiện ra?"',
            'when.required' => 'Yêu cầu bạn PHẢI điền "Nó xảy ra khi nào?"',
            'where.required' => 'Yêu cầu bạn PHẢI điền "Phát hiện ra ở đâu?"',
            'how_1.required' => 'Yêu cầu bạn PHẢI điền "Bằng cách nào?"',
            'how_2.required' => 'Yêu cầu bạn PHẢI điền "Có bao nhiêu sự không phù hợp?"',
            'manager_id.required' => 'Yêu cầu bạn PHẢI điền "Trưởng bộ phận (nơi xảy ra SKPH)"',
        ];
        $this->validate($request, $rules, $messages);

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
    public function update(Request $request, $id)
    {
        //
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
}
