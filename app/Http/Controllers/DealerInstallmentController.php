<?php

namespace App\Http\Controllers;

use App\Events\DealerReportEvent;
use App\Http\Requests\DealerInstallmentRequest;
use App\Models\Dealer;
use App\Models\DealerInstallment;
use Yajra\DataTables\Facades\DataTables;

class DealerInstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(DealerInstallment::with('dealer.projectPlan'))
                    ->addIndexColumn()
                    ->addColumn('created_at', function($item) {
                        return $item->created_at != null ? $item->created_at->format('Y-m-d H:i') : '';
                    })
                    ->addColumn('project', function($item) {
                        return $item->dealer->projectPlan->project->title.' - '.$item->dealer->projectPlan->installment_years. ' Years';
                    })
                    ->addColumn('name', function($item) {
                        return $item->dealer->name;
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
                    //     return $item->plenty > 0 ? number_format(($item->amount_paid - $item->plenty) * ( $item->dealer->projectPlan->dealer_commission / 100 )) : 0;
                    // })
                    ->addColumn('actions', function($item) {
                        return '
                            <a class="btn padding-0 btn-circle" href="'.route('dealer-installments.edit', $item->id).'">
                                <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">mode_edit</i>
                                </button>
                            </a>
                            <form class="btn padding-0 btn-circle" action="'.route('dealer-installments.destroy', $item->id).'" method="POST">
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

        return view('DealerInstallments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dealers  = Dealer::with('projectPlan.project')->get();
        return view('DealerInstallments.add', compact('dealers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerInstallmentRequest $request)
    {
        $data = $request->validated();
        $data['amount_paid'] = $amountPaid = str_replace(',', '', $data['amount_paid']);

        $getDealer = Dealer::find($data['dealer_id']);

        // Calculated Remaining amount
        $getTotalPaidAmountByDealer = DealerInstallment::where('dealer_id', $data['dealer_id'])->sum('amount_paid');

        $totalAmount = $getDealer->total_amount;
        $data['remaining_amount'] = $totalAmount - $getTotalPaidAmountByDealer - $amountPaid;

        if ($data['remaining_amount'] < 0) {
            return redirect()->back()->with(['status'=> 'danger', 'message'=> 'Amount can be greater then remaining amount.']);
        }

        $installment = DealerInstallment::create($data);
        DealerReportEvent::dispatch($installment);
        return redirect()->route('dealer-installments.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DealerInstallment  $dealerInstallment
     * @return \Illuminate\Http\Response
     */
    public function show(DealerInstallment $dealerInstallment)
    {
        return view('DealerInstallments.show', compact('dealerInstallment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DealerInstallment  $dealerInstallment
     * @return \Illuminate\Http\Response
     */
    public function edit(DealerInstallment $dealerInstallment)
    {
        $dealers = Dealer::all();
        return view('DealerInstallments.edit', compact('dealers', 'dealerInstallment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DealerInstallment  $dealerInstallment
     * @return \Illuminate\Http\Response
     */
    public function update(DealerInstallmentRequest $request, DealerInstallment $dealerInstallment)
    {
        $data = $request->validated();
        $data['amount_paid'] = $amountPaid = str_replace(',', '', $data['amount_paid']);

        $getDealer = Dealer::find($data['dealer_id']);

        // Calculated Remaining amount
        $getTotalPaidAmountByDealer = DealerInstallment::where('id', '<', $dealerInstallment->id)->where('dealer_id', $data['dealer_id'])->sum('amount_paid');

        $totalAmount = $getDealer->total_amount;
        $data['remaining_amount'] = $totalAmount - $getTotalPaidAmountByDealer - $amountPaid;

        if ($data['remaining_amount'] < 0) {
            return redirect()->back()->with(['status'=> 'danger', 'message'=> 'Amount can be greater then remaining amount.']);
        }

        $dealerInstallment->update($data);
        if ($dealerInstallment->remaining_amount <= 0) {
            $dealerInstallment->where('id', '>', $dealerInstallment->id)->where('dealer_id', $data['dealer_id'])->delete();
        }
        DealerReportEvent::dispatch($dealerInstallment);
        return redirect()->route('dealer-installments.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DealerInstallment  $dealerInstallment
     * @return \Illuminate\Http\Response
     */
    public function destroy(DealerInstallment $dealerInstallment)
    {
        $dealerInstallment->delete();
        return redirect()->route('dealer-installments.index')->with(['status'=> 'success', 'message'=> 'Record successfully deleted.']);
    }
}
