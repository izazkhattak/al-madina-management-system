<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectPlan;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('Reports.index', compact('projects'));
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
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }

    public function getProjectPlans(Request $request) {
        $projectID = $request->input('project_id');
        $projectPlans = ProjectPlan::where('project_id', $projectID)->get();
        // $html = '<option value="">Please select</option>';
        $html = '';
        foreach ($projectPlans as $item) {
            $html .= "<option value='$item->id'>" . number_format($item->total_amount, 2) . "</option>";
        }
        return response()->json(['success'=> true, 'html'=> $html]);
    }


    public function getClients(Request $request) {
        $projectPlanID = $request->input('project_plan_id');
        $clients = Client::where('project_plan_id', $projectPlanID)->get();
        $html = '';
        foreach ($clients as $item) {
            $html .= "<option value='$item->id'>$item->name</option>";
        }
        return response()->json(['success'=> true, 'html'=> $html]);
    }

    public function getReports(Request $request) {
        $clientID = $request->input('client_id');
        $projectID = $request->input('project_id');
        $projectPlanID = $request->input('project_plan_id');

        $reports = Report::where(['client_id'=> $clientID, 'project_id'=> $projectID])->get();

        return response()->json(['success'=> true, 'data'=> $reports]);

    }
}
