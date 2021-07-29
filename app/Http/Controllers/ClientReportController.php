<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientReport;
use App\Models\Project;
use App\Models\ProjectPlan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClientReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('ClientReports.index', compact('projects'));
    }

    public function getProjectPlans(Request $request) {
        $projectID = $request->input('project_id');
        $projectPlans = ProjectPlan::where('project_id', $projectID)->get();
        $html = '<option value="">Please select a plan</option>';
        foreach ($projectPlans as $item) {
            $html .= "<option value='$item->id'>" . $item->installment_years . " Year's" . "</option>";
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
        $clientID = $request->input('client_id');
        $projectID = $request->input('project_id');
        $projectPlanID = $request->input('project_plan_id');

        return DataTables::of(ClientReport::where(['client_id'=> $clientID, 'project_id'=> $projectID]))
                    ->addIndexColumn()
                    ->addColumn('name', function ($row) {
                        $name = $row->client->cnic . "/" . $row->client->name;
                        return $name;
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
