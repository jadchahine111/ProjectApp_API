<?php

namespace App\Http\Controllers;

use App\Http\Requests\projectPostRequest;
use App\Http\Resources\userProjectResource;
use App\Models\UserProject;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\Auth;

class UserProjectController extends Controller
{

    public function getAppliedUsersForProject(Request $request, $projectId)
    {
        // Fetch all user IDs where the status is 'applied' for the given project
        $appliedUserIds = UserProject::where('projectId', $projectId)
            ->where('status', 'applied')
            ->pluck('userId');
        
        // If there are no applied users, return an empty array
        if ($appliedUserIds->isEmpty()) {
            return response()->json([], 200);
        }

        // Retrieve the User models for the given IDs
        $users = User::whereIn('id', $appliedUserIds)->get();

        // Return the users as JSON (an array of user objects)
        return response()->json($users, 200);
    }

    /**
     * Accept an applicant for a project.
     * Updates the status to 'accepted' and returns a JSON response.
     */
    public function acceptProjectApplicant(Request $request, $projectId, $userId)
    {
        // Find the UserProject record matching the project and user
        $userProject = UserProject::where('projectId', $projectId)
            ->where('userId', $userId)
            ->first();

        if (!$userProject) {
            return response()->json(['error' => 'Application not found'], 404);
        }

        // Update the status to 'accepted'
        $userProject->status = 'accepted';
        $userProject->save();

            // Create the notification message
    // $message = 'Congratulations! You have been accepted to the project: ' . $project->title;

    // Create and save the notification for the user
    // Notifications::create([
       //  'user_id' => $userId,  // Assuming the 'user_id' column exists in the Notifications table
        // 'message' => $message
    // ]);

        return response()->json([
            'success' => true,
            'message' => 'Applicant accepted successfully'
        ], 200);
    }

    /**
     * Decline an applicant for a project.
     * Updates the status to 'declined' and returns a JSON response.
     */
    public function declineProjectApplicant(Request $request, $projectId, $userId)
    {
        // Find the UserProject record matching the project and user
        $userProject = UserProject::where('projectId', $projectId)
            ->where('userId', $userId)
            ->first();

        if (!$userProject) {
            return response()->json(['error' => 'Application not found'], 404);
        }

        // Update the status to 'declined'
        $userProject->status = 'rejected    ';
        $userProject->save();

        return response()->json([
            'success' => true,
            'message' => 'Applicant declined successfully'
        ], 200);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAppliedProjects()
    {

        $userId = Auth::id();

        // Fetch all project IDs where the user applied
        $appliedProjectIds = UserProject::where('userId', $userId)
            ->where('status', 'applied')
            ->pluck('projectId'); 

        // Check if there are any applied projects
        if ($appliedProjectIds->isEmpty()) {
            return response()->json([], 200);

        }

        // Fetch project details based on project IDs
        $projects = Project::whereIn('id', $appliedProjectIds)->get();

        // Return projects as a collection using ProjectResource
        return response()->json( $projects , 200);
    }
    public function getFavoritedProjects()
    {
        $userId = Auth::id();
    
        // Fetch all project IDs where the user favorited
        $favoritedProjectIds = UserProject::where('userId', $userId)
            ->where('status', 'favorited')
            ->pluck('projectId');
    
        // Return an empty JSON object if there are no favorited projects
        if ($favoritedProjectIds->isEmpty()) {
            return response()->json([], 200);
        }
    
        // Fetch project details based on project IDs
        $projects = Project::whereIn('id', $favoritedProjectIds)->get();
    
        // Return projects as a JSON response
        return response()->json($projects, 200);
    }
    


    public function getRejectedProjects()
    {
        
        $userId = Auth::id();

        // Fetch all project IDs where the user applied
        $declinedProjectIds = UserProject::where('userId', $userId)
            ->where('status', 'rejected')
            ->pluck('projectId'); 

        // Check if there are any applied projects
        if ($declinedProjectIds->isEmpty()) {
            return response()->json([], 200);
        }

        // Fetch project details based on project IDs
        $projects = Project::whereIn('id', $declinedProjectIds)->get();

        // Return projects as a collection using ProjectResource
        return response()->json($projects);
        }
    public function getAcceptedProjects()
    {
        
        $userId = Auth::id();

        // Fetch all project IDs where the user applied
        $acceptedProjectIds = UserProject::where('userId', $userId)
            ->where('status', 'accepted')
            ->pluck('projectId'); 

        // Check if there are any applied projects
        if ($acceptedProjectIds->isEmpty()) {
            return response()->json([], 200);

        }

        // Fetch project details based on project IDs
        $projects = Project::whereIn('id', $acceptedProjectIds)->get();

        // Return projects as a collection using ProjectResource
        return response()->json($projects);
    }
    

    public function apply($id)
    {
        $userId = Auth::id();
    
        // Check if the user has already applied to the project
        $userProject = UserProject::where('userId', $userId)
                                  ->where('projectId', $id)
                                  ->first();
    
        if ($userProject) {
            return response()->json([
                'success' => true,
                'message' => 'You already applied to this project.',
            ], 200);
        }
    
        // Create a new record in UserProject and set status to "applied"
        UserProject::create([
            'userId' => $userId,
            'projectId' => $id,
            'status' => 'applied',
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'You have successfully applied to the project.',
        ], 201); // 201 indicates resource created
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
    public function postAProject(projectPostRequest $request)
    {
        // Get validated data
        $data = $request->validated();
    
        // Add the authenticated user ID
        $data['userId'] = auth()->id();
    
        // Create the project with the validated data
        Project::create($data);
    
        return response()->json([
            'success' => true,
            'message' => 'Project added successfully.',
        ], 201);
    }
    
    public function addProjectToFav($id)
    {
        $userId = Auth::id();
    
        // ✅ Ensure user ID is not null
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID is missing. Please check authentication.',
            ], 400);
        }
    
