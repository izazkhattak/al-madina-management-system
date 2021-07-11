<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\ProjectPlan;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Client::all();
        return view('Clients.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projectPlan  = ProjectPlan::all();
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
