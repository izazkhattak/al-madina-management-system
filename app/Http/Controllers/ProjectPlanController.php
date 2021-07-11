<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectPlanRequest;
use App\Models\Project;
use App\Models\ProjectPlan;

class ProjectPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = ProjectPlan::all();
        return view('ProjectPlan.index', compact('plans'));
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
