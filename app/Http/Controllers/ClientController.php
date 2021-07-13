<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\ProjectPlan;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(Client::all())
                    ->addIndexColumn()
                    ->addColumn('project', function($item) {
                        return $item->projectPlan->project->title;
                    })
                    ->addColumn('total_amount', function($item) {
                        return number_format($item->projectPlan->total_amount) . ' - ' .$item->projectPlan->installment_years.' Years';
                    })
                    ->addColumn('down_payment', function($item) {
                        return number_format($item->down_payment);
                    })
                    ->addColumn('created_at', function($item) {
                        return $item->created_at != null ? $item->created_at->format('Y-m-d H:i') : '';
                    })
                    ->addColumn('actions', function($item) {
                        return '
                            <a class="btn padding-0 btn-circle" href="'.route('clients.edit', $item->id).'">
                                <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">mode_edit</i>
                                </button>
                            </a>
                            <form class="btn padding-0 btn-circle" action="'.route('clients.destroy', $item->id).'" method="POST">
                                <input type="hidden" name="_method" value="delete" />
                                <input type="hidden" name="_token" value="'. csrf_token() .'">
                                <button type="submit" class="btn bg-pink btn-circle waves-effect waves-circle waves-float" data-type="form-confirm">
                                    <i class="material-icons">delete_forever</i>
                                </button>
                            </form>
                        ';
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
        }

        return view('Clients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projectPlan  = ProjectPlan::with('project')->get();
        return view('Clients.add', compact('projectPlan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $data = $request->validated();
        $data['down_payment'] = str_replace(',', '', $data['down_payment']);

        $getProjectPlan = ProjectPlan::find($data['project_plan_id']);

        $totalAmount = $getProjectPlan->total_amount;
        $installmentYearMonths = $getProjectPlan->installment_years * 12;

        // Calculated monthly installments;
        $totalMonthyInstallmentsAmount = ($totalAmount - $data['down_payment']) / $installmentYearMonths;

        $data['monthly_installments'] = $totalMonthyInstallmentsAmount;

        Client::create($data);
        return redirect()->route('clients.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        if (request()->ajax()) {
            return response()->json(['success'=> true, 'data'=> $client]);
        }
        return view('Clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $projectPlan  = ProjectPlan::all();
        $installmentStarted = ProjectPlan::find($client->project_plan_id)->installment;
        $isEditableProjectPlan = $installmentStarted->count() > 0 ? 'no' : 'yes';
        return view('Clients.edit', compact('client', 'projectPlan', 'isEditableProjectPlan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        $data = $request->validated();
        $data['down_payment'] = str_replace(',', '', $data['down_payment']);

        $installmentStarted = ProjectPlan::find($client->project_plan_id)->installment;
        $data['project_plan_id'] = $installmentStarted->count() > 0 ? $client->project_plan_id : $data['project_plan_id'];

        $client->update($data);
        return redirect()->route('clients.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with(['status'=> 'success', 'message'=> 'Record successfully deleted.']);
    }
}
