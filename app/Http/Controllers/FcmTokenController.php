<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    /**
     * Store the FCM token for the authenticated user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        // Support both standard Laravel Auth and custom AuthGuards that set $request->user()
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $user->fcm_token = $request->fcm_token;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'FCM token saved successfully.',
        ]);
    }
}
