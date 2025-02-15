<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\UpdateProjectRequest;


class ProjectController extends Controller
{

    public function getRecentActiveProjects(Request $request)
    {
        $projects = Project::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        return response()->json($projects, 200);
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


    public function getProjectById($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($project, Response::HTTP_OK);
    }
}
