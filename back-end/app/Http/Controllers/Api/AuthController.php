<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'message' => 'User registered successfully'
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function login(LogUserRequest $request): JsonResponse
    {
        try {
            if (Auth::attempt($request->only(['email', 'password']))) {
                $user = Auth::user();
                $token = $user->createToken(env('JSON_WEB_TOKEN'))->plainTextToken;

                return response()->json([
                    'message' => 'User successfully logged in',
                    'data' => $user,
                    'token' => $token
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Invalid login credentials'
                ], 401);
            }
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function getAuthUser(): JsonResponse
    {
        if (Auth::check()) {
            return response()->json([
                'success' => true,
                'data' => Auth::user()
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
}
