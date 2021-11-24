<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\WorkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\View\View;

class WorkRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() : View
    {
        abort_if(Gate::denies('equipment_access'), 403);

        $workRequests = auth()->user()->workRequests;

        $data = [
            'workRequests' => $workRequests
        ];

        return view('work_requests.index', $data);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkRequest  $workRequest
     * @return \Illuminate\Http\Response
     */
    public function show(WorkRequest $workRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkRequest  $workRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkRequest $workRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkRequest  $workRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkRequest $workRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkRequest  $workRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkRequest $workRequest)
    {
        //
    }
}
