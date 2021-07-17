<?php

namespace App\Http\Controllers;

use App\Events\ClientReportEvent;
use App\Http\Requests\ClientInstallmentRequest;
use App\Models\Client;
use App\Models\ClientInstallment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClientInstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(ClientInstallment::with('client.projectPlan'))
                    ->addIndexColumn()
                    ->addColumn('created_at', function($item) {
                        return $item->created_at != null ? $item->created_at->format('Y-m-d H:i') : '';
                    })
                    ->addColumn('project', function($item) {
                        return $item->client->projectPlan->project->title.' - '.$item->client->projectPlan->installment_years. ' Years';
                    })
                    ->addColumn('name', function($item) {
                        return $item->client->name;
                    })
                    ->addColumn('amount_paid', function($item) {
                        return number_format($item->amount_paid);
                    })
                    ->addColumn('remaining_amount', function($item) {
                        return number_format($item->remaining_amount);
                    })
                    ->addColumn('payment_method', function($item) {
                        return isset(config('al_madina.cheque_draft_options')[$item->payment_method]) ? config('al_madina.cheque_draft_options')[$item->payment_method] : 'Other';
                    })
                    // ->addColumn('dealer_commission', function($item) {
                    //     return $item->plenty > 0 ? number_format(($item->amount_paid - $item->plenty) * ( $item->client->projectPlan->dealer_commission / 100 )) : 0;
                    // })
                    ->addColumn('actions', function($item) {
                        return '
                            <a class="btn padding-0 btn-circle" href="'.route('client-installments.edit', $item->id).'">
                                <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">mode_edit</i>
                                </button>
                            </a>
                            <form class="btn padding-0 btn-circle" action="'.route('client-installments.destroy', $item->id).'" method="POST">
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

        return view('ClientInstallments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients  = Client::all();
        return view('ClientInstallments.add', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientInstallmentRequest $request)
    {
        $data = $request->validated();
        $data['amount_paid'] = $amountPaid = str_replace(',', '', $data['amount_paid']);

        $getClient = Client::find($data['client_id']);
        $getProjectPlan = $getClient->projectPlan;
        $clientDueDate = $getClient->due_date;
        $todaydate = $data['payment_date'];
        $todayday = date("d",strtotime($todaydate));;
        $todaymonth = date("m",strtotime($todaydate));
        $todayYear = date("Y",strtotime($todaydate));
        $clientDueday = date("d",strtotime($clientDueDate));;
        $clientDuemonth = date("m",strtotime($clientDueDate));
        $clientDueYear = date("Y",strtotime($clientDueDate));

        $amountPlenty = '0';

        if ($todayday > $clientDueday && $todaymonth == $clientDuemonth && $todayYear == $clientDueYear) {
            // Applied Plenty to amount_paid field.
            $surCharge = $getProjectPlan->sur_charge;
            $amountPlenty = $amountPaid * ($surCharge / 100);
            $data['amount_paid'] = $amountPaid + $amountPlenty;
        }

        // Calculated Remaining amount
        $getTotalPaidAmountByClient = ClientInstallment::where('client_id', $data['client_id'])->sum('amount_paid');

        // Substract Plenty Amount from previous tatal amount paid by client.
        $getTotalPlentyAmount = ClientInstallment::where('client_id', $data['client_id'])->sum('plenty');
        $getTotalPaidAmountByClient = $getTotalPaidAmountByClient - $getTotalPlentyAmount;

        $totalAmount = $getClient->total_amount - $getClient->down_payment;
        $data['remaining_amount'] = $totalAmount - $getTotalPaidAmountByClient - $amountPaid;

        if ($data['remaining_amount'] < 0) {
            return redirect()->back()->with(['status'=> 'danger', 'message'=> 'Amount can be greater then remaining amount.']);
        }

        $data['plenty'] = $amountPlenty;

        $installment = ClientInstallment::create($data);
        ClientReportEvent::dispatch($installment);
        return redirect()->route('client-installments.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientInstallment  $clientInstallment
     * @return \Illuminate\Http\Response
     */
    public function show(ClientInstallment $clientInstallment)
    {
        return view('ClientInstallments.show', compact('clientInstallment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientInstallment  $clientInstallment
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientInstallment $clientInstallment)
    {
        $clients  = Client::all();
        return view('ClientInstallments.edit', compact('clients', 'clientInstallment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientInstallment  $clientInstallment
     * @return \Illuminate\Http\Response
     */
    public function update(ClientInstallmentRequest $request, ClientInstallment $clientInstallment)
    {
        $data = $request->validated();
        $data['amount_paid'] = $amountPaid = str_replace(',', '', $data['amount_paid']);

        $getClient = Client::find($data['client_id']);

        $getProjectPlan = $getClient->projectPlan;
        $clientDueDate = $getClient->due_date;
        $todaydate = $data['payment_date'];
        $todayday = date("d",strtotime($todaydate));;
        $todaymonth = date("m",strtotime($todaydate));
        $todayYear = date("Y",strtotime($todaydate));
        $clientDueday = date("d",strtotime($clientDueDate));;
        $clientDuemonth = date("m",strtotime($clientDueDate));
        $clientDueYear = date("Y",strtotime($clientDueDate));

        $amountPlenty = '0';

        if ($todayday > $clientDueday && $todaymonth == $clientDuemonth && $todayYear == $clientDueYear) {
            // Applied Plenty to amount_paid field.
            $surCharge = $getProjectPlan->sur_charge;
            $amountPlenty = $amountPaid * ($surCharge / 100);
            $data['amount_paid'] = $amountPaid + $amountPlenty;
        }

        // Calculated Remaining amount
        $getTotalPaidAmountByClient = $clientInstallment->where('id', '<', $clientInstallment->id)->where('client_id', $data['client_id'])->sum('amount_paid');

        // Substract Plenty Amount from previous tatal amount paid by client.
        $getTotalPlentyAmount = $clientInstallment->where('id', '<', $clientInstallment->id)->where('client_id', $data['client_id'])->sum('plenty');
        $getTotalPaidAmountByClient = $getTotalPaidAmountByClient - $getTotalPlentyAmount;

        $totalAmount = $getClient->total_amount - $getClient->down_payment;
        $data['remaining_amount'] = $totalAmount - $getTotalPaidAmountByClient - $amountPaid;

        if ($data['remaining_amount'] < 0) {
            return redirect()->back()->with(['status'=> 'danger', 'message'=> 'Amount can be greater then remaining amount.']);
        }

        $data['plenty'] = $amountPlenty;

        $clientInstallment->update($data);
        $clientInstallment->is_updated = 'yes';
        ClientReportEvent::dispatch($clientInstallment);
        return redirect()->route('client-installments.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientInstallment  $clientInstallment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientInstallment $clientInstallment)
    {
        $clientInstallment->delete();
        return redirect()->route('client-installments.index')->with(['status'=> 'success', 'message'=> 'Record successfully deleted.']);
    }
}
