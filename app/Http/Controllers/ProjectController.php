<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\UserProject;
use Illuminate\Support\Facades\Auth;


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
        // Fetch the project by ID
        $project = Project::find($id);
    
        // If the project does not exist, return a 404 response
        if (!$project) {
            return response()->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }
    
        // Get the authenticated user's ID
        $userId = Auth::id();
    
        // Check if the project is saved (favorited) by the user
        $isSaved = UserProject::where('userId', $userId)
                              ->where('projectId', $id)
                              ->where('status', 'favorited')
                              ->exists();
    
        // Check if the project has been applied for by the user
        $isApplied = UserProject::where('userId', $userId)
                                ->where('projectId', $id)
                                ->where('status', 'applied')
                                ->exists();
    
        // Append the isSaved and isApplied attributes to the project
        $project->isSaved = $isSaved;
        $project->isApplied = $isApplied;
    
        // Return the project with the additional attributes
        return response()->json($project, Response::HTTP_OK);
    }
    

    public function getProjectsByCategory($categoryId)
    {
        // Retrieve projects matching the given category ID and where status is 'active'
        $projects = Project::where('categoryId', $categoryId)
                           ->where('status', 'active')
                           ->get();
    
        // Return the projects as a JSON response.
        // Even if the result is empty, an empty array will be returned.
        return response()->json($projects, 200);
    }
    
    public function getFilteredProjects(Request $request)
    {
        // Retrieve query parameters with defaults
        $query = $request->query('query', '');
        $minAmount = $request->query('minAmount', 0);
        // You can set a sensible high default; here we use PHP_INT_MAX
        $maxAmount = $request->query('maxAmount', PHP_INT_MAX);
        $categoryId = $request->query('categoryId', 0);

        // Build the query
        $projectsQuery = Project::query();

        if (!empty($query)) {
            $projectsQuery->where('title', 'like', "%{$query}%");
        }

        $projectsQuery->whereBetween('amount', [$minAmount, $maxAmount]);

        if ($categoryId != 0) {
            $projectsQuery->where('categoryId', $categoryId);
        }

        $projects = $projectsQuery->get();

        // If no projects are found, return an empty JSON object {} (instead of an empty array)
        if ($projects->isEmpty()) {
            return response()->json([], 200);
        }

        return response()->json($projects, 200);
    }
}