        // Find the UserProject by userId and projectId
        $userProject = UserProject::where('userId', $userId)
            ->where('projectId', $id)
            ->first();
    
        if ($userProject) {
            if ($userProject->status == 'rejected') {
                return response()->json([
                    'success' => true,
                    'message' => 'You have already been rejected for this project.',
                ], 200);
            }
            if ($userProject->status == 'favorited') {
                return response()->json([
                    'success' => true,
                    'message' => 'This project is already favorited.',
                ], 200);
            }
        }
    
        // ✅ Insert userId properly
        UserProject::create([
            'userId' => $userId,  
            'projectId' => $id,
            'status' => 'favorited',
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Added to favorites.',
        ], 200);
    }
    
    
    
    public function remProjectFromFav($projectId)
    {
        // Log the ID and user for debugging purposes
        \Log::info('Project ID: ' . $projectId);
        \Log::info('Authenticated User ID: ' . auth()->user()->id);
    
        // Find the UserProject by projectId and authenticated userId
        $userProject = UserProject::where('projectId', $projectId)
                                  ->where('userId', auth()->user()->id)  // Ensure it's the authenticated user
                                  ->first();
    
        if (!$userProject) {
            return response()->json([
                'success' => false,
                'message' => 'UserProject not found for this user and project.',
            ], 404);
        }
    
        // Delete the UserProject record
        $userProject->delete();
    
        return response()->json([
            'success' => 'Project removed from favorites successfully.',
        ], 200);
    }
    
    

    public function getUserArchivedProjects()
    {
        
        $userId = Auth::id();

        // Get projects that are associated with the user and have a status of 'archived'
        $projects = Project::where('userId', $userId)
                            ->where('status', 'archived')  // Filter projects with 'archived' status
                            ->get();

        // Check if the user has posted any projects
        if ($projects->isEmpty()) {
            return response()->json([], 200);

        }

        // Return the projects as a collection using ProjectResource
        return response()->json($projects);
    }

    
    public function getUserActiveProjects()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }
    
        $userId = Auth::guard('sanctum')->id();
    
        // Get projects associated with the user
        $projects = Project::where('userId', $userId)
                            ->where('status', 'active')
                            ->get();
    
        if ($projects->isEmpty()) {
            return response()->json([], 200);

        }
    
        return response()->json($projects, 200);
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
