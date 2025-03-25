<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserStatusController extends Controller
{
    public function toggleUserStatus(Request $request, User $user)
    {
        $user->status = ($user->status === 'blocked' ? 'unblocked' : 'blocked');
        $user->save();

        return response()->json([
            'message' => 'Status successfully updated',
            'user' => $user
        ]);
    }
}
