<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\UpdateProjectRequest;


class ProjectController extends Controller
{

    public function getRecentActiveProjects(Request $request)
    {
        // Fetch active projects sorted by the most recently created
        $projects = Project::where('status', 'active')
            ->orderBy('created_at', 'desc') // Sort by the most recent
            ->take(10) // Limit results to 10
            ->get();

        // Check if any projects exist
        if ($projects->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No projects found.',
            ], 200);
        }

        // Return the projects using the ProjectResource for structured output
        return response()->json([
            'success' => true,
            'data' => ProjectResource::collection($projects),
        ], 200);
    }

    public function updateProject(UpdateProjectRequest $request, $id)
    {
        // Find the project
        $project = Project::find($id);

        // Check if the project exists
        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

        // Update project details
        $project->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully.',
            'data' => new ProjectResource($project),
        ], 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
