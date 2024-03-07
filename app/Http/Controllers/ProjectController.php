<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponse(Project::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $project = Project::create($request->all());

        return $this->successResponse('Added success', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->successResponse(Project::findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return $this->successResponse('Project has been updated', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return $this->successResponse('Project deleted', $project);
    }
}
