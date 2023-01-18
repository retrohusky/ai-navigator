<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Auth\Entities\User;

class EmailVerificationController extends Controller
{
    public function verify($id): JsonResponse
    {
        /**
         * @var User $user
         */
        try {
            $user = User::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('There was a problem with finding the user.', [
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }

        if ( $user->markEmailAsVerified() ) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'error'
        ], 400);
    }

    public function resend(Request $request): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = User::where( 'email', $request->get('email') )->first();

        if ( $user->hasVerifiedEmail() ) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
