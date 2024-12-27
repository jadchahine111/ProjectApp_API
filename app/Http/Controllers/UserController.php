<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest; // Import the custom request

class UserController extends Controller
{

    public function updateUserDetails(UpdateUserRequest $request, $id)
    {
        // Fetch the user
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update the user details
        $user->username = $request->input('username', $user->username);
        $user->firstName = $request->input('firstName', $user->firstName);
        $user->lastName = $request->input('lastName', $user->lastName);
        $user->bio = $request->input('bio', $user->bio);
        $user->linkedinURL = $request->input('linkedinURL', $user->linkedinURL);
        $user->skills = $request->input('skills', $user->skills);

        // Handle CV upload
        if ($request->hasFile('CV')) {
            $cvPath = $request->file('CV')->store('CVs', 'public');
            $user->CV = $cvPath;
        }

        // Save the updated user
        $user->save();

        return response()->json(['message' => 'User details updated successfully', 'user' => $user], 200);
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    // Fetch the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Return the user details as a JSON response
        return response()->json(['user' => $user], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
