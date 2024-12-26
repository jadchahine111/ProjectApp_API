<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    // Accept User Registration
    public function acceptUserRegistration($userId)
    {
        // Find the user by ID
        $user = User::find($userId);

        // Check if user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update registration status to accepted
        $user->registrationStatus = 'accepted';
        $user->save();

        // Send acceptance email
        $this->sendAcceptanceEmail($user);

        return response()->json(['message' => 'User registration accepted successfully']);
    }

    // Send Acceptance Email
    protected function sendAcceptanceEmail(User $user)
    {
        // Send email using Laravel's Mail facade
        Mail::send([], [], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your Registration Has Been Accepted')
                    ->setBody("Dear {$user->firstName} {$user->lastName},<br><br>Your registration has been accepted!", 'text/html');
        });
    }

    public function declineUserRegistration($userId)
    {
        // Find the user by ID
        $user = User::find($userId);

        // Check if user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Delete the user from the database
        $user->delete();

        // Send rejection email
        $this->sendRejectionEmail($user);

        return response()->json(['message' => 'User registration declined and user deleted']);
    }    

    // Send Rejection Email
    protected function sendRejectionEmail(User $user)
    {
        // Send email using Laravel's Mail facade
        Mail::send([], [], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your Registration Has Been Rejected')
                    ->setBody("Dear {$user->firstName} {$user->lastName},<br><br>We regret to inform you that your registration has been rejected.<br><br>Best regards,<br>Your Team", 'text/html');
        });
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
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
