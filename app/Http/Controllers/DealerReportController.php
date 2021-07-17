<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectPlan;
use App\Models\DealerReport;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DealerReportController extends Controller
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
     * @param  \App\Models\DealerReport  $report
     * @return \Illuminate\Http\Response
     */
    public function show(DealerReport $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DealerReport  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(DealerReport $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DealerReport  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DealerReport $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DealerReport  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(DealerReport $report)
    {
        //
    }

    public function getProjectPlans(Request $request) {
        $projectID = $request->input('project_id');
        $projectPlans = ProjectPlan::where('project_id', $projectID)->get();
        $html = '<option value="">Please select a plan</option>';
        foreach ($projectPlans as $item) {
            $html .= "<option value='$item->id'>" . $item->installment_years . " Year's - " . number_format($item->total_amount) . "</option>";
        }
        return response()->json(['success'=> true, 'html'=> $html]);
    }


    public function getClients(Request $request) {
        $projectPlanID = $request->input('project_plan_id');
        $clients = Client::where('project_plan_id', $projectPlanID)->get();
        $html = '<option value="">Please select a Client</option>';
        foreach ($clients as $item) {
            $html .= "<option value='$item->id'>$item->name / $item->cnic</option>";
        }
        return response()->json(['success'=> true, 'html'=> $html]);
    }

    public function getReports(Request $request) {
        // return $request;
        $clientID = $request->input('client_id');
        $projectID = $request->input('project_id');
        $projectPlanID = $request->input('project_plan_id');

        return DataTables::of(DealerReport::where(['client_id'=> $clientID, 'project_id'=> $projectID]))
                    ->addIndexColumn()
                    ->addColumn('name', function ($row) {
                        $name = $row->client->cnic . "/" . $row->client->name;
                        return $name;
                    })
                     ->addColumn('due_amount', function ($row) {

                        return number_format($row->due_amount);
                    })
                      ->addColumn('out_stand', function ($row) {

                        return number_format($row->out_stand);
                    })
                      ->addColumn('paid', function ($row) {

                        return number_format($row->paid);
                    })
                      ->addColumn('sur_charge', function ($row) {

                        return number_format($row->sur_charge);
                    })
                    ->make(true);
    }
}
