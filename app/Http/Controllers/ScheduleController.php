<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }

    public function saveScheduleData(Request $request, $sheduleID)
    {
        $schedule = Schedule::findOrFail($sheduleID);
        $data['data'] = $withOutFist = $previousRecord = Schedule::where('client_id', $schedule->client_id)
        ->where('project_id', $schedule->project_id)
        ->where('id', '<', $schedule->id)->get();

        if ($withOutFist->whereNotNull('amount_paid')->whereNotNull('installments')->count() <= 0) {
            $scheduleFirst = Schedule::whereNull('installments')->find($sheduleID - 1);
            if (!$scheduleFirst) {
                return response()->json(['success' => false, 'data' => $data, 'message' => __('Please update previous record first.')]);
            }
        }

        $data['total_sum'] = $totalPreviouslyPaid = $previousRecord->sum('amount_paid');
        $data['current_remaining'] = $totalCurrentRemaining = $schedule->total_amount - ($totalPreviouslyPaid + $request->amount_paid);

        if ($totalCurrentRemaining < 0) {
            return response()->json(['success' => false, 'data' => $data, 'message' => __('Paid amount should be not greater then total amount.')]);
        }

        $schedule->remaining_amount = $totalCurrentRemaining;
        $schedule->amount_paid = $request->amount_paid;
        $schedule->save();

        return response()->json(['success' => true, 'schedule' => $schedule, 'message' => __('The data has been saved successfully.')]);
    }
}
