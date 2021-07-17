<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealerRequest;
use App\Models\Dealer;
use App\Models\ProjectPlan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(Dealer::with('projectPlan'))
                    ->addIndexColumn()
                    ->addColumn('project', function($item) {
                        return $item->projectPlan->project->title;
                    })
                    ->addColumn('project_plan', function($item) {
                        return $item->projectPlan->installment_years . ' Years';
                    })
                    ->addColumn('total_amount', function($item) {
                        return number_format($item->total_amount);
                    })
                    ->addColumn('created_at', function($item) {
                        return $item->created_at != null ? $item->created_at->format('Y-m-d H:i') : '';
                    })
                    ->addColumn('actions', function($item) {
                        return '
                            <a class="btn padding-0 btn-circle" href="'.route('dealers.edit', $item->id).'">
                                <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">mode_edit</i>
                                </button>
                            </a>
                            <form class="btn padding-0 btn-circle" action="'.route('dealers.destroy', $item->id).'" method="POST">
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

        return view('Dealers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projectPlan  = ProjectPlan::with('project')->get();
        return view('Dealers.add', compact('projectPlan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerRequest $request)
    {
        $data = $request->validated();
        // $data['down_payment'] = str_replace(',', '', $data['down_payment']);
        $data['total_amount'] = str_replace(',', '', $data['total_amount']);

        $getProjectPlan = ProjectPlan::find($data['project_plan_id']);

        $totalAmount = $data['total_amount'];
        $installmentYearMonths = $getProjectPlan->installment_years * 12;

        // Calculated monthly installments;
        $data['monthly_installments'] = $totalAmount / $installmentYearMonths;

        Dealer::create($data);
        return redirect()->route('dealers.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function show(Dealer $dealer)
    {
        if (request()->ajax()) {
            return response()->json(['success'=> true, 'data'=> $dealer]);
        }
        return view('Dealers.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function edit(Dealer $dealer)
    {
        $projectPlan  = ProjectPlan::all();
        $installmentStarted = ProjectPlan::find($dealer->project_plan_id)->dealerInstallment;
        $isEditableProjectPlan = $installmentStarted->count() > 0 ? 'no' : 'yes';
        return view('Dealers.edit', compact('dealer', 'projectPlan', 'isEditableProjectPlan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function update(DealerRequest $request, Dealer $dealer)
    {
        $data = $request->validated();
        // $data['down_payment'] = str_replace(',', '', $data['down_payment']);
        $data['total_amount'] = str_replace(',', '', $data['total_amount']);

        $installmentStarted = ProjectPlan::find($dealer->project_plan_id)->dealerInstallment;
        $data['project_plan_id'] = $installmentStarted->count() > 0 ? $dealer->project_plan_id : $data['project_plan_id'];

        // Get reguest updated Plan id to calculate monthly installments.
        $getProjectPlan = ProjectPlan::find($data['project_plan_id']);

        $totalAmount = $data['total_amount'];
        $installmentYearMonths = $getProjectPlan->installment_years * 12;
        // Calculated monthly installments;
        $data['monthly_installments'] = $totalAmount / $installmentYearMonths;

        $dealer->update($data);
        return redirect()->route('dealers.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dealer $dealer)
    {
        $dealer->delete();
        return redirect()->route('dealers.index')->with(['status'=> 'success', 'message'=> 'Record successfully deleted.']);
    }
}
