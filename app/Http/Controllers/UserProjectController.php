<?php

namespace App\Http\Controllers;

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
