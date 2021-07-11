<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallmentRequest;
use App\Models\Client;
use App\Models\Installment;

class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $installments = Installment::all();
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
        $data['amount_paid'] = str_replace(',', '', $data['amount_paid']);
        $data['remaining_amount'] = str_replace(',', '', $data['remaining_amount']);

        $clientDueDate = Client::find($data['client_id'])->due_date;
        $plenty = 'No';

        if ($data['payment_date'] > $clientDueDate) {
            $plenty = 'Yes';
        }

        $data['plenty'] = $plenty;
        Installment::create($data);
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
        $data['amount_paid'] = str_replace(',', '', $data['amount_paid']);
        $data['remaining_amount'] = str_replace(',', '', $data['remaining_amount']);

        $clientDueDate = Client::find($data['client_id'])->due_date;
        $plenty = 'No';

        if ($data['payment_date'] > $clientDueDate) {
            $plenty = 'Yes';
        }

        $data['plenty'] = $plenty;

        $installment->update($data);
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
