<?php

namespace App\Http\Controllers;

use App\Models\ClientReport;
use App\Models\Project;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AllClientReportController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('AllClientReports.index', compact('projects'));
    }

    public function reports(Request $request)
    {
        $projectID = $request->input('project_id');

        $projects = ClientReport::where(['project_id' => $projectID])
            ->groupBy('client_id')
            ->leftJoin('clients', 'clients.id', '=', 'client_reports.client_id')
            ->selectRaw("cnic, name, due_amount as total_amount, SUM(paid) as total_paid , clients.down_payment as down_paid")->get();

        $totalAmountSum = $projects->sum('total_amount');
        $totalPaidSum = $projects->sum('total_paid') + $projects->sum('down_paid');

        $data = array(
            'total_amount' => $totalAmountSum,
            'total_paid' => $totalPaidSum
        );

        return DataTables::of($projects)
            ->addIndexColumn()
            ->with('boxes_data', $data)
            ->addColumn('name', function ($row) {
                $name = $row->cnic . "/" . $row->name;
                return $name;
            })
            ->addColumn('total_amount', function ($row) {

                return number_format($row->total_amount);
            })
           ->addColumn('total_paid', function ($row) {
                        $calculate = $row->down_paid + $row->total_paid;
                return number_format($calculate);
            })
            ->addColumn('total_bal', function ($row) {
                $add = $row->down_paid + $row->total_paid;
                $calculate = $row->total_amount - $add;
                return number_format($calculate);
            })
            ->make(true);
    }
}
