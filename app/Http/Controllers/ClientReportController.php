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
        $clientData = Client::where('id', $clientID)->first();
        $reportsData2 = ClientReport::where(['client_id'=> $clientID, 'project_id'=> $projectID])->get()->toarray();
        $reportsData1[] = ["id" => 0 ,
                         "client_id" => $clientData['id'] ,
                         "due_amount" => $clientData['total_amount'] ,
                         "paid" => $clientData['down_payment'] ,
                         "due_date" => $clientData['due_date'] ,
                         "paid_on" => $clientData['due_date'] ,
                         "out_stand" => $clientData['total_amount'] -$clientData['down_payment'],
                         "sur_charge" => "0.00" ,
                         "created_at" => $clientData['created_at'] ,
                         "updated_at" => $clientData['updated_at']];
        $allReport = array_merge($reportsData1,$reportsData2);
       
        return DataTables::of($allReport,$clientData)
                    ->addIndexColumn()
                    ->addColumn('name', function ($row) use ($clientData) {
                        $name = $clientData['name'];
                        return $name;
                    })
                      ->addColumn('out_stand', function ($row) {

                        return number_format($row['out_stand']);
                    })
                      ->addColumn('paid', function ($row) {

                        return number_format($row['paid']);
                    })
                      ->addColumn('sur_charge', function ($row) {

                        return number_format($row['sur_charge']);
                    })                   
                    ->make(true);
    }
}
