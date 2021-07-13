<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectPlanRequest;
use App\Models\Project;
use App\Models\ProjectPlan;
use Yajra\DataTables\Facades\DataTables;

class ProjectPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(ProjectPlan::with('project'))
                    ->addIndexColumn()
                    ->addColumn('created_at', function($item) {
                        return $item->created_at != null ? $item->created_at->format('Y-m-d H:i') : '';
                    })
                    ->addColumn('title', function($item) {
                        return $item->project->title;
                    })
                    ->addColumn('total_amount', function($item) {
                        return number_format($item->total_amount);
                    })
                    ->addColumn('sur_charge', function($item) {
                        return $item->sur_charge . '%';
                    })
                    ->addColumn('dealer_commission', function($item) {
                        return $item->dealer_commission . '%';
                    })
                    ->addColumn('installment_years', function($item) {
                        return $item->installment_years . ' Year\'s';
                    })
                    ->addColumn('actions', function($item) {
                        // Allow route for edit then add below for editing purpose.
                        // <a class="btn padding-0 btn-circle" href="'.route('project-plans.edit', $item->id).'">
                        //         <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                        //             <i class="material-icons">mode_edit</i>
                        //         </button>
                        // </a>
                        return '
                            <form class="btn padding-0 btn-circle" action="'.route('project-plans.destroy', $item->id).'" method="POST">
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

        return view('ProjectPlan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all();
        return view('ProjectPlan.add', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectPlanRequest $request)
    {
        $data = $request->validated();
        $data['total_amount'] = str_replace(',', '', $data['total_amount']);
        ProjectPlan::create($data);
        return redirect()->route('project-plans.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectPlan  $projectPlan
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectPlan $projectPlan)
    {
        return view('ProjectPlan.show', compact('projectPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectPlan  $projectPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectPlan $projectPlan)
    {
        $projects = Project::all();
        return view('ProjectPlan.edit', compact('projectPlan', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectPlan  $projectPlan
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectPlanRequest $request, ProjectPlan $projectPlan)
    {
        $data = $request->validated();
        $data['total_amount'] = str_replace(',', '', $data['total_amount']);
        $projectPlan->update($data);
        return redirect()->route('project-plans.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectPlan  $projectPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectPlan $projectPlan)
    {
        $projectPlan->delete();
        return redirect()->route('project-plans.index')->with(['status'=> 'success', 'message'=> 'Record successfully deleted.']);
    }
}
