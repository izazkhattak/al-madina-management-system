<?php

namespace App\Http\Controllers;

use App\Events\ReportEvent;
use App\Http\Requests\InstallmentRequest;
use App\Models\Client;
use App\Models\Installment;
use App\Models\ProjectPlan;

class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $installments = Installment::with('client.projectPlan')->get();
        return view('Installments.index', compact('installments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients  = Client::all();
        return view('Installments.add', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstallmentRequest $request)
    {
        $data = $request->validated();
        $data['amount_paid'] = $amountPaid = str_replace(',', '', $data['amount_paid']);

        $getClient = Client::find($data['client_id']);
        $getProjectPlan = $getClient->projectPlan;
        $clientDueDate = $getClient->due_date;
        $amountPlenty = '0';

        if ($data['payment_date'] > $clientDueDate) {
            // Applied Plenty to amount_paid field.
            $surCharge = $getProjectPlan->sur_charge;
            $amountPlenty = $amountPaid * ($surCharge / 100);
            $data['amount_paid'] = $amountPaid + $amountPlenty;
        }

        // Calculated Remaining amount
        $getTotalPaidAmountByClient = Installment::where('client_id', $data['client_id'])->sum('amount_paid');

        // Substract Plenty Amount from previous tatal amount paid by client.
        $getTotalPlentyAmount = Installment::where('client_id', $data['client_id'])->sum('plenty');
        $getTotalPaidAmountByClient = $getTotalPaidAmountByClient - $getTotalPlentyAmount;

        $totalAmount = $getProjectPlan->total_amount;
        $data['remaining_amount'] = $totalAmount - $getTotalPaidAmountByClient - $amountPaid;

        $data['plenty'] = $amountPlenty;

        $installment = Installment::create($data);
        ReportEvent::dispatch($installment);
        return redirect()->route('installments.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function show(Installment $installment)
    {
        return view('Installments.show', compact('installment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function edit(Installment $installment)
    {
        $clients  = Client::all();
        return view('Installments.edit', compact('clients', 'installment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function update(InstallmentRequest $request, Installment $installment)
    {
        $data = $request->validated();
        $data['amount_paid'] = $amountPaid = str_replace(',', '', $data['amount_paid']);

        $getClient = Client::find($data['client_id']);
        $getProjectPlan = $getClient->projectPlan;
        $clientDueDate = $getClient->due_date;
        $amountPlenty = '0';

        if ($data['payment_date'] > $clientDueDate) {
            // Applied Plenty to amount_paid field.
            $surCharge = $getProjectPlan->sur_charge;
            $amountPlenty = $amountPaid * ($surCharge / 100);
            $data['amount_paid'] = $amountPaid + $amountPlenty;
        }

        // Calculated Remaining amount
        $getTotalPaidAmountByClient = $installment->where('client_id', $data['client_id'])->sum('amount_paid');

        // Substract Plenty Amount from previous tatal amount paid by client.
        $getTotalPlentyAmount = $installment->where('client_id', $data['client_id'])->sum('plenty');
        $getTotalPaidAmountByClient = $getTotalPaidAmountByClient - $getTotalPlentyAmount;

        $totalAmount = $getProjectPlan->total_amount;
        $data['remaining_amount'] = $totalAmount - $getTotalPaidAmountByClient - $amountPaid;

        $data['plenty'] = $amountPlenty;

        $installment->update($data);
        $installment->is_updated = 'yes';
        ReportEvent::dispatch($installment);
        return redirect()->route('installments.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Installment $installment)
    {
        $installment->delete();
        return redirect()->route('installments.index')->with(['status'=> 'success', 'message'=> 'Record successfully deleted.']);
    }
}
