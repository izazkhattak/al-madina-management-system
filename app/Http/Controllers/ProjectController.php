<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(Project::all())
                    ->addIndexColumn()
                    ->addColumn('created_at', function($item) {
                        return $item->created_at != null ? $item->created_at->format('Y-m-d H:i') : '';
                    })
                    ->addColumn('actions', function($item) {
                        return '
                            <a class="btn padding-0 btn-circle" href="'.route('projects.edit', $item->id).'">
                                <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">mode_edit</i>
                                </button>
                            </a>
                            <form class="btn padding-0 btn-circle" action="'.route('projects.destroy', $item->id).'" method="POST">
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

        return view('Project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Project.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        Project::create($request->validated());
        return redirect()->route('projects.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('Project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('Project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        return redirect()->route('projects.index')->with(['status'=> 'success', 'message'=> 'Record successfully saved.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with(['status'=> 'success', 'message'=> 'Record successfully deleted.']);
    }
}
