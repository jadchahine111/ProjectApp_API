<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notifications;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Get notifications for a specific user.
     *
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotifications($userId)
    {
      
        $notifications = Notifications::where('userId', $userId)->get();

        if ($notifications->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'No notifications found for this user.',
            ], 200);
        }


        return response()->json([
            'success' => true,
            'data' => NotificationResource::collection($notifications),
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
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notifications $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notifications $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notifications $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notifications $notification)
    {
        //
    }
}
