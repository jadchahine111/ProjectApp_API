<?php

namespace App\Http\Controllers;

use App\Http\Resources\userProjectResource;
use App\Models\UserProject;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;

class UserProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAppliedProjects($userId)
    {
        // Fetch all project IDs where the user applied
        $appliedProjectIds = UserProject::where('userId', $userId)
            ->where('status', 'applied')
            ->pluck('projectId'); 

        // Check if there are any applied projects
        if ($appliedProjectIds->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No applied projects found for this user.',
            ], 200);
        }

        // Fetch project details based on project IDs
        $projects = Project::whereIn('id', $appliedProjectIds)->get();

        // Return projects as a collection using ProjectResource
        return response()->json([
            'success' => true,
            'data' => ProjectResource::collection($projects),
        ], 200);
    }

    public function getFavoritedProjects($userId)
    {
        // Fetch all project IDs where the user applied
        $favoritedProjectIds = UserProject::where('userId', $userId)
            ->where('status', 'favorited')
            ->pluck('projectId'); 

        // Check if there are any applied projects
        if ($favoritedProjectIds->isEmpty()) {
            return response()->json([
                'success' => false,
                "message" => "You don't have any projects in your favorites",
            ], 200);
        }

        // Fetch project details based on project IDs
        $projects = Project::whereIn('id', $favoritedProjectIds)->get();

        // Return projects as a collection using ProjectResource
        return response()->json([
            'success' => true,
            'data' => ProjectResource::collection($projects),
        ], 200);
    }


    public function getRejectedProjects($userId)
    {
        // Fetch all project IDs where the user applied
        $declinedProjectIds = UserProject::where('userId', $userId)
            ->where('status', 'rejected')
            ->pluck('projectId'); 

        // Check if there are any applied projects
        if ($declinedProjectIds->isEmpty()) {
            return response()->json([
                'success' => false,
                "message" => "You didn't get rejected by any projects",
            ], 200);
        }

        // Fetch project details based on project IDs
        $projects = Project::whereIn('id', $declinedProjectIds)->get();

        // Return projects as a collection using ProjectResource
        return response()->json([
            'success' => true,
            'data' => ProjectResource::collection($projects),
        ], 200);
    }
    

    public function apply($id)
    {
        // Find the UserProject by ID
        $userProject = UserProject::find($id);

        if (!$userProject) {
            return response()->json([
                'success' => false,
                'message' => 'UserProject not found.',
            ], 404);
        }

        // Update the status to "applied"
        $userProject->update([
            'status' => 'applied',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated to applied.',
        ], 200);
    }

    /**
     * Set the status to "rejected".
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function reject($id)
    {
        // Find the UserProject by ID
        $userProject = UserProject::find($id);

        if (!$userProject) {
            return response()->json([
                'success' => false,
                'message' => 'UserProject not found.',
            ], 404);
        }

        // Update the status to "rejected"
        $userProject->update([
            'status' => 'rejected',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated to rejected.',
        ], 200);
    }
    public function archiveProject($projectId)
    {
        // Find the Project by ID
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

        // Update the project status to "archived"
        $project->update([
            'status' => 'archived',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Project has been archived.',
        ], 200);
    }
    public function unarchiveProject($projectId)
    {
        // Find the Project by ID
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

        // Check if the project is already active
        if ($project->status === 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Project is already active.',
            ], 400);
        }

        // Update the project status to "active"
        $project->update([
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Project has been removed from archived status.',
        ], 200);
    }
    public function deleteProject($projectId)
    {
        // Find the Project by ID
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

        // Delete the project
        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully.',
        ], 200);
    }
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
     * @param  \App\Models\UserProject  $userProject
     * @return \Illuminate\Http\Response
     */
    public function show(UserProject $userProject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserProject  $userProject
     * @return \Illuminate\Http\Response
     */
    public function edit(UserProject $userProject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserProject  $userProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserProject $userProject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserProject  $userProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProject $userProject)
    {
        //
    }
}
